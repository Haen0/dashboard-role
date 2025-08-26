<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\Klient;
use App\Models\Advokat;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KonsultasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Konsultasi::with(['klien', 'advokat', 'dokumens']);

        // Batasi berdasarkan role
        if (auth()->user()->role === 'klien') {
            $query->where('klien_id', auth()->user()->klient->id);
        } elseif (auth()->user()->role === 'advokat') {
            $query->where('advokat_id', auth()->user()->advokat->id);
        }

        // Filter berdasarkan request
        if ($request->filled('klien')) {
            $query->whereHas('klien', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->klien . '%');
            });
        }

        if ($request->filled('advokat')) {
            $query->whereHas('advokat', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->advokat . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $perPage = $request->get('per_page', 10);
        $konsultasis = $query->latest()->paginate($perPage)->withQueryString();

        return view('konsultasi.index', compact('konsultasis'));
    }

    public function create()
    {
        // Jika klien, tidak perlu pilih klien
        $klients = in_array(auth()->user()->role, ['admin', 'superadmin', 'manajer']) ? Klient::all() : null;
        $advokats = Advokat::all();

        return view('konsultasi.create', compact('klients', 'advokats'));
    }

    public function store(Request $request)
    {
        $rules = [
            'advokat_id' => 'nullable|exists:advokats,id',
            'tanggal' => 'required|date',
            'jenis_kasus' => 'required|string|max:255',
            'ringkasan' => 'required|string',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx'
        ];

        if (in_array(auth()->user()->role, ['admin', 'superadmin', 'manajer'])) {
            $rules['klien_id'] = 'required|exists:klients,id';
        }

        $request->validate($rules);

        $data = $request->except('dokumen');

        if (auth()->user()->role === 'klien') {
            $data['klien_id'] = auth()->user()->klient->id;
        }

        $data['status'] = 'pending';
        $konsultasi = Konsultasi::create($data);

        // Simpan dokumen ke tabel dokumens
        if ($request->hasFile('dokumen')) {
            $path = $request->file('dokumen')->store('dokumen_konsultasi', 'local');
            Dokumen::create([
                'konsultasi_id' => $konsultasi->id,
                'nama_dokumen' => $request->file('dokumen')->getClientOriginalName(),
                'file_path' => $path,
                'jenis_dokumen' => 'klien'
            ]);
        }

        return redirect()->route('konsultasis.index')->with('success', 'Konsultasi berhasil diajukan.');
    }

    public function edit(Konsultasi $konsultasi)
    {
        $klients = Klient::all();
        $advokats = Advokat::all();
        return view('konsultasi.edit', compact('konsultasi', 'klients', 'advokats'));
    }

    public function update(Request $request, Konsultasi $konsultasi)
    {
        if (!in_array(auth()->user()->role, ['admin', 'superadmin', 'manajer'])) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'advokat_id' => 'nullable|exists:advokats,id',
            'tanggal'    => 'required|date',
            'waktu'      => 'required',
            'lokasi'     => 'required|string|max:255',
        ]);

        // Update konsultasi
        $konsultasi->update([
            'advokat_id' => $request->advokat_id,
            'tanggal'    => $request->tanggal,
            'status'     => 'diproses'
        ]);

        // Simpan ke jadwal
        $konsultasi->jadwal()->updateOrCreate(
            ['konsultasi_id' => $konsultasi->id],
            [
                'tanggal' => $request->tanggal,
                'waktu'   => $request->waktu,
                'lokasi'  => $request->lokasi,
            ]
        );

        return redirect()->route('konsultasis.index')->with('success', 'Konsultasi berhasil diperbarui.');
    }

    public function destroy(Konsultasi $konsultasi)
    {
        if ($konsultasi->dokumen) {
            Storage::delete($konsultasi->dokumen);
        }
        $konsultasi->delete();
        return redirect()->route('konsultasis.index')->with('success', 'Data berhasil dihapus.');
    }

    public function previewDokumen(Dokumen $dokumen)
    {
        $filePath = storage_path('app/private/' . str_replace('dokumen_konsultasi/', 'dokumen_konsultasi/', $dokumen->file_path));

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan: ' . $filePath);
        }

        return response()->file($filePath, [
            'Content-Type' => mime_content_type($filePath),
            'Content-Disposition' => 'inline; filename="' . $dokumen->nama_dokumen . '"'
        ]);
    }
}
