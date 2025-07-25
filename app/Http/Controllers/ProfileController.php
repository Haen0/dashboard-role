<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        $klien = null;
        $advokat = null;

        if ($user->role === 'klien') {
            $klien = $user->klient; // relasi one-to-one dari User ke Klient
        }

        if ($user->role === 'advokat') {
            $advokat = $user->advokat; // relasi one-to-one dari User ke Advokat
        }
        return view('profile.edit', [
            'user' => $request->user(),
            'klien' => $klien,
            'advokat' => $advokat,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateAdvokat(Request $request)
    {
        $request->validate([
            'spesialis' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
        ]);

        $advokat = auth()->user()->advokat;
        $advokat->update([
            'spesialis' => $request->spesialis,
            'telepon' => $request->telepon,
        ]);

        return back()->with('status', 'advokat-updated');
    }

    public function updateKlien(Request $request)
    {
        $request->validate([
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ]);

        $klien = auth()->user()->klient;
        $klien->update([
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return back()->with('status', 'klien-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
