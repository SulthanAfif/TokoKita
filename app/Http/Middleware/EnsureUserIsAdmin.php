<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware EnsureUserIsAdmin
 * ----------------------------
 * Digunakan untuk melindungi route admin.
 * Hanya user yang login DAN role-nya 'admin' yang boleh lanjut.
 *
 * Cara daftar di bootstrap/app.php atau Kernel.php:
 * 'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class
 */
class EnsureUserIsAdmin
{
    /**
     * Method handle() selalu dipanggil Laravel saat middleware dijalankan.
     *
     * @param  Request  $request  Request yang masuk
     * @param  Closure  $next     Lanjutkan ke request berikutnya jika lolos
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek 1: apakah user sudah login?
        // Cek 2: apakah method isAdmin() mengembalikan true?
        if (!$request->user() || !$request->user()->isAdmin()) {
            // Jika tidak, hentikan request dengan error 403 (Forbidden)
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Jika lolos, lanjutkan ke controller / route berikutnya
        return $next($request);
    }
}
