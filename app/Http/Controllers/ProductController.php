<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Halaman beranda: tampilkan produk unggulan & kategori
    public function home()
    {
        $categories = Category::withCount('products')->take(6)->get();
        $featuredProducts = Product::active()->latest()->take(8)->get();

        $home = [
            'hero_badge' => SiteSetting::get('hero_badge', 'Gratis ongkir min. belanja Rp100rb'),
            'hero_title_1' => SiteSetting::get('hero_title_1', 'Belanja Mudah,'),
            'hero_title_2' => SiteSetting::get('hero_title_2', 'Harga Bersahabat'),
            'hero_subtitle' => SiteSetting::get('hero_subtitle', 'Ribuan produk pilihan, kualitas terbaik, pengiriman ke seluruh Indonesia. Mulai belanja sekarang!'),
            'stat1_value' => SiteSetting::get('hero_stat_1_value', '1000+'),
            'stat1_label' => SiteSetting::get('hero_stat_1_label', 'Produk Tersedia'),
            'stat2_value' => SiteSetting::get('hero_stat_2_value', '50+'),
            'stat2_label' => SiteSetting::get('hero_stat_2_label', 'Kota Terjangkau'),
            'stat3_value' => SiteSetting::get('hero_stat_3_value', '4.9★'),
            'stat3_label' => SiteSetting::get('hero_stat_3_label', 'Rating Pelanggan'),
            'hero_card_title' => SiteSetting::get('hero_card_title', "Belanja\nLebih Seru!"),
            'hero_card_subtitle' => SiteSetting::get('hero_card_subtitle', 'Diskon tiap hari'),
            'hero_badge_promo' => SiteSetting::get('hero_badge_promo', 'PROMO 🔥'),
            'hero_badge_flash' => SiteSetting::get('hero_badge_flash', '⚡ Flash Sale'),
            'trust' => [
                ['title' => SiteSetting::get('trust_1_title', 'Pengiriman Cepat'), 'desc' => SiteSetting::get('trust_1_desc', 'Ke seluruh Indonesia'), 'icon' => 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12'],
                ['title' => SiteSetting::get('trust_2_title', '100% Original'), 'desc' => SiteSetting::get('trust_2_desc', 'Produk bergaransi'), 'icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z'],
                ['title' => SiteSetting::get('trust_3_title', 'Bayar Aman'), 'desc' => SiteSetting::get('trust_3_desc', 'Transfer, e-wallet, COD'), 'icon' => 'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z'],
                ['title' => SiteSetting::get('trust_4_title', 'Mudah Retur'), 'desc' => SiteSetting::get('trust_4_desc', '7 hari jaminan'), 'icon' => 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182'],
            ],
            'promo_eyebrow' => SiteSetting::get('promo_eyebrow', 'Penawaran Spesial'),
            'promo_title' => SiteSetting::get('promo_title', 'Diskon hingga 50% hari ini!'),
            'promo_subtitle' => SiteSetting::get('promo_subtitle', 'Jangan lewatkan produk pilihan dengan harga terbaik.'),
            'promo_button' => SiteSetting::get('promo_button', 'Cek Sekarang →'),
        ];

        $heroSlides = HeroSlide::active()->ordered()->get();

        return view('home', compact('categories', 'featuredProducts', 'home', 'heroSlides'));
    }

    // Halaman katalog dengan filter kategori, pencarian, dan sorting
    public function index(Request $request)
    {
        $query = Product::active()->with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        $query->when($request->sort === 'price_asc', fn ($q) => $q->orderBy('price', 'asc'))
              ->when($request->sort === 'price_desc', fn ($q) => $q->orderBy('price', 'desc'))
              ->when(!$request->filled('sort'), fn ($q) => $q->latest());

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    // Halaman detail produk
    public function show(Product $product)
    {
        $product->incrementViews();

        $product->load('images', 'category');
        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
