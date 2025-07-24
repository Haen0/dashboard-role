<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\Klient;
use App\Models\Advokat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KonsultasiController extends Controller
{
    public function index()
    {
        $konsultasis = Konsultasi::with(['klien', 'advokat'])->latest()->paginate(10);
        return view('konsultasi.index', compact('konsultasis'));
    }

    public function create()
    {
        $klients = \App\Models\Klient::all();
        $advokats = \App\Models\Advokat::all();
        return view('konsultasi.create', compact('klients', 'advokats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'klien_id' => 'required|exists:klients,id',
            'advokat_id' => 'required|exists:advokats,id',
            'tanggal' => 'required|date',
            'jenis_kasus' => 'required|string',
            'ringkasan' => 'required|string',
            'status' => 'required|in:pending,diproses,selesai',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx'
        ]);

        $data = $request->except('dokumen');

        if ($request->hasFile('dokumen')) {
            $data['dokumen'] = $request->file('dokumen')->store('dokumen_konsultasi');
        }

        Konsultasi::create($data);
        return redirect()->route('konsultasi.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit(Konsultasi $konsultasi)
    {
        $klients = \App\Models\Klient::all();
        $advokats = \App\Models\Advokat::all();
        return view('konsultasi.edit', compact('konsultasi', 'klients', 'advokats'));
    }

    public function update(Request $request, Konsultasi $konsultasi)
    {
        $request->validate([
            'klien_id' => 'required|exists:klients,id',
            'advokat_id' => 'required|exists:advokats,id',
            'tanggal' => 'required|date',
            'jenis_kasus' => 'required|string',
            'ringkasan' => 'required|string',
            'status' => 'required|in:pending,diproses,selesai',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx'
        ]);

        $data = $request->except('dokumen');

        if ($request->hasFile('dokumen')) {
            if ($konsultasi->dokumen) {
                Storage::delete($konsultasi->dokumen);
            }
            $data['dokumen'] = $request->file('dokumen')->store('dokumen_konsultasi');
        }

        $konsultasi->update($data);
        return redirect()->route('konsultasi.index')->with('success', 'Data berhasil diubah.');
    }

    public function destroy(Konsultasi $konsultasi)
    {
        if ($konsultasi->dokumen) {
            Storage::delete($konsultasi->dokumen);
        }
        $konsultasi->delete();
        return redirect()->route('konsultasi.index')->with('success', 'Data berhasil dihapus.');
    }

    public function previewDokumen(Konsultasi $konsultasi)
    {
        if (!$konsultasi->dokumen || !Storage::exists($konsultasi->dokumen)) {
            abort(404);
        }

        return response()->file(storage_path('app/' . $konsultasi->dokumen), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($konsultasi->dokumen) . '"'
        ]);
    }
}

