<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Model SiteSetting
 * -----------------
 * Menyimpan pengaturan dinamis toko (teks hero, statistik, dll).
 * Disimpan sebagai key-value di database.
 *
 * Contoh key: hero_title_1, hero_stat_1_value, trust_1_title, dst.
 *
 * Data di-cache 1 jam agar tidak query database terus-menerus.
 */
class SiteSetting extends Model
{
    protected $fillable = [
        'key',      // Nama pengaturan (unik)
        'value',    // Isi pengaturan
        'label',    // Label untuk admin (opsional)
        'group',    // Pengelompokan (opsional)
    ];

    /**
     * Ambil nilai setting berdasarkan key
     *
     * @param  string       $key      Nama setting
     * @param  string|null  $default  Nilai default jika key belum ada
     * @return string|null
     *
     * Contoh: SiteSetting::get('hero_title_1', 'Belanja Mudah')
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        // Cache selama 3600 detik (1 jam)
        // Agar tidak query database setiap kali halaman beranda dibuka
        $settings = Cache::remember('site_settings', 3600, function () {
            // Ambil semua setting → array [key => value]
            return static::query()->pluck('value', 'key')->toArray();
        });

        // Kembalikan value, atau default jika key tidak ditemukan
        return $settings[$key] ?? $default;
    }

    /**
     * Simpan / update nilai setting
     * Otomatis hapus cache agar data terbaru langsung terbaca
     */
    public static function set(string $key, ?string $value): void
    {
        // updateOrCreate = update jika key sudah ada, create jika belum
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        // Hapus cache agar request berikutnya ambil data baru
        Cache::forget('site_settings');
    }

    /**
     * Hapus cache manual (berguna setelah bulk update)
     */
    public static function clearCache(): void
    {
        Cache::forget('site_settings');
    }
}
