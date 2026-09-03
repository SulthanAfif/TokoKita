# TokoKita

TokoKita adalah aplikasi toko online berbasis web yang dikembangkan menggunakan Laravel. Aplikasi ini menyediakan fitur untuk customer dalam melihat produk, mengelola keranjang, melakukan checkout, serta melihat pesanan. Selain itu, tersedia dashboard admin untuk mengelola produk, kategori, stok, pesanan, dan konten website.

## Demo

🌐 **Live Website:**
https://toko-kita-alpha.vercel.app

## Repository

📦 **GitHub:**
https://github.com/SulthanAfif/TokoKita

## Features

### Customer

* Melihat daftar produk
* Melihat detail produk
* Mencari produk
* Menambahkan produk ke keranjang
* Mengubah jumlah produk di keranjang
* Checkout produk
* Melakukan pembayaran
* Melihat riwayat pesanan
* Melihat detail pesanan
* Mengelola profil
* Mengelola alamat

### Admin

* Dashboard admin
* Mengelola produk
* Mengelola kategori
* Mengelola stok
* Mengelola pesanan
* Mengelola halaman website
* Mengelola hero slide
* Mengelola pengaturan website

## Technologies

* Laravel
* PHP
* MySQL
* Tailwind CSS
* Vite
* Alpine.js
* Chart.js
* JavaScript

## Installation

Clone repository:

```bash
git clone https://github.com/SulthanAfif/TokoKita.git
```

Masuk ke folder project:

```bash
cd TokoKita
```

Install dependency PHP:

```bash
composer install
```

Install dependency JavaScript:

```bash
npm install
```

Buat file environment:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Konfigurasi database pada file `.env`, kemudian jalankan migration:

```bash
php artisan migrate
```

Jalankan aplikasi:

```bash
php artisan serve
```

Pada terminal lain, jalankan Vite:

```bash
npm run dev
```

## Screenshots

### Home

Tambahkan screenshot halaman utama di sini.

### Product

Tambahkan screenshot halaman produk di sini.

### Cart

Tambahkan screenshot halaman keranjang di sini.

### Checkout

Tambahkan screenshot halaman checkout di sini.

### Admin Dashboard

Tambahkan screenshot dashboard admin di sini.

## Project Structure

Project dikembangkan menggunakan framework Laravel dengan pemisahan komponen backend, frontend, routes, database, dan resource sesuai struktur Laravel.

## Status

✅ Project selesai dikembangkan dan dapat digunakan sebagai aplikasi toko online berbasis web.
