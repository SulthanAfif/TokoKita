<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * RegisteredUserController
 * ------------------------
 * Mengatur proses Registrasi akun baru.
 *
 * create() → tampilkan form register
 * store()  → simpan user baru + kirim email verifikasi
 *
 * Role default: customer
 * Email harus diverifikasi sebelum bisa belanja penuh.
 */
class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman registrasi
     * Route: GET /register
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi
     * Route: POST /register
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input form
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // Validasi Google reCAPTCHA
            'g-recaptcha-response' => ['required', function ($attribute, $value, $fail) {
                $response = \Illuminate\Support\Facades\Http::asForm()->post(
                    'https://www.google.com/recaptcha/api/siteverify',
                    [
                        'secret'   => config('services.recaptcha.secret_key'),
                        'response' => $value,
                        'remoteip' => request()->ip(),
                    ]
                );

                // Jika reCAPTCHA gagal, tampilkan error
                if (!($response->json()['success'] ?? false)) {
                    $fail('Verifikasi reCAPTCHA gagal. Silakan coba lagi.');
                }
            }],
        ]);

        // Buat user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Hash password
            'role'     => 'customer',                     // Default role customer
            // email_verified_at = null → wajib verifikasi dulu
        ]);

        // Trigger event Registered → Laravel kirim email verifikasi
        event(new Registered($user));

        // Langsung login setelah register
        Auth::login($user);

        // Arahkan ke halaman "cek email untuk verifikasi"
        return redirect()->route('verification.notice');
    }
}
