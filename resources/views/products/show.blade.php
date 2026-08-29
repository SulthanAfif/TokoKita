@extends('layouts.app')

@section('title', $product->name)

@section('content')
{{-- Breadcrumb --}}
<nav class="text-sm text-slate-500 mb-6">
    <a href="{{ route('home') }}" class="hover:text-indigo-600">Beranda</a>
    <span class="mx-1.5">/</span>
    <a href="{{ route('products.index') }}" class="hover:text-indigo-600">Produk</a>
    @if($product->category)
        <span class="mx-1.5">/</span>
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-indigo-600">{{ $product->category->name }}</a>
    @endif
    <span class="mx-1.5">/</span>
    <span class="text-slate-800">{{ $product->name }}</span>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

    {{-- Gambar (ukuran diperkecil) --}}
    <div class="flex justify-center lg:justify-start">
        <div class="w-full max-w-[320px] sm:max-w-[360px] aspect-square rounded-2xl bg-slate-100 overflow-hidden border border-slate-200 shadow-sm">
            @if($product->thumbnail)
                <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-slate-300">
                    <svg class="w-14 h-14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                    </svg>
                </div>
            @endif
        </div>
    </div>

    {{-- Detail --}}
    <div class="flex flex-col">
        @if($product->category)
            <p class="text-sm text-indigo-500 font-medium">{{ $product->category->name }}</p>
        @endif
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 mt-1 leading-tight">{{ $product->name }}</h1>

        <div class="mt-4 flex items-center gap-3">
            <span class="text-2xl sm:text-3xl font-bold text-indigo-600">
                Rp{{ number_format($product->final_price, 0, ',', '.') }}
            </span>
            @if($product->has_discount)
                <span class="text-lg text-slate-400 line-through">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-0.5 rounded-full">DISKON</span>
            @endif
        </div>

        <p class="mt-3 text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
            @if($product->stock > 0)
                ✓ Stok tersedia: {{ $product->stock }}
            @else
                ✗ Stok habis
            @endif
        </p>

        @if($product->description)
            <div class="mt-6 text-slate-600 leading-relaxed text-sm sm:text-base">
                {{ $product->description }}
            </div>
        @endif

        <div class="mt-8">
            @auth
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex flex-wrap items-center gap-3">
                        @csrf
                        <div class="flex items-center rounded-full border border-slate-300 overflow-hidden">
                            <button type="button" onclick="this.nextElementSibling.stepDown()"
                                    class="px-3 py-2.5 text-slate-500 hover:bg-slate-50 text-lg leading-none">−</button>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                   class="w-14 border-0 text-center text-sm focus:ring-0 py-2.5">
                            <button type="button" onclick="this.previousElementSibling.stepUp()"
                                    class="px-3 py-2.5 text-slate-500 hover:bg-slate-50 text-lg leading-none">+</button>
                        </div>
                        <button type="submit"
                                class="flex-1 sm:flex-none rounded-full bg-indigo-600 text-white px-8 py-3 font-semibold hover:bg-indigo-500 shadow-lg shadow-indigo-200 transition">
                            Tambah ke Keranjang
                        </button>
                    </form>
                @else
                    <button disabled class="rounded-full bg-slate-200 text-slate-500 px-8 py-3 font-semibold cursor-not-allowed">
                        Stok Habis
                    </button>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="inline-block rounded-full bg-indigo-600 text-white px-8 py-3 font-semibold hover:bg-indigo-500 shadow-lg shadow-indigo-200 transition">
                    Masuk untuk Membeli
                </a>
            @endauth
        </div>
    </div>
</div>

{{-- Produk terkait --}}
@if($related->isNotEmpty())
<section class="mt-16">
    <h2 class="text-xl font-bold text-slate-800 mb-6">Produk Terkait</h2>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        @foreach($related as $item)
            @include('products._card', ['product' => $item])
        @endforeach
    </div>
</section>
@endif
@endsection
