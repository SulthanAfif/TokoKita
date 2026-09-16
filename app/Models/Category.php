<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Model Category
 * --------------
 * Kategori produk (contoh: Elektronik, Fashion, Makanan).
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',         // Nama kategori
        'slug',         // URL-friendly (contoh: elektronik)
        'description',  // Deskripsi opsional
        'image',        // Gambar kategori (opsional)
    ];

    /**
     * Event: otomatis generate slug dari name
     * jika slug belum diisi manual
     */
    protected static function booted(): void
    {
        static::saving(function (Category $category) {
            if (empty($category->slug)) {
                // "Elektronik & Gadget" → "elektronik-gadget"
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * 1 kategori punya banyak produk
     * Contoh: $category->products
     * Bisa juga: Category::withCount('products') → menghitung jumlah produk
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
