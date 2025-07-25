<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $tagihan = collect();

        if ($user->role === 'klien') {
            // Ambil semua pembayaran milik klien
            $tagihan = Pembayaran::with('konsultasi.advokat')
                ->whereHas('konsultasi', function ($q) use ($user) {
                    $q->where('klien_id', $user->klient->id);
                })
                ->whereNotNull('jumlah')
                ->whereNotNull('tanggal')
                ->orderBy('tanggal', 'desc')
                ->get();
        }

        // Untuk role lain, kita kirim dashboard kosong (atau data ringkasan lain)
        return view('dashboard.index', compact('tagihan'));
    }
}
