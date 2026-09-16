<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Model Product
 * -------------
 * Mewakili tabel "products" di database.
 * Setiap baris = 1 produk yang dijual di toko.
 */
class Product extends Model
{
    // Trait untuk mendukung factory (membuat data dummy saat testing/seeding)
    use HasFactory;

    /**
     * Kolom-kolom yang boleh diisi secara mass-assignment
     * (contoh: Product::create([...]) atau $product->update([...]))
     */
    protected $fillable = [
        'category_id',      // ID kategori (foreign key)
        'name',             // Nama produk
        'slug',             // URL-friendly name (contoh: kaos-polos-hitam)
        'description',      // Deskripsi panjang produk
        'price',            // Harga normal
        'discount_price',   // Harga diskon (boleh null)
        'stock',            // Jumlah stok tersedia
        'sku',              // Kode unik produk (Stock Keeping Unit)
        'thumbnail',        // Path gambar utama produk
        'is_active',        // Status aktif/tidak (boolean)
        'views_count',      // Jumlah kali produk dilihat
    ];

    /**
     * Casting tipe data otomatis
     * Agar Laravel mengubah string dari database menjadi tipe yang benar
     */
    protected $casts = [
        'price'          => 'decimal:2',   // Angka desimal 2 digit (contoh: 50000.00)
        'discount_price' => 'decimal:2',
        'is_active'      => 'boolean',     // true / false
    ];

    /**
     * Event model: dijalankan setiap kali data akan disimpan (create/update)
     * Jika slug kosong, otomatis dibuatkan dari nama produk + random string
     */
    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            // Hanya generate slug jika masih kosong
            if (empty($product->slug)) {
                // Str::slug() mengubah "Kaos Polos Hitam" → "kaos-polos-hitam"
                // Ditambah random 5 karakter agar unik
                $product->slug = Str::slug($product->name) . '-' . Str::random(5);
            }
        });
    }

    // =========================================================
    // RELASI (Relationships)
    // =========================================================

    /**
     * Produk dimiliki oleh 1 kategori
     * Contoh pakai: $product->category->name
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Produk punya banyak gambar (galeri)
     * Diurutkan berdasarkan sort_order
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Produk bisa muncul di banyak order item
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // =========================================================
    // ACCESSOR (Attribute yang dihitung otomatis)
    // =========================================================

    /**
     * Menghasilkan URL lengkap gambar thumbnail
     * Bisa dipanggil: $product->thumbnail_url
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        // Jika tidak ada thumbnail, kembalikan null
        if (!$this->thumbnail) {
            return null;
        }

        // Jika sudah berupa URL lengkap (http/https), langsung kembalikan
        if (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://')) {
            return $this->thumbnail;
        }

        // Jika path lokal, ubah jadi URL asset (storage/...)
        return asset('storage/' . $this->thumbnail);
    }

    /**
     * Harga yang ditampilkan ke customer
     * Jika ada discount_price, pakai itu. Kalau tidak, pakai price normal.
     * Dipanggil: $product->final_price
     */
    public function getFinalPriceAttribute(): float
    {
        return (float) ($this->discount_price ?? $this->price);
    }

    /**
     * Cek apakah produk sedang diskon
     * Dipanggil: $product->has_discount  → true / false
     */
    public function getHasDiscountAttribute(): bool
    {
        return !is_null($this->discount_price) && $this->discount_price < $this->price;
    }

    // =========================================================
    // QUERY SCOPE (filter yang bisa dipakai ulang)
    // =========================================================

    /**
     * Hanya ambil produk yang aktif
     * Contoh: Product::active()->get()
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // =========================================================
    // METHOD LAIN
    // =========================================================

    /**
     * Tambah 1 ke views_count setiap kali halaman detail dibuka
     */
    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
