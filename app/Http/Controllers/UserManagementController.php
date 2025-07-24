<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Advokat;
use App\Models\Klient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Admin hanya bisa melihat klien & advokat
        if (auth()->user()->role === 'admin') {
            $query->whereIn('role', ['klien', 'advokat']);
        }

        // Filter by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Filter by email
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDir = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDir);

        // Pagination
        $perPage = $request->get('per_page', 10);
        $users = $query->paginate($perPage)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:superadmin,admin,keuangan,manajer,advokat,klien',
        ]);

        // Admin hanya boleh membuat klien & advokat
        if (auth()->user()->role === 'admin' && !in_array($request->role, ['klien', 'advokat'])) {
            abort(403, 'Admin hanya bisa membuat Klien atau Advokat.');
        }

        // Buat user utama
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Tambah data ke tabel sesuai role
        if (in_array($request->role, ['admin', 'keuangan', 'manajer'])) {
            Admin::create([
                'user_id' => $user->id,
                'nama'    => $request->name,
                'email'   => $request->email,
                'role'    => $request->role,
            ]);
        } elseif ($request->role === 'advokat') {
            Advokat::create([
                'user_id' => $user->id,
                'nama' => $request->name,
                'email' => $request->email,
            ]);
        } elseif ($request->role === 'klien') {
            Klient::create([
                'user_id' => $user->id,
                'nama' => $request->name,
                'email' => $request->email,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        // Admin tidak bisa edit superadmin / admin lain
        if (auth()->user()->role === 'admin' && !in_array($user->role, ['klien', 'advokat'])) {
            abort(403);
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->role === 'admin' && !in_array($user->role, ['klien', 'advokat'])) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:superadmin,admin,keuangan,manajer,advokat,klien',
        ]);

        if (auth()->user()->role === 'admin' && !in_array($request->role, ['klien', 'advokat'])) {
            abort(403, 'Admin hanya bisa update Klien atau Advokat.');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        // Update data di tabel terkait
        if (in_array($user->role, ['admin', 'keuangan', 'manajer']) && $user->admin) {
            $user->admin->update([
                'nama'  => $request->name,
                'email' => $request->email,
                'role'  => $request->role,
            ]);
        } elseif ($user->role === 'advokat' && $user->advokat) {
            $user->advokat->update(['nama' => $request->name, 'email' => $request->email]);
        } elseif ($user->role === 'klien' && $user->klient) {
            $user->klient->update(['nama' => $request->name, 'email' => $request->email]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        if (auth()->user()->role === 'admin' && !in_array($user->role, ['klien', 'advokat'])) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
