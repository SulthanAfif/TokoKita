<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
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
