<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * AuthenticatedSessionController
 * ------------------------------
 * Mengatur proses Login & Logout.
 *
 * create()  → tampilkan form login
 * store()   → proses login (cek email/password)
 * destroy() → logout
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login
     * Route: GET /login
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login
     * Route: POST /login
     *
     * Alur setelah login berhasil:
     * 1. Belum verifikasi email → halaman verifikasi
     * 2. Role admin            → dashboard admin
     * 3. Role customer         → beranda
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // LoginRequest berisi validasi email + password + attempt login
        $request->authenticate();

        // Regenerasi session ID (cegah session fixation attack)
        $request->session()->regenerate();

        $user = $request->user();

        // Belum verifikasi email → paksa ke halaman verifikasi
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        // Admin → panel admin
        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        // Customer → beranda
        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Logout
     * Route: POST /logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Hapus autentikasi
        Auth::guard('web')->logout();

        // Hancurkan session
        $request->session()->invalidate();

        // Buat CSRF token baru
        $request->session()->regenerateToken();

        // Kembali ke beranda
        return redirect('/');
    }
}
