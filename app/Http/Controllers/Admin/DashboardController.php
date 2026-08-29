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

class DashboardController extends Controller
{
    public function index()
    {
        $productsSold = OrderItem::query()
            ->whereHas('order', fn ($q) => $q->where('status', '!=', 'cancelled'))
            ->sum('quantity');

        $stockRemaining = Product::sum('stock');
        $totalOrders = Order::where('status', '!=', 'cancelled')->count();

        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_clicks' => (int) Product::sum('views_count'),
            'products_sold' => (int) $productsSold,
            'stock_remaining' => (int) $stockRemaining,
            'total_orders' => $totalOrders,
            'total_units' => (int) $productsSold,
            'total_customers' => User::where('role', 'customer')->count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
            'revenue_today' => Order::where('status', '!=', 'cancelled')
                ->whereDate('created_at', today())->sum('total'),
            'orders_today' => Order::whereDate('created_at', today())->count(),
        ];

        $recentOrders = Order::with(['user', 'items'])
            ->latest()
            ->take(10)
            ->get();

        $lowStockProducts = Product::orderBy('stock')
            ->take(8)
            ->get(['id', 'name', 'stock', 'sku']);

        // ========== DATA CHART ==========

        // 1. Penjualan 7 hari terakhir (pendapatan + jumlah pesanan)
        $salesLabels = [];
        $salesRevenue = [];
        $salesOrders = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $salesLabels[] = $date->translatedFormat('d M');
            $salesRevenue[] = (float) Order::where('status', '!=', 'cancelled')
                ->whereDate('created_at', $date)
                ->sum('total');
            $salesOrders[] = Order::whereDate('created_at', $date)->count();
        }

        // 2. Status pesanan (doughnut)
        $statusMap = [
            'pending' => 'Menunggu',
            'paid' => 'Dibayar',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
        $statusCounts = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
        $statusLabels = [];
        $statusData = [];
        foreach ($statusMap as $key => $label) {
            $statusLabels[] = $label;
            $statusData[] = (int) ($statusCounts[$key] ?? 0);
        }

        // 3. Top 5 produk terlaris
        $topProducts = OrderItem::query()
            ->select('product_name', DB::raw('SUM(quantity) as sold'))
            ->whereHas('order', fn ($q) => $q->where('status', '!=', 'cancelled'))
            ->groupBy('product_name')
            ->orderByDesc('sold')
            ->take(5)
            ->get();

        $topProductLabels = $topProducts->pluck('product_name')->map(function ($n) {
            return mb_strlen($n) > 22 ? mb_substr($n, 0, 22) . '…' : $n;
        })->toArray();
        $topProductData = $topProducts->pluck('sold')->map(fn ($v) => (int) $v)->toArray();

        // 4. Pendapatan 6 bulan terakhir
        $monthLabels = [];
        $monthRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthLabels[] = $month->translatedFormat('M Y');
            $monthRevenue[] = (float) Order::where('status', '!=', 'cancelled')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total');
        }

        $charts = [
            'sales' => [
                'labels' => $salesLabels,
                'revenue' => $salesRevenue,
                'orders' => $salesOrders,
            ],
            'status' => [
                'labels' => $statusLabels,
                'data' => $statusData,
            ],
            'topProducts' => [
                'labels' => $topProductLabels,
                'data' => $topProductData,
            ],
            'monthly' => [
                'labels' => $monthLabels,
                'revenue' => $monthRevenue,
            ],
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'lowStockProducts',
            'charts'
        ));
    }
}
