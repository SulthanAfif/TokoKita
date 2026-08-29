<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified (via signed link).
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('home', absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('home', absolute: false).'?verified=1')
            ->with('success', 'Email berhasil diverifikasi! Selamat berbelanja.');
    }

    /**
     * Verifikasi manual (untuk development / tanpa SMTP).
     * Tetap aman: hanya user yang sedang login yang bisa verifikasi dirinya sendiri.
     */
    public function manual(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Email berhasil diverifikasi.');
        }

        return redirect()->route('home')
            ->with('success', 'Email berhasil diverifikasi! Selamat berbelanja.');
    }
}
