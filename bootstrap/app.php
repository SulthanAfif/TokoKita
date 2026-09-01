<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
    ]);
    // Percaya proxy Vercel untuk proto/port/for, TAPI JANGAN percaya X-Forwarded-Host.
    // Vercel mengirim header itu dengan domain internal deployment (bukan domain
    // custom/alias yang dipakai user), jadi kalau ikut dipercaya, semua URL asset
    // Laravel jadi salah arah ke domain internal tsb.
    $middleware->trustProxies(
        at: '*',
        headers: Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO |
            Request::HEADER_X_FORWARDED_AWS_ELB
    );
})
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();