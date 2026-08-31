<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\StockController as AdminStockController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\HeroSlideController as AdminHeroSlideController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman publik (tidak perlu login)
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/tentang', [PageController::class, 'about'])->name('pages.about');
Route::get('/kontak', [PageController::class, 'contact'])->name('pages.contact');

/*
|--------------------------------------------------------------------------
| Halaman customer (wajib login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/keranjang/item/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/item/{item}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/pesanan/{order}/bayar', [OrderController::class, 'payment'])->name('orders.payment');
    Route::post('/pesanan/{order}/bayar', [OrderController::class, 'processPayment'])->name('orders.processPayment');
    Route::post('/pesanan/{order}/batalkan', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::patch('/pesanan/{order}/metode-pembayaran', [OrderController::class, 'updatePaymentMethod'])->name('orders.updatePayment');

    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/profil/alamat', [ProfileController::class, 'storeAddress'])->name('profile.address.store');
    Route::delete('/profil/alamat/{address}', [ProfileController::class, 'destroyAddress'])->name('profile.address.destroy');
});

/*
|--------------------------------------------------------------------------
| Halaman admin (wajib login + role admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::get('stok', [AdminStockController::class, 'index'])->name('stock.index');
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    // Statistik beranda
    Route::get('pengaturan/statistik', [AdminSettingController::class, 'edit'])->name('settings.edit');
    Route::put('pengaturan/statistik', [AdminSettingController::class, 'update'])->name('settings.update');

    // Slide latar hero
    Route::get('hero-slides', [AdminHeroSlideController::class, 'index'])->name('hero-slides.index');
    Route::post('hero-slides', [AdminHeroSlideController::class, 'store'])->name('hero-slides.store');
    Route::put('hero-slides/{heroSlide}', [AdminHeroSlideController::class, 'update'])->name('hero-slides.update');
    Route::delete('hero-slides/{heroSlide}', [AdminHeroSlideController::class, 'destroy'])->name('hero-slides.destroy');
    Route::post('hero-slides/reorder', [AdminHeroSlideController::class, 'reorder'])->name('hero-slides.reorder');

    // Pesanan
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Halaman (Tentang & Kontak)
    Route::get('pages', [AdminPageController::class, 'index'])->name('pages.index');
    Route::get('pages/{page}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
    Route::put('pages/{page}', [AdminPageController::class, 'update'])->name('pages.update');
    Route::delete('pages/{page}', [AdminPageController::class, 'destroy'])->name('pages.destroy');
});

require __DIR__.'/auth.php';
