<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = Laporan::with('user')->latest()->paginate(10);
        return view('laporans.index', compact('laporans'));
    }

    public function create()
    {
        $jumlah_konsultasi = \App\Models\Konsultasi::count();
        $jumlah_kasus = \App\Models\Konsultasi::distinct('jenis_kasus')->count('jenis_kasus');

        return view('laporans.create', compact('jumlah_kasus', 'jumlah_konsultasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_dari' => 'required|date',
            'tanggal_ke' => 'required|date|after_or_equal:tanggal_dari',
        ]);

        Laporan::create([
            'user_id' => auth()->id(),
            'tanggal_dari' => $request->tanggal_dari,
            'tanggal_ke' => $request->tanggal_ke,
            'jumlah_kasus' => \App\Models\Konsultasi::distinct('jenis_kasus')->count('jenis_kasus'),
            'jumlah_konsultasi' => \App\Models\Konsultasi::count(),
        ]);

        return redirect()->route('laporans.index')
            ->with('success', 'Laporan berhasil ditambahkan. Anda bisa menambahkan catatan manajer.');
    }

    public function edit(Laporan $laporan)
    {
        return view('laporans.edit', compact('laporan'));
    }

    public function update(Request $request, Laporan $laporan)
    {
        $request->validate([
            'catatan_manajer' => 'nullable|string',
        ]);

        if (auth()->user()->role === 'superadmin') {
            $laporan->update(['catatan_manajer' => $request->catatan_manajer]);
        }

        return back()->with('success', 'Catatan manajer diperbarui');
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return back()->with('success', 'Laporan dihapus');
    }
}
