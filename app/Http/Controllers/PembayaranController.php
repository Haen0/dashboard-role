<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
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

    // FORM UPDATE: keuangan isi jumlah & tanggal
    public function edit(Pembayaran $pembayaran)
    {
        if (!in_array(auth()->user()->role, ['keuangan', 'superadmin'])) {
            abort(403, 'Akses ditolak');
        }

        if ($pembayaran->status === 'sudah_bayar') {
            return redirect()->route('pembayaran.index')->with('error', 'Tagihan sudah dibayar dan tidak dapat diedit.');
        }

        return view('pembayaran.edit', compact('pembayaran'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        if (!in_array(auth()->user()->role, ['keuangan', 'superadmin'])) {
            abort(403, 'Akses ditolak');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0'
        ]);

        $pembayaran->update([
            'tanggal' => $request->tanggal,
            'jumlah' => $request->jumlah,
            'status'  => 'belum_bayar' // setelah keuangan input, status awal = belum_bayar
        ]);

        return redirect()->route('pembayaran.index')->with('success', 'Data tagihan berhasil diperbarui.');
    }

    public function bayar(Pembayaran $pembayaran)
    {
        if (auth()->user()->role !== 'klien') {
            abort(403, 'Akses ditolak');
        }

        return view('pembayaran.bayar', compact('pembayaran'));
    }

    // KLien upload bukti pembayaran
    public function uploadBukti(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'metode' => 'required|in:transfer,cash,qris',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'local');

        $pembayaran->update([
            'metode' => $request->metode,
            'bukti_pembayaran' => $path,
            'status' => 'menunggu_konfirmasi'
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload.');
    }
    
    public function previewBukti(Pembayaran $pembayaran)
    {
        // Hanya role tertentu yang boleh lihat bukti
        if (!in_array(auth()->user()->role, ['keuangan', 'superadmin']) 
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

}
