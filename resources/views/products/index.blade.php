@extends('layouts.app')

@section('title', 'Semua Produk')

@section('content')

{{-- ========== TAB KATEGORI HORIZONTAL (gaya marketplace) ========== --}}
<div class="-mx-4 sm:-mx-6 lg:-mx-8 mb-6">
    <div class="border-b border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-1 overflow-x-auto py-0
                        [scrollbar-width:none] [-ms-overflow-style:none]
                        [&::-webkit-scrollbar]:hidden">

                <a href="{{ route('products.index', request()->only('search', 'sort')) }}"
                   class="relative shrink-0 px-4 py-3.5 text-sm font-medium whitespace-nowrap transition-all duration-200
                          {{ !request('category') ? 'text-indigo-600' : 'text-slate-600 hover:text-indigo-600' }}">
                    Semua
                    @unless(request('category'))
                        <span class="absolute bottom-0 left-2 right-2 h-0.5 rounded-full bg-indigo-600"></span>
                    @endunless
                </a>

                @foreach($categories as $category)
                    <a href="{{ route('products.index', array_merge(request()->only('search', 'sort'), ['category' => $category->slug])) }}"
                       class="relative shrink-0 px-4 py-3.5 text-sm font-medium whitespace-nowrap transition-all duration-200
                              {{ request('category') == $category->slug ? 'text-indigo-600' : 'text-slate-600 hover:text-indigo-600' }}">
                        {{ $category->name }}
                        @if(request('category') == $category->slug)
                            <span class="absolute bottom-0 left-2 right-2 h-0.5 rounded-full bg-indigo-600"></span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ========== HEADER + SORT ========== --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-lg font-bold text-slate-800">
            @if(request('category'))
                {{ $categories->firstWhere('slug', request('category'))?->name ?? 'Produk' }}
            @elseif(request('search'))
                Hasil: “{{ request('search') }}”
            @else
                Semua Produk
            @endif
        </h1>
        <p class="text-sm text-slate-500">{{ $products->total() }} produk ditemukan</p>
    </div>

    <form method="GET" class="flex items-center gap-2">
        <input type="hidden" name="search" value="{{ request('search') }}">
        <input type="hidden" name="category" value="{{ request('category') }}">
        <label class="text-xs text-slate-400 hidden sm:inline">Urutkan</label>
        <select name="sort" onchange="this.form.submit()"
                class="text-sm rounded-lg border-slate-200 bg-white focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">Terbaru</option>
            <option value="price_asc" @selected(request('sort')=='price_asc')>Harga Terendah</option>
            <option value="price_desc" @selected(request('sort')=='price_desc')>Harga Tertinggi</option>
        </select>
    </form>
</div>

{{-- ========== GRID PRODUK ========== --}}
@if($products->isEmpty())
    <div class="text-center py-20 text-slate-400">
        <p class="text-base">Produk tidak ditemukan.</p>
        <a href="{{ route('products.index') }}" class="inline-block mt-3 text-sm font-medium text-indigo-600 hover:underline">Lihat semua produk</a>
    </div>
@else
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        @foreach($products as $product)
            @include('products._card', ['product' => $product])
        @endforeach
    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>
@endif

@endsection
