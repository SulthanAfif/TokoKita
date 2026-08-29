@extends('layouts.admin')

@section('title', 'Sisa Stok Produk')

@section('content')
<div class="mb-6">
    <h2 class="text-lg font-semibold text-slate-800">Sisa Stok Produk</h2>
    <p class="text-sm text-slate-500">Pantau stok gudang — diurutkan dari stok paling sedikit</p>
</div>

{{-- Ringkasan --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 mb-6">
    <div class="rounded-2xl bg-white border border-slate-200 p-4">
        <p class="text-[11px] uppercase tracking-wide text-slate-400 font-medium">Total Sisa</p>
        <p class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($summary['total_stock'], 0, ',', '.') }}</p>
        <p class="text-xs text-slate-400">{{ $summary['total_products'] }} produk</p>
    </div>
    <div class="rounded-2xl bg-white border border-red-100 p-4">
        <p class="text-[11px] uppercase tracking-wide text-red-400 font-medium">Habis</p>
        <p class="text-2xl font-bold text-red-600 mt-1">{{ $summary['empty'] }}</p>
        <p class="text-xs text-slate-400">stok ≤ 0</p>
    </div>
    <div class="rounded-2xl bg-white border border-red-100 p-4">
        <p class="text-[11px] uppercase tracking-wide text-red-400 font-medium">Kritis</p>
        <p class="text-2xl font-bold text-red-600 mt-1">{{ $summary['low'] }}</p>
        <p class="text-xs text-slate-400">stok 1–5</p>
    </div>
    <div class="rounded-2xl bg-white border border-amber-100 p-4">
        <p class="text-[11px] uppercase tracking-wide text-amber-500 font-medium">Menipis</p>
        <p class="text-2xl font-bold text-amber-600 mt-1">{{ $summary['medium'] }}</p>
        <p class="text-xs text-slate-400">stok 6–20</p>
    </div>
    <div class="rounded-2xl bg-white border border-green-100 p-4">
        <p class="text-[11px] uppercase tracking-wide text-green-500 font-medium">Aman</p>
        <p class="text-2xl font-bold text-green-600 mt-1">{{ $summary['ok'] }}</p>
        <p class="text-xs text-slate-400">stok &gt; 20</p>
    </div>
</div>

{{-- Filter --}}
<form method="GET" class="flex flex-wrap items-center gap-3 mb-5">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / SKU..."
           class="rounded-xl border-slate-200 bg-white px-4 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
    <select name="filter" onchange="this.form.submit()"
            class="rounded-xl border-slate-200 bg-white px-4 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        <option value="">Semua stok</option>
        <option value="empty" @selected(request('filter')==='empty')>Habis (≤0)</option>
        <option value="low" @selected(request('filter')==='low')>Kritis (≤5)</option>
        <option value="medium" @selected(request('filter')==='medium')>Menipis (6–20)</option>
        <option value="ok" @selected(request('filter')==='ok')>Aman (&gt;20)</option>
    </select>
    <button type="submit" class="rounded-xl bg-slate-800 text-white px-4 py-2 text-sm font-medium hover:bg-slate-700">Filter</button>
    @if(request()->hasAny(['search','filter']))
        <a href="{{ route('admin.stock.index') }}" class="text-sm text-slate-500 hover:text-indigo-600">Reset</a>
    @endif
</form>

<div class="rounded-2xl border border-slate-200 bg-white overflow-hidden">
    <div class="overflow-x-auto table-scroll">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-left">
                <tr>
                    <th class="px-5 py-3 font-medium">Produk</th>
                    <th class="px-5 py-3 font-medium">Kategori</th>
                    <th class="px-5 py-3 font-medium">SKU</th>
                    <th class="px-5 py-3 font-medium">Terjual</th>
                    <th class="px-5 py-3 font-medium">Sisa Stok</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($products as $product)
                    @php
                        if ($product->stock <= 0) {
                            $badge = 'bg-red-50 text-red-700';
                            $label = 'Habis';
                        } elseif ($product->stock <= 5) {
                            $badge = 'bg-red-50 text-red-600';
                            $label = 'Kritis';
                        } elseif ($product->stock <= 20) {
                            $badge = 'bg-amber-50 text-amber-600';
                            $label = 'Menipis';
                        } else {
                            $badge = 'bg-green-50 text-green-600';
                            $label = 'Aman';
                        }
                    @endphp
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-5 py-3.5">
                            <p class="font-medium text-slate-800">{{ $product->name }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-slate-500">{{ $product->category->name ?? '-' }}</td>
                        <td class="px-5 py-3.5 text-xs text-slate-400 font-mono">{{ $product->sku }}</td>
                        <td class="px-5 py-3.5 font-semibold text-emerald-600">{{ (int) ($product->sold_qty ?? 0) }}</td>
                        <td class="px-5 py-3.5">
                            <span class="text-lg font-bold {{ $product->stock <= 5 ? 'text-red-600' : ($product->stock <= 20 ? 'text-amber-600' : 'text-slate-800') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge }}">{{ $label }}</span>
                        </td>
                        <td class="px-5 py-3.5">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition">
                                Edit Stok
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center text-slate-400">Tidak ada produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($products->hasPages())
    <div class="mt-6">{{ $products->links() }}</div>
@endif
@endsection
