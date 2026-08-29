<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Address;
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
        return view('profile.edit', [
            'user' => $request->user(),
            'addresses' => $request->user()->addresses()->latest()->get(),
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

        // Update phone if provided
        if ($request->filled('phone')) {
            $request->user()->phone = $request->phone;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
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

    /**
     * Simpan alamat pengiriman baru.
     */
    public function storeAddress(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'label' => 'required|string|max:50',
            'recipient_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'full_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
        ]);

        $user = $request->user();

        // Jika belum ada alamat, set sebagai default
        $isDefault = $user->addresses()->count() === 0;

        $user->addresses()->create(array_merge($validated, [
            'is_default' => $isDefault,
        ]));

        return Redirect::route('profile.edit')->with('success', 'Alamat berhasil ditambahkan.');
    }

    /**
     * Hapus alamat.
     */
    public function destroyAddress(Request $request, Address $address): RedirectResponse
    {
        abort_if($address->user_id !== $request->user()->id, 403);

        $address->delete();

        return Redirect::route('profile.edit')->with('success', 'Alamat berhasil dihapus.');
    }
}
