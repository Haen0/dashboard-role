<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role === 'user') {
            abort(403);
        }

        $query = User::query();

        // Admin hanya bisa melihat user, tidak bisa melihat admin/superadmin
        if (auth()->user()->role === 'admin') {
            $query->where('role', 'user');
        }

        // Filter by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Filter by email
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Filter by role (superadmin akan tetap bisa lihat semua)
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDir = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDir);

        // Pagination size
        $perPage = $request->get('per_page',  1);
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

        if (auth()->user()->role !== 'superadmin' && $request->role !== 'user') {
            abort(403, 'Unauthorized role assignment');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if (auth()->user()->role !== 'superadmin' && $user->role !== 'user') {
            abort(403);
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->role !== 'superadmin' && $user->role !== 'user') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:superadmin,admin,keuangan,manajer,advokat,klien',
        ]);

        if (auth()->user()->role !== 'superadmin' && $request->role !== 'user') {
            abort(403, 'Unauthorized role assignment');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        if (auth()->user()->role !== 'superadmin' && $user->role !== 'user') {
            abort(403);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
