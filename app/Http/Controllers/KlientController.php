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

    public function create()
    {
        // Form hanya untuk admin/superadmin
        if (!in_array(auth()->user()->role, ['admin', 'superadmin', 'manajer'])) {
            abort(403);
        }

        return view('klients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:klients,email',
            'telepon' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        // Buat klien
        Klient::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('klients.index')->with('success', 'Klien berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Cegah akses jika bukan admin/superadmin
        if (!in_array(auth()->user()->role, ['admin', 'superadmin', 'manajer'])) {
            abort(403);
        }

        $klient = Klient::findOrFail($id);
        return view('klients.edit', compact('klient'));
    }

    public function update(Request $request, $id)
    {
        // Cegah akses jika bukan admin/superadmin
        if (!in_array(auth()->user()->role, ['admin', 'superadmin', 'manajer'])) {
            abort(403);
        }

        $klient = Klient::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:klients,email,' . $klient->id,
            'telepon' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        $klient->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('klients.index')->with('success', 'Data klien berhasil diperbarui.');
    }

    public function destroy(Klient $klient)
    {
        // Optional: cek role
        if (!in_array(auth()->user()->role, ['admin', 'superadmin', 'manajer'])) {
            abort(403);
        }

        $klient->delete();

        return redirect()->route('klients.index')->with('success', 'Klien berhasil dihapus.');
    }
}
