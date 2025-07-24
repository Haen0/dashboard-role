<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $query = Konsultasi::with(['klien', 'advokat', 'dokumens']);

        // Jika role klien, hanya lihat konsultasi miliknya
        if (auth()->user()->role === 'klien') {
            $query->where('klien_id', auth()->user()->klient->id);
        }

        // Jika role advokat, hanya lihat konsultasi miliknya
        if (auth()->user()->role === 'advokat') {
            $query->where('advokat_id', auth()->user()->advokat->id);
        }

        $konsultasis = $query->latest()->paginate(10);
        return view('dokumen.index', compact('konsultasis'));
    }

    public function uploadAdmin(Request $request, Konsultasi $konsultasi)
    {
        $request->validate(['dokumen' => 'required|file|mimes:pdf,doc,docx']);
        $path = $request->file('dokumen')->store('dokumen_admin');

        Dokumen::create([
            'konsultasi_id' => $konsultasi->id,
            'nama_dokumen'  => $request->file('dokumen')->getClientOriginalName(),
            'file_path'     => $path,
            'jenis_dokumen' => 'admin',
        ]);

        return back()->with('success', 'Dokumen admin berhasil diupload.');
    }

    public function uploadAdvokat(Request $request, Konsultasi $konsultasi)
    {
        $request->validate(['dokumen' => 'required|file|mimes:pdf,doc,docx']);
        $path = $request->file('dokumen')->store('dokumen_advokat');

        Dokumen::create([
            'konsultasi_id' => $konsultasi->id,
            'nama_dokumen'  => $request->file('dokumen')->getClientOriginalName(),
            'file_path'     => $path,
            'jenis_dokumen' => 'advokat',
        ]);

        return back()->with('success', 'Dokumen advokat berhasil diupload.');
    }

    public function selesaikan(Konsultasi $konsultasi)
    {
        $required = ['klien', 'admin', 'advokat'];
        $uploaded = $konsultasi->dokumens->pluck('jenis_dokumen')->toArray();

        foreach ($required as $jenis) {
            if (!in_array($jenis, $uploaded)) {
                return back()->with('error', 'Dokumen belum lengkap.');
            }
        }

        $konsultasi->update(['status' => 'selesai']);
        return back()->with('success', 'Konsultasi berhasil diselesaikan.');
    }
}
