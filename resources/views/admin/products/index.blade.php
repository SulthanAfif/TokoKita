@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-800">Daftar Produk</h2>
        <p class="text-sm text-slate-500">{{ $products->total() }} produk terdaftar</p>
    </div>
    <a href="{{ route('admin.products.create') }}"
       class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 text-white px-5 py-2.5 text-sm font-semibold hover:bg-indigo-500 shadow-sm transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
        Tambah Produk
    </a>
</div>

{{-- Search --}}
<form method="GET" class="mb-5">
    <div class="relative max-w-sm">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari produk..."
               class="w-full rounded-xl border-slate-200 bg-white pl-4 pr-10 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </button>
    </div>
</form>

<div class="rounded-2xl border border-slate-200 bg-white overflow-hidden">
    <div class="overflow-x-auto table-scroll">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-left">
                <tr>
                    <th class="px-5 py-3 font-medium">Produk</th>
                    <th class="px-5 py-3 font-medium">Kategori</th>
                    <th class="px-5 py-3 font-medium">Harga</th>
                    <th class="px-5 py-3 font-medium">Terjual</th>
                    <th class="px-5 py-3 font-medium">Sisa Stok</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($products as $product)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-slate-100 overflow-hidden shrink-0">
                                    @if($product->thumbnail)
                                        <img src="{{ $product->thumbnail_url }}" class="w-full h-full object-cover" alt="">
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-slate-800 truncate">{{ $product->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $product->sku }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600">{{ $product->category->name ?? '-' }}</td>
                        <td class="px-5 py-3.5">
                            <p class="font-semibold">Rp{{ number_format($product->final_price, 0, ',', '.') }}</p>
                            @if($product->has_discount)
                                <p class="text-xs text-slate-400 line-through">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 font-semibold text-emerald-600">{{ (int) ($product->sold_qty ?? 0) }}</td>
                        <td class="px-5 py-3.5">
                            <span class="{{ $product->stock <= 5 ? 'text-red-600 font-semibold' : 'text-slate-700' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-50 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                      onsubmit="return confirm('Yakin hapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1.5 rounded-lg text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center text-slate-400">
                            Belum ada produk.
                            <a href="{{ route('admin.products.create') }}" class="text-indigo-600 font-medium">Tambah sekarang →</a>
                        </td>
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
