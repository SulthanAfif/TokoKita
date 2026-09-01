<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Paksa semua URL yang di-generate (asset, route, dll) pakai domain & skema dari
        // APP_URL di production. Ini mencegah salah domain/Mixed Content akibat header
        // proxy (X-Forwarded-Host/Proto) dari Vercel yang kadang tidak konsisten dengan
        // domain custom yang sebenarnya diakses user.
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }

        // Bagikan jumlah item keranjang ke semua view (notifikasi ikon)
        View::composer('*', function ($view) {
            $cartCount = 0;
            if (Auth::check()) {
                $cartCount = (int) (Auth::user()->cart?->items()->sum('quantity') ?? 0);
            }
            $view->with('cartCount', $cartCount);
        });
    }
}