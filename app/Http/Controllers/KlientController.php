<?php

namespace App\Http\Controllers;

use App\Models\Klient;
use Illuminate\Http\Request;

class KlientController extends Controller
{
    public function index(Request $request)
    {
        $query = Klient::query();

        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%'.$request->nama.'%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%'.$request->email.'%');
        }

        if ($request->filled('telepon')) {
            $query->where('telepon', 'like', '%'.$request->telepon.'%');
        }

        $perPage = $request->get('per_page', 10);
        $klients = $query->paginate($perPage)->appends($request->all());

        return view('klients.index', compact('klients'));
    }
}
