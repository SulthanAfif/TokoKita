<?php

/**
 * File Routing Utama (web.php)
 * --------------------------------
 * File ini mengatur semua URL yang bisa diakses user.
 * Setiap Route::get / Route::post menghubungkan URL ke method di Controller.
 */

// Import semua Controller yang akan digunakan
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;      // Alias agar tidak bentrok nama
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
| HALAMAN PUBLIK (tidak perlu login)
|--------------------------------------------------------------------------
| Siapa saja bisa mengakses route di bawah ini.
*/

// Halaman beranda → memanggil method home() di ProductController
Route::get('/', [ProductController::class, 'home'])->name('home');

// Halaman katalog produk (daftar semua produk)
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');

// Halaman detail produk (menggunakan slug sebagai parameter, contoh: /produk/kaos-polos)
Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Halaman Tentang Kami
Route::get('/tentang', [PageController::class, 'about'])->name('pages.about');

// Halaman Kontak
Route::get('/kontak', [PageController::class, 'contact'])->name('pages.contact');

/*
|--------------------------------------------------------------------------
| HALAMAN CUSTOMER (wajib login + email sudah diverifikasi)
|--------------------------------------------------------------------------
| Middleware 'auth' = harus sudah login
| Middleware 'verified' = email harus sudah diverifikasi
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // ----- KERANJANG BELANJA -----
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');           // Lihat isi keranjang
    Route::post('/keranjang/{product}', [CartController::class, 'add'])->name('cart.add');    // Tambah produk ke keranjang
    Route::patch('/keranjang/item/{item}', [CartController::class, 'update'])->name('cart.update'); // Ubah jumlah item
    Route::delete('/keranjang/item/{item}', [CartController::class, 'remove'])->name('cart.remove'); // Hapus item

    // ----- CHECKOUT (proses order) -----
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');   // Form checkout
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');  // Simpan order baru

    // ----- PESANAN (order history) -----
    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');                     // Daftar pesanan
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');               // Detail 1 pesanan
    Route::get('/pesanan/{order}/bayar', [OrderController::class, 'payment'])->name('orders.payment');   // Halaman bayar
    Route::post('/pesanan/{order}/bayar', [OrderController::class, 'processPayment'])->name('orders.processPayment'); // Proses bayar
    Route::post('/pesanan/{order}/batalkan', [OrderController::class, 'cancel'])->name('orders.cancel'); // Batalkan pesanan
    Route::patch('/pesanan/{order}/metode-pembayaran', [OrderController::class, 'updatePaymentMethod'])->name('orders.updatePayment'); // Ubah metode bayar

    // ----- PROFIL USER -----
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');         // Form edit profil
    Route::patch('/profil', [ProfileController::class, 'update'])->name('profile.update');   // Simpan perubahan profil
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Hapus akun

    // Alamat pengiriman user
    Route::post('/profil/alamat', [ProfileController::class, 'storeAddress'])->name('profile.address.store');     // Tambah alamat
    Route::delete('/profil/alamat/{address}', [ProfileController::class, 'destroyAddress'])->name('profile.address.destroy'); // Hapus alamat
});

/*
|--------------------------------------------------------------------------
| HALAMAN ADMIN (wajib login + role = admin)
|--------------------------------------------------------------------------
| Middleware 'admin' = custom middleware EnsureUserIsAdmin
| prefix('admin') = semua URL diawali /admin
| name('admin.') = semua nama route diawali admin.
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Produk (resource otomatis membuat index, create, store, show, edit, update, destroy)
    Route::resource('products', AdminProductController::class);

    // Manajemen stok
    Route::get('stok', [AdminStockController::class, 'index'])->name('stock.index');

    // CRUD Kategori (kecuali show, karena tidak dibutuhkan)
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    // Pengaturan statistik beranda (angka-angka di hero section)
    Route::get('pengaturan/statistik', [AdminSettingController::class, 'edit'])->name('settings.edit');
    Route::put('pengaturan/statistik', [AdminSettingController::class, 'update'])->name('settings.update');

    // Manajemen slide hero (gambar carousel di beranda)
    Route::get('hero-slides', [AdminHeroSlideController::class, 'index'])->name('hero-slides.index');
    Route::post('hero-slides', [AdminHeroSlideController::class, 'store'])->name('hero-slides.store');
    Route::put('hero-slides/{heroSlide}', [AdminHeroSlideController::class, 'update'])->name('hero-slides.update');
    Route::delete('hero-slides/{heroSlide}', [AdminHeroSlideController::class, 'destroy'])->name('hero-slides.destroy');
    Route::post('hero-slides/reorder', [AdminHeroSlideController::class, 'reorder'])->name('hero-slides.reorder');

    // Manajemen pesanan (admin)
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Manajemen halaman statis (Tentang & Kontak)
    Route::get('pages', [AdminPageController::class, 'index'])->name('pages.index');
    Route::get('pages/{page}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
    Route::put('pages/{page}', [AdminPageController::class, 'update'])->name('pages.update');
    Route::delete('pages/{page}', [AdminPageController::class, 'destroy'])->name('pages.destroy');
});

// Memuat route autentikasi (login, register, logout, dll) dari file auth.php
require __DIR__.'/auth.php';
