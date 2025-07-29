<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\Dokumen;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $query = Konsultasi::with(['klien', 'advokat', 'dokumens']);

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

        $konsultasis = $query->latest()->paginate($request->get('per_page', 10))
                                ->appends($request->query());

        return view('dokumen.index', compact('konsultasis'));
    }

    // public function uploadAdmin(Request $request, Konsultasi $konsultasi)
    // {
    //     $request->validate(['dokumen' => 'required|file|mimes:pdf,doc,docx']);
    //     $path = $request->file('dokumen')->store('dokumen_admin');

    //     Dokumen::create([
    //         'konsultasi_id' => $konsultasi->id,
    //         'nama_dokumen'  => $request->file('dokumen')->getClientOriginalName(),
    //         'file_path'     => $path,
    //         'jenis_dokumen' => 'admin',
    //     ]);

    //     return back()->with('success', 'Dokumen admin berhasil diupload.');
    // }

    // public function uploadAdvokat(Request $request, Konsultasi $konsultasi)
    // {
    //     $request->validate(['dokumen' => 'required|file|mimes:pdf,doc,docx']);
    //     $path = $request->file('dokumen')->store('dokumen_advokat');

    //     Dokumen::create([
    //         'konsultasi_id' => $konsultasi->id,
    //         'nama_dokumen'  => $request->file('dokumen')->getClientOriginalName(),
    //         'file_path'     => $path,
    //         'jenis_dokumen' => 'advokat',
    //     ]);

    //     return back()->with('success', 'Dokumen advokat berhasil diupload.');
    // }

    public function selesaikan(Konsultasi $konsultasi)
    {
        // $required = ['klien', 'admin', 'advokat'];
        // $uploaded = $konsultasi->dokumens->pluck('jenis_dokumen')->toArray();

        // foreach ($required as $jenis) {
        //     if (!in_array($jenis, $uploaded)) {
        //         return back()->with('error', 'Dokumen belum lengkap.');
        //     }
        // }

        $konsultasi->update(['status' => 'selesai']);

        // Buat entry pembayaran otomatis jika belum ada
        // Pembayaran::firstOrCreate(
        //     ['konsultasi_id' => $konsultasi->id],
        //     [
        //         'status' => 'belum_bayar',
        //         'jumlah' => null,  // akan diisi oleh keuangan
        //         'tanggal' => null  // akan diisi oleh keuangan
        //     ]
        // );

        return back()->with('success', 'Konsultasi berhasil diselesaikan dan tagihan dibuat.');
    }
}
