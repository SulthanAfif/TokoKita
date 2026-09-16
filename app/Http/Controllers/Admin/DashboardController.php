<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * DashboardController (Admin)
 * ---------------------------
 * Menampilkan ringkasan toko di halaman /admin
 * - Statistik (produk, order, revenue, stok, dll)
 * - Pesanan terbaru
 * - Produk stok menipis
 * - Data chart (penjualan 7 hari, status order, top produk, revenue 6 bulan)
 */
class DashboardController extends Controller
{
    public function index()
    {
        // =====================================================
        // 1. HITUNG STATISTIK UTAMA
        // =====================================================

        // Total unit produk yang sudah terjual (exclude order yang dibatalkan)
        $productsSold = OrderItem::query()
            ->whereHas('order', fn ($q) => $q->where('status', '!=', 'cancelled'))
            ->sum('quantity');

        // Sisa stok semua produk
        $stockRemaining = Product::sum('stock');

        // Total pesanan (selain yang dibatalkan)
        $totalOrders = Order::where('status', '!=', 'cancelled')->count();

        // Kumpulkan semua angka statistik ke dalam 1 array
        $stats = [
            'total_products'   => Product::count(),                                          // Jumlah produk
            'total_categories' => Category::count(),                                         // Jumlah kategori
            'total_clicks'     => (int) Product::sum('views_count'),                         // Total view produk
            'products_sold'    => (int) $productsSold,                                       // Unit terjual
            'stock_remaining'  => (int) $stockRemaining,                                     // Sisa stok
            'total_orders'     => $totalOrders,                                              // Total pesanan
            'total_units'      => (int) $productsSold,                                       // Alias unit terjual
            'total_customers'  => User::where('role', 'customer')->count(),                   // Jumlah customer
            'total_revenue'    => Order::where('status', '!=', 'cancelled')->sum('total'),   // Total pendapatan
            'revenue_today'    => Order::where('status', '!=', 'cancelled')                   // Pendapatan hari ini
                ->whereDate('created_at', today())->sum('total'),
            'orders_today'     => Order::whereDate('created_at', today())->count(),           // Pesanan hari ini
        ];

        // =====================================================
        // 2. DATA PENDUKUNG DASHBOARD
        // =====================================================

        // 10 pesanan terbaru (dengan relasi user & items)
        $recentOrders = Order::with(['user', 'items'])
            ->latest()
            ->take(10)
            ->get();

        // 8 produk dengan stok paling rendah (untuk peringatan)
        $lowStockProducts = Product::orderBy('stock')
            ->take(8)
            ->get(['id', 'name', 'stock', 'sku']);

        // =====================================================
        // 3. DATA UNTUK CHART
        // =====================================================

        // --- Chart 1: Penjualan 7 hari terakhir ---
        $salesLabels  = [];   // Label sumbu X (tanggal)
        $salesRevenue = [];   // Data pendapatan
        $salesOrders  = [];   // Data jumlah pesanan

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);                    // Hari ke-i ke belakang
            $salesLabels[]  = $date->translatedFormat('d M');        // Format: 11 Sep
            $salesRevenue[] = (float) Order::where('status', '!=', 'cancelled')
                ->whereDate('created_at', $date)
                ->sum('total');
            $salesOrders[]  = Order::whereDate('created_at', $date)->count();
        }

        // --- Chart 2: Distribusi status pesanan (doughnut) ---
        $statusMap = [
            'pending'    => 'Menunggu',
            'paid'       => 'Dibayar',
            'processing' => 'Diproses',
            'shipped'    => 'Dikirim',
            'completed'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
        ];

        // Hitung jumlah order per status
        $statusCounts = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $statusLabels = [];
        $statusData   = [];
        foreach ($statusMap as $key => $label) {
            $statusLabels[] = $label;
            $statusData[]   = (int) ($statusCounts[$key] ?? 0); // 0 jika belum ada
        }

        // --- Chart 3: Top 5 produk terlaris ---
        $topProducts = OrderItem::query()
            ->select('product_name', DB::raw('SUM(quantity) as sold'))
            ->whereHas('order', fn ($q) => $q->where('status', '!=', 'cancelled'))
            ->groupBy('product_name')
            ->orderByDesc('sold')
            ->take(5)
            ->get();

        // Potong nama produk yang terlalu panjang (max 22 karakter)
        $topProductLabels = $topProducts->pluck('product_name')->map(function ($n) {
            return mb_strlen($n) > 22 ? mb_substr($n, 0, 22) . '…' : $n;
        })->toArray();

        $topProductData = $topProducts->pluck('sold')->map(fn ($v) => (int) $v)->toArray();

        // --- Chart 4: Pendapatan 6 bulan terakhir ---
        $monthLabels  = [];
        $monthRevenue = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthLabels[]  = $month->translatedFormat('M Y');   // Format: Sep 2026
            $monthRevenue[] = (float) Order::where('status', '!=', 'cancelled')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total');
        }

        // Kumpulkan semua data chart
        $charts = [
            'sales' => [
                'labels'  => $salesLabels,
                'revenue' => $salesRevenue,
                'orders'  => $salesOrders,
            ],
            'status' => [
                'labels' => $statusLabels,
                'data'   => $statusData,
            ],
            'topProducts' => [
                'labels' => $topProductLabels,
                'data'   => $topProductData,
            ],
            'monthly' => [
                'labels'  => $monthLabels,
                'revenue' => $monthRevenue,
            ],
        ];

        // Kirim semua data ke view admin/dashboard.blade.php
        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'lowStockProducts',
            'charts'
        ));
    }
}
