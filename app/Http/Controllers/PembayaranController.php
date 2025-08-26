<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    // INDEX: untuk keuangan melihat semua tagihan
    public function index(Request $request)
    {
        $query = Pembayaran::with(['konsultasi.klien', 'konsultasi.advokat']);

        if ($request->filled('klien')) {
            $query->whereHas('konsultasi.klien', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->klien . '%');
            });
        }

        if ($request->filled('advokat')) {
            $query->whereHas('konsultasi.advokat', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->advokat . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $pembayarans = $query->latest()->paginate($request->get('per_page', 10))
                            ->appends($request->query());

        return view('pembayaran.index', compact('pembayarans'));
    }

    public function create()
    {
        $konsultasis = Konsultasi::with(['klien', 'advokat'])->get();

        return view('pembayaran.create', compact('konsultasis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'konsultasi_id' => 'required|exists:konsultasis,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'metode' => 'required|in:transfer,cash,qris',
        ]);

        Pembayaran::create($validated);

        return redirect()->route('pembayaran.index')->with('success', 'Tagihan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $konsultasis = Konsultasi::with(['klien', 'advokat'])->get();

        return view('pembayaran.edit', compact('pembayaran', 'konsultasis'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'konsultasi_id' => 'required|exists:konsultasis,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'metode' => 'required|in:transfer,cash,qris',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update($validated);

        return redirect()->route('pembayaran.index')->with('success', 'Tagihan berhasil diperbarui.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:belum_bayar,menunggu_konfirmasi,sudah_bayar',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update(['status' => $request->status]);

        return back()->with('success', 'Status tagihan berhasil diperbarui.');
    }

    public function bayar(Pembayaran $pembayaran)
    {
        if (auth()->user()->role !== 'klien') {
            abort(403, 'Akses ditolak');
        }

        return view('pembayaran.bayar', compact('pembayaran'));
    }
    
    public function previewBukti(Pembayaran $pembayaran)
    {
        // Hanya role tertentu yang boleh lihat bukti
        if (!in_array(auth()->user()->role, ['keuangan', 'superadmin', 'manajer']) 
            && auth()->id() !== $pembayaran->konsultasi->klien->user_id) {
            abort(403, 'Akses ditolak');
        }

        $path = storage_path('app/private/' . $pembayaran->bukti_pembayaran);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->file($path);
    }

    // Keuangan konfirmasi pembayaran
    public function konfirmasi(Pembayaran $pembayaran)
    {
        $pembayaran->update(['status' => 'sudah_bayar']);
        return back()->with('success', 'Pembayaran dikonfirmasi.');
    }

    public function invoice(Pembayaran $pembayaran)
    {
        $pembayaran->load('konsultasi.klien', 'konsultasi.advokat');

        $pdf = Pdf::loadView('pembayaran.invoice', [
            'pembayaran' => $pembayaran,
            'exported_at' => Carbon::now()->format('d-m-Y'),
        ]);

        $fileName = 'invoice-' . $pembayaran->id . '.pdf';

        return $pdf->download($fileName);
    }

    public function destroy(Pembayaran $pembayaran)
    {
        // Optional: cek role
        if (!in_array(auth()->user()->role, ['keuangan', 'superadmin', 'manajer'])) {
            abort(403);
        }

        $pembayaran->delete();

        return redirect()->route('pembayaran.index')->with('success', 'Tagihan berhasil dihapus.');
    }
}
