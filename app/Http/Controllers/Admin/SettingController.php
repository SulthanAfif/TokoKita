<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /** Semua key yang bisa diedit + default + label form */
    public static function fields(): array
    {
        return [
            // Hero
            'hero_badge' => ['Gratis ongkir min. belanja Rp100rb', 'Badge hero (atas judul)', 'hero'],
            'hero_title_1' => ['Belanja Mudah,', 'Judul baris 1', 'hero'],
            'hero_title_2' => ['Harga Bersahabat', 'Judul baris 2 (warna gradient)', 'hero'],
            'hero_subtitle' => ['Ribuan produk pilihan, kualitas terbaik, pengiriman ke seluruh Indonesia. Mulai belanja sekarang!', 'Subjudul hero', 'hero'],
            'hero_stat_1_value' => ['1000+', 'Stat 1 — Nilai', 'hero'],
            'hero_stat_1_label' => ['Produk Tersedia', 'Stat 1 — Label', 'hero'],
            'hero_stat_2_value' => ['50+', 'Stat 2 — Nilai', 'hero'],
            'hero_stat_2_label' => ['Kota Terjangkau', 'Stat 2 — Label', 'hero'],
            'hero_stat_3_value' => ['4.9★', 'Stat 3 — Nilai', 'hero'],
            'hero_stat_3_label' => ['Rating Pelanggan', 'Stat 3 — Label', 'hero'],
            'hero_card_title' => ["Belanja\nLebih Seru!", 'Kartu kanan — judul', 'hero'],
            'hero_card_subtitle' => ['Diskon tiap hari', 'Kartu kanan — subjudul', 'hero'],
            'hero_badge_promo' => ['PROMO 🔥', 'Badge floating PROMO', 'hero'],
            'hero_badge_flash' => ['⚡ Flash Sale', 'Badge floating Flash Sale', 'hero'],

            // Trust bar
            'trust_1_title' => ['Pengiriman Cepat', 'Trust 1 — Judul', 'trust'],
            'trust_1_desc' => ['Ke seluruh Indonesia', 'Trust 1 — Deskripsi', 'trust'],
            'trust_2_title' => ['100% Original', 'Trust 2 — Judul', 'trust'],
            'trust_2_desc' => ['Produk bergaransi', 'Trust 2 — Deskripsi', 'trust'],
            'trust_3_title' => ['Bayar Aman', 'Trust 3 — Judul', 'trust'],
            'trust_3_desc' => ['Transfer, e-wallet, COD', 'Trust 3 — Deskripsi', 'trust'],
            'trust_4_title' => ['Mudah Retur', 'Trust 4 — Judul', 'trust'],
            'trust_4_desc' => ['7 hari jaminan', 'Trust 4 — Deskripsi', 'trust'],

            // Promo strip
            'promo_eyebrow' => ['Penawaran Spesial', 'Promo — label kecil', 'promo'],
            'promo_title' => ['Diskon hingga 50% hari ini!', 'Promo — judul', 'promo'],
            'promo_subtitle' => ['Jangan lewatkan produk pilihan dengan harga terbaik.', 'Promo — subjudul', 'promo'],
            'promo_button' => ['Cek Sekarang →', 'Promo — teks tombol', 'promo'],
        ];
    }

    public function edit()
    {
        foreach (self::fields() as $key => [$value, $label, $group]) {
            SiteSetting::firstOrCreate(
                ['key' => $key],
                ['value' => $value, 'label' => $label, 'group' => $group]
            );
        }

        $settings = SiteSetting::whereIn('key', array_keys(self::fields()))
            ->get()
            ->keyBy('key');

        $fields = self::fields();

        return view('admin.settings.edit', compact('settings', 'fields'));
    }

    public function update(Request $request)
    {
        $rules = [];
        foreach (array_keys(self::fields()) as $key) {
            $rules[$key] = 'required|string|max:500';
        }
        $request->validate($rules);

        foreach (array_keys(self::fields()) as $key) {
            SiteSetting::set($key, $request->input($key));
        }

        return back()->with('success', 'Konten beranda berhasil diperbarui.');
    }
}
