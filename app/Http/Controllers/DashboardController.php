<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $tagihan = collect();

        // if ($user->role === 'klien') {
        //     $tagihan = Pembayaran::with('konsultasi.advokat')
        //         ->whereHas('konsultasi', function ($q) use ($user) {
        //             $q->where('klien_id', $user->klient->id);
        //         })
        //         ->whereNotNull('jumlah')
        //         ->whereNotNull('tanggal');

        //     // === FILTERING ===
        //     if ($request->filled('status')) {
        //         $tagihan->where('status', $request->status);
        //     }

        //     if ($request->filled('jenis_kasus')) {
        //         $tagihan->whereHas('konsultasi', function ($q) use ($request) {
        //             $q->where('jenis_kasus', 'like', '%' . $request->jenis_kasus . '%');
        //         });
        //     }

        //     if ($request->filled('start_date') && $request->filled('end_date')) {
        //         $tagihan->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        //     }

        //     $tagihan = $tagihan->orderBy('tanggal', 'desc')->paginate(10);
        // }

        return view('dashboard.index', compact('tagihan'));
    }
}
