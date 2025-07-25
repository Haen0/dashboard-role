<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with(['konsultasi.klien', 'konsultasi.advokat']);

        // Filter default berdasarkan role
        if (auth()->user()->role === 'advokat') {
            $query->whereHas('konsultasi', function ($q) {
                $q->where('advokat_id', auth()->user()->advokat->id);
            });
        } elseif (auth()->user()->role === 'klien') {
            $query->whereHas('konsultasi', function ($q) {
                $q->where('klien_id', auth()->user()->klient->id);
            });
        }

        // Filter tambahan (hanya admin/superadmin)
        if (in_array(auth()->user()->role, ['admin', 'superadmin'])) {
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
        }

        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $perPage = $request->get('per_page', 10);
        $jadwals = $query->orderBy('tanggal')
                        ->orderBy('waktu')
                        ->paginate($perPage)
                        ->withQueryString();

        return view('jadwals.index', compact('jadwals'));
    }

}
