<?php

namespace App\Http\Controllers;

use App\Models\Advokat;
use Illuminate\Http\Request;

class AdvokatController extends Controller
{
    public function index(Request $request)
    {
        $query = Advokat::query();

        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%'.$request->nama.'%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%'.$request->email.'%');
        }

        if ($request->filled('spesialis')) {
            $query->where('spesialis', 'like', '%'.$request->spesialis.'%');
        }

        $perPage = $request->get('per_page', 10);
        $advokats = $query->paginate($perPage)->appends($request->all());

        return view('advokats.index', compact('advokats'));
    }

    public function create()
    {
        return view('advokats.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'email' => 'required|email|unique:advokats,email',
            'telepon' => 'required|string|max:20',
        ]);

        Advokat::create($request->all());

        return redirect()->route('advokats.index')->with('success', 'Data advokat berhasil ditambahkan.');
    }

    public function edit(Advokat $advokat)
    {
        return view('advokats.edit', compact('advokat'));
    }

    public function update(Request $request, Advokat $advokat)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'email' => 'required|email|unique:advokats,email,' . $advokat->id,
            'telepon' => 'required|string|max:20',
        ]);

        $advokat->update($request->all());

        return redirect()->route('advokats.index')->with('success', 'Data advokat berhasil diperbarui.');
    }

    public function destroy(Advokat $advokat)
    {
        $advokat->delete();
        return redirect()->route('advokats.index')->with('success', 'Data advokat berhasil dihapus.');
    }
}
