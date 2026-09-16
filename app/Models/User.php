<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User
 * ----------
 * Mewakili tabel "users".
 * Menyimpan data akun customer maupun admin.
 * Implements MustVerifyEmail → user wajib verifikasi email sebelum bisa login penuh.
 */
class User extends Authenticatable implements MustVerifyEmail
{
    // HasFactory = bisa membuat data dummy
    // Notifiable = bisa menerima notifikasi (email, dll)
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi mass-assignment
     */
    protected $fillable = [
        'name',     // Nama lengkap
        'email',    // Email (unik)
        'password', // Password (akan di-hash otomatis)
        'role',     // 'admin' atau 'customer'
        'phone',    // Nomor telepon
    ];

    /**
     * Kolom yang disembunyikan saat model diubah ke array/JSON
     * (penting untuk keamanan, password tidak boleh muncul di response)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Waktu email diverifikasi
            'password'          => 'hashed',   // Otomatis hash password saat disimpan
        ];
    }

    // =========================================================
    // METHOD HELPER
    // =========================================================

    /**
     * Cek apakah user ini adalah admin
     * Dipakai di middleware dan view
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // =========================================================
    // RELASI
    // =========================================================

    /**
     * 1 user punya 1 keranjang belanja
     * Contoh: $user->cart
     */
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * 1 user punya banyak pesanan
     * Contoh: $user->orders
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * 1 user punya banyak alamat pengiriman
     * Contoh: $user->addresses
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
