@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
{{-- STAT CARDS --}}
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    @foreach([
        ['label' => 'Jumlah Produk', 'value' => number_format($stats['total_products'], 0, ',', '.'), 'sub' => 'Total produk terdaftar', 'color' => 'bg-violet-50 text-violet-600', 'icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m6-3V3a1.5 1.5 0 011.5-1.5h1.5A1.5 1.5 0 0114.25 3v1.5m-9 0h13.5'],
        ['label' => 'Jumlah Kategori', 'value' => number_format($stats['total_categories'], 0, ',', '.'), 'sub' => 'Total kategori produk', 'color' => 'bg-rose-50 text-rose-600', 'icon' => 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z'],
        ['label' => 'Klik Produk', 'value' => number_format($stats['total_clicks'], 0, ',', '.') . 'x', 'sub' => 'Total halaman produk dibuka', 'color' => 'bg-cyan-50 text-cyan-600', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z'],
        ['label' => 'Produk Terjual', 'value' => number_format($stats['products_sold'], 0, ',', '.') . ' unit', 'sub' => 'Semua customer digabung', 'color' => 'bg-emerald-50 text-emerald-600', 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Sisa Stok', 'value' => number_format($stats['stock_remaining'], 0, ',', '.') . ' unit', 'sub' => $stats['total_products'] . ' jenis produk', 'color' => 'bg-blue-50 text-blue-600', 'icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5'],
        ['label' => 'Total Pesanan', 'value' => number_format($stats['total_orders'], 0, ',', '.'), 'sub' => $stats['orders_today'] . ' hari ini', 'color' => 'bg-indigo-50 text-indigo-600', 'icon' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.824.696 2.057 1.668'],
        ['label' => 'Pendapatan', 'value' => 'Rp' . number_format($stats['total_revenue'], 0, ',', '.'), 'sub' => 'Hari ini Rp' . number_format($stats['revenue_today'], 0, ',', '.'), 'color' => 'bg-amber-50 text-amber-600', 'icon' => 'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375'],
    ] as $stat)
        <div class="rounded-2xl bg-white border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">{{ $stat['label'] }}</p>
                <div class="w-9 h-9 rounded-xl {{ $stat['color'] }} flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" />
                    </svg>
                </div>
            </div>
            <p class="text-xl sm:text-2xl font-bold text-slate-800">{{ $stat['value'] }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ $stat['sub'] }}</p>
        </div>
    @endforeach
</div>

{{-- ========== CHARTS ========== --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
    {{-- Penjualan 7 hari --}}
    <div class="lg:col-span-2 rounded-2xl bg-white border border-slate-200 p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-semibold text-slate-800">Penjualan 7 Hari Terakhir</h3>
                <p class="text-xs text-slate-400">Pendapatan & jumlah pesanan</p>
            </div>
        </div>
        <div class="h-52 sm:h-64">
            <canvas id="chartSales"></canvas>
        </div>
    </div>

    {{-- Status pesanan --}}
    <div class="rounded-2xl bg-white border border-slate-200 p-5">
        <div class="mb-4">
            <h3 class="font-semibold text-slate-800">Status Pesanan</h3>
            <p class="text-xs text-slate-400">Distribusi semua pesanan</p>
        </div>
        <div class="h-52 sm:h-64 flex items-center justify-center">
            <canvas id="chartStatus"></canvas>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
    {{-- Top produk --}}
    <div class="rounded-2xl bg-white border border-slate-200 p-5">
        <div class="mb-4">
            <h3 class="font-semibold text-slate-800">Produk Terlaris</h3>
            <p class="text-xs text-slate-400">Top 5 berdasarkan unit terjual</p>
        </div>
        <div class="h-52 sm:h-64">
            <canvas id="chartTopProducts"></canvas>
        </div>
    </div>

    {{-- Pendapatan bulanan --}}
    <div class="rounded-2xl bg-white border border-slate-200 p-5">
        <div class="mb-4">
            <h3 class="font-semibold text-slate-800">Pendapatan 6 Bulan</h3>
            <p class="text-xs text-slate-400">Total revenue per bulan</p>
        </div>
        <div class="h-52 sm:h-64">
            <canvas id="chartMonthly"></canvas>
        </div>
    </div>
</div>

{{-- PESANAN TERBARU --}}
<div class="rounded-2xl bg-white border border-slate-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-semibold text-slate-800">Pesanan Terbaru</h3>
        <a href="{{ route('admin.orders.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-500">Lihat semua</a>
    </div>
    <div class="overflow-x-auto table-scroll">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-center">
                <tr>
                    <th class="px-4 py-3 font-medium">No. Pesanan</th>
                    <th class="px-4 py-3 font-medium">Pelanggan</th>
                    <th class="px-4 py-3 font-medium">Produk Dipesan</th>
                    <th class="px-4 py-3 font-medium">Jumlah</th>
                    <th class="px-4 py-3 font-medium">Total</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($recentOrders as $order)
                    @php
                        $statusColors = [
                            'pending' => 'bg-amber-50 text-amber-700',
                            'paid' => 'bg-blue-50 text-blue-700',
                            'processing' => 'bg-indigo-50 text-indigo-700',
                            'shipped' => 'bg-violet-50 text-violet-700',
                            'completed' => 'bg-green-50 text-green-700',
                            'cancelled' => 'bg-red-50 text-red-700',
                        ];
                        $qty = $order->items->sum('quantity');
                    @endphp
                    <tr class="hover:bg-slate-50/50 text-center cursor-pointer" onclick="window.location='{{ route('admin.orders.show', $order) }}'">
                        <td class="px-4 py-3.5 font-medium text-slate-800 whitespace-nowrap">{{ $order->order_number }}</td>
                        <td class="px-4 py-3.5 whitespace-nowrap">{{ $order->user->name ?? '-' }}</td>
                        <td class="px-4 py-3.5">
                            <ul class="space-y-0.5 text-xs text-slate-600">
                                @foreach($order->items as $item)
                                    <li>
                                        <span class="font-medium text-slate-800">{{ $item->product_name }}</span>
                                        <span class="text-slate-400">×{{ $item->quantity }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-4 py-3.5 font-semibold text-slate-700">{{ $qty }}</td>
                        <td class="px-4 py-3.5 font-semibold whitespace-nowrap">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-4 py-3.5">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-600' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-slate-400">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Chart.js CDN + init --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const charts = @json($charts);
    const isMobile = window.innerWidth < 640;
    const gridColor = 'rgba(148, 163, 184, 0.15)';
    const tickColor = '#94a3b8';

    // --- Penjualan 7 hari (line + bar) ---
    new Chart(document.getElementById('chartSales'), {
        data: {
            labels: charts.sales.labels,
            datasets: [
                {
                    type: 'line',
                    label: 'Pendapatan (Rp)',
                    data: charts.sales.revenue,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.12)',
                    fill: true,
                    tension: 0.35,
                    yAxisID: 'y',
                    pointRadius: isMobile ? 2 : 4,
                    pointBackgroundColor: '#6366f1',
                },
                {
                    type: 'bar',
                    label: 'Pesanan',
                    data: charts.sales.orders,
                    backgroundColor: 'rgba(16, 185, 129, 0.55)',
                    borderRadius: 6,
                    yAxisID: 'y1',
                    maxBarThickness: 28,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            devicePixelRatio: window.devicePixelRatio || 1,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { position: 'top', labels: { boxWidth: 12, usePointStyle: true, font: { size: 11 } } },
                tooltip: {
                    callbacks: {
                        label: function (ctx) {
                            if (ctx.dataset.yAxisID === 'y') {
                                return ' Rp' + Number(ctx.raw).toLocaleString('id-ID');
                            }
                            return ' ' + ctx.raw + ' pesanan';
                        }
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { color: tickColor, font: { size: 11 } } },
                y: {
                    position: 'left',
                    grid: { color: gridColor },
                    ticks: {
                        color: tickColor,
                        font: { size: 10 },
                        callback: v => 'Rp' + (v >= 1000 ? (v/1000) + 'k' : v)
                    }
                },
                y1: {
                    position: 'right',
                    grid: { drawOnChartArea: false },
                    ticks: { color: tickColor, font: { size: 10 }, stepSize: 1 },
                    beginAtZero: true,
                }
            }
        }
    });

    // --- Status pesanan (doughnut) ---
    new Chart(document.getElementById('chartStatus'), {
        type: 'doughnut',
        data: {
            labels: charts.status.labels,
            datasets: [{
                data: charts.status.data,
                backgroundColor: [
                    '#f59e0b', // pending
                    '#3b82f6', // paid
                    '#6366f1', // processing
                    '#8b5cf6', // shipped
                    '#22c55e', // completed
                    '#ef4444', // cancelled
                ],
                borderWidth: 0,
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '62%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 10, usePointStyle: true, font: { size: 11 }, padding: 12 }
                }
            }
        }
    });

    // --- Top produk (horizontal bar) ---
    new Chart(document.getElementById('chartTopProducts'), {
        type: 'bar',
        data: {
            labels: charts.topProducts.labels.length ? charts.topProducts.labels : ['Belum ada data'],
            datasets: [{
                label: 'Unit terjual',
                data: charts.topProducts.data.length ? charts.topProducts.data : [0],
                backgroundColor: [
                    'rgba(99, 102, 241, 0.85)',
                    'rgba(139, 92, 246, 0.75)',
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(16, 185, 129, 0.65)',
                    'rgba(245, 158, 11, 0.6)',
                ],
                borderRadius: 8,
                maxBarThickness: 26,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: { color: tickColor, font: { size: 11 }, stepSize: 1 }
                },
                y: {
                    grid: { display: false },
                    ticks: { color: '#475569', font: { size: 11 } }
                }
            }
        }
    });

    // --- Pendapatan 6 bulan (area) ---
    new Chart(document.getElementById('chartMonthly'), {
        type: 'line',
        data: {
            labels: charts.monthly.labels,
            datasets: [{
                label: 'Pendapatan',
                data: charts.monthly.revenue,
                borderColor: '#f59e0b',
                backgroundColor: 'rgba(245, 158, 11, 0.15)',
                fill: true,
                tension: 0.4,
                pointRadius: isMobile ? 3 : 5,
                pointBackgroundColor: '#f59e0b',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' Rp' + Number(ctx.raw).toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { color: tickColor, font: { size: 11 } } },
                y: {
                    beginAtZero: true,
                    grid: { color: gridColor },
                    ticks: {
                        color: tickColor,
                        font: { size: 10 },
                        callback: v => 'Rp' + (v >= 1000000 ? (v/1000000).toFixed(1) + 'jt' : v >= 1000 ? (v/1000) + 'k' : v)
                    }
                }
            }
        }
    });
});
</script>
@endsection
