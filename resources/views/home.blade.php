@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- ========== HERO ========== --}}
<section
    x-data="{
        slides: {{ $heroSlides->map(fn($s) => ['url' => $s->image_url])->values()->toJson() }},
        current: 0,
        timer: null,
        init() {
            if (this.slides.length > 1) {
                this.timer = setInterval(() => {
                    this.current = (this.current + 1) % this.slides.length;
                }, 5000);
            }
        },
        destroy() {
            if (this.timer) clearInterval(this.timer);
        }
    }"
    class="relative overflow-hidden rounded-[2rem] text-white shadow-2xl shadow-indigo-500/25 min-h-[420px] sm:min-h-[480px]"
>
    {{-- Background: gradient fallback OR slideshow images --}}
    <template x-if="slides.length === 0">
        <div class="absolute inset-0 bg-gradient-to-br from-violet-600 via-indigo-600 to-blue-600"></div>
    </template>
    <template x-if="slides.length > 0">
        <div class="absolute inset-0">
            <template x-for="(slide, index) in slides" :key="index">
                <div
                    class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 ease-in-out"
                    :class="index === current ? 'opacity-100' : 'opacity-0'"
                    :style="'background-image: url(' + slide.url + ')'"
                ></div>
            </template>
            {{-- Dark overlay agar teks tetap terbaca --}}
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-950/80 via-indigo-900/60 to-violet-900/40"></div>
        </div>
    </template>

    {{-- Decorative blobs (hanya jika tidak ada slide) --}}
    <template x-if="slides.length === 0">
        <div>
            <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-pink-500/30 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-16 w-96 h-96 rounded-full bg-cyan-400/20 blur-3xl"></div>
            <div class="absolute top-1/2 right-1/4 w-40 h-40 rounded-full bg-yellow-400/10 blur-2xl"></div>
        </div>
    </template>

    <div class="relative grid lg:grid-cols-2 gap-8 items-center px-5 py-10 sm:px-10 sm:py-16 lg:px-12 lg:py-20">
        <div>
            <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 backdrop-blur px-3.5 py-1.5 text-xs font-semibold tracking-wide mb-5 border border-white/20">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                {{ $home['hero_badge'] }}
            </span>

            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-[3.25rem] font-extrabold tracking-tight leading-[1.1]">
                {{ $home['hero_title_1'] }}<br>
                <span class="bg-gradient-to-r from-yellow-200 via-pink-200 to-white bg-clip-text text-transparent">{{ $home['hero_title_2'] }}</span>
            </h1>

            <p class="mt-5 text-indigo-100 max-w-md text-base sm:text-lg leading-relaxed">
                {{ $home['hero_subtitle'] }}
            </p>

            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center gap-2 rounded-full bg-white text-indigo-700 font-bold px-7 py-3.5 hover:scale-105 shadow-xl shadow-black/10 transition duration-200">
                    Mulai Belanja
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
                <a href="{{ route('pages.about') }}"
                   class="inline-flex items-center rounded-full border-2 border-white/40 text-white font-semibold px-6 py-3.5 hover:bg-white/10 transition">
                    Tentang Kami
                </a>
            </div>

            {{-- Stats --}}
            <div class="mt-10 flex flex-wrap gap-6 sm:gap-10">
                <div>
                    <p class="text-2xl sm:text-3xl font-extrabold">{{ $home['stat1_value'] }}</p>
                    <p class="text-xs text-indigo-200 mt-0.5">{{ $home['stat1_label'] }}</p>
                </div>
                <div>
                    <p class="text-2xl sm:text-3xl font-extrabold">{{ $home['stat2_value'] }}</p>
                    <p class="text-xs text-indigo-200 mt-0.5">{{ $home['stat2_label'] }}</p>
                </div>
                <div>
                    <p class="text-2xl sm:text-3xl font-extrabold">{{ $home['stat3_value'] }}</p>
                    <p class="text-xs text-indigo-200 mt-0.5">{{ $home['stat3_label'] }}</p>
                </div>
            </div>
        </div>

        {{-- Right side decorative cards --}}
        <div class="hidden lg:flex justify-center relative">
            <div class="relative w-72 h-72">
                <div class="absolute inset-0 rounded-[2rem] bg-white/10 backdrop-blur-sm border border-white/20 rotate-6"></div>
                <div class="absolute inset-0 rounded-[2rem] bg-white/15 backdrop-blur-sm border border-white/25 -rotate-3 flex flex-col items-center justify-center p-8">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-yellow-300 to-orange-400 flex items-center justify-center mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                        </svg>
                    </div>
                    <p class="text-lg font-bold text-center">{!! nl2br(e($home['hero_card_title'])) !!}</p>
                    <p class="text-sm text-indigo-100 mt-2 text-center">{{ $home['hero_card_subtitle'] }}</p>
                </div>
                <div class="absolute -top-4 -right-4 bg-gradient-to-r from-pink-500 to-rose-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg rotate-12">
                    {{ $home['hero_badge_promo'] }}
                </div>
                <div class="absolute -bottom-3 -left-6 bg-white text-indigo-700 text-xs font-bold px-3 py-1.5 rounded-full shadow-lg -rotate-6">
                    {{ $home['hero_badge_flash'] }}
                </div>
            </div>
        </div>
    </div>

    {{-- Indikator slide (dots) --}}
    <template x-if="slides.length > 1">
        <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2 z-10">
            <template x-for="(slide, index) in slides" :key="'dot-'+index">
                <button
                    type="button"
                    @click="current = index"
                    class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                    :class="index === current ? 'bg-white scale-110' : 'bg-white/40 hover:bg-white/70'"
                    :aria-label="'Slide ' + (index + 1)"
                ></button>
            </template>
        </div>
    </template>
</section>

{{-- ========== TRUST BAR ========== --}}
<section class="mt-8 grid grid-cols-2 lg:grid-cols-4 gap-3">
    @foreach($home['trust'] as $item)
        <div class="flex items-center gap-3 rounded-2xl bg-white border border-slate-100 p-4 shadow-sm hover:shadow-md hover:border-indigo-100 transition">
            <div class="w-11 h-11 shrink-0 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-800">{{ $item['title'] }}</p>
                <p class="text-xs text-slate-400">{{ $item['desc'] }}</p>
            </div>
        </div>
    @endforeach
</section>

{{-- ========== KATEGORI ========== --}}
@if($categories->isNotEmpty())
<section class="mt-14">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">Kategori Pilihan</h2>
            <p class="text-sm text-slate-400 mt-0.5">Temukan produk sesuai kebutuhanmu</p>
        </div>
        <a href="{{ route('products.index') }}"
           class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 flex items-center gap-1">
            Lihat semua
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
        </a>
    </div>

    @php
        $gradients = [
            'from-blue-500 to-cyan-400',
            'from-pink-500 to-rose-400',
            'from-violet-500 to-purple-400',
            'from-amber-500 to-orange-400',
            'from-emerald-500 to-teal-400',
            'from-indigo-500 to-blue-400',
        ];
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3 sm:gap-4">
        @foreach($categories as $i => $category)
            <a href="{{ route('products.index', ['category' => $category->slug]) }}"
               class="group relative overflow-hidden rounded-2xl p-5 text-center text-white shadow-lg hover:shadow-xl hover:-translate-y-1 transition duration-300 bg-gradient-to-br {{ $gradients[$i % count($gradients)] }}">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition"></div>
                <div class="relative">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center group-hover:scale-110 transition duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                        </svg>
                    </div>
                    <div class="text-sm font-bold">{{ $category->name }}</div>
                    <div class="text-[11px] text-white/70 mt-0.5">{{ $category->products_count }} produk</div>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif

{{-- ========== PROMO STRIP ========== --}}
<section class="mt-14 relative overflow-hidden rounded-2xl bg-gradient-to-r from-rose-500 via-pink-500 to-orange-400 p-6 sm:p-8 text-white shadow-lg shadow-pink-500/20">
    <div class="absolute -right-8 -top-8 w-40 h-40 rounded-full bg-white/10 blur-2xl"></div>
    <div class="relative flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-white/80 mb-1">{{ $home['promo_eyebrow'] }}</p>
            <h3 class="text-xl sm:text-2xl font-extrabold">{{ $home['promo_title'] }}</h3>
            <p class="text-sm text-white/80 mt-1">{{ $home['promo_subtitle'] }}</p>
        </div>
        <a href="{{ route('products.index') }}"
           class="shrink-0 rounded-full bg-white text-pink-600 font-bold px-6 py-3 hover:scale-105 shadow-lg transition">
            {{ $home['promo_button'] }}
        </a>
    </div>
</section>

{{-- ========== PRODUK TERBARU ========== --}}
<section class="mt-14">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">Produk Terbaru</h2>
            <p class="text-sm text-slate-400 mt-0.5">Baru masuk, siap dibawa pulang</p>
        </div>
        <a href="{{ route('products.index') }}"
           class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 flex items-center gap-1">
            Lihat semua
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
        </a>
    </div>

    @if($featuredProducts->isEmpty())
        <div class="text-center py-20 rounded-2xl bg-white border border-dashed border-slate-200 text-slate-400">
            Belum ada produk.
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
            @foreach($featuredProducts as $product)
                @include('products._card', ['product' => $product])
            @endforeach
        </div>
    @endif
</section>

{{-- ========== CTA BAWAH ========== --}}
<section class="mt-16 relative overflow-hidden rounded-[2rem] bg-slate-900 text-white p-8 sm:p-12 text-center">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/30 via-transparent to-pink-600/20"></div>
    <div class="relative">
        <h2 class="text-2xl sm:text-3xl font-extrabold">Siap mulai belanja?</h2>
        <p class="mt-2 text-slate-300 max-w-md mx-auto">Daftar gratis dan nikmati pengalaman belanja online yang mudah & aman.</p>
        <div class="mt-6 flex flex-wrap justify-center gap-3">
            <a href="{{ route('products.index') }}"
               class="rounded-full bg-indigo-500 hover:bg-indigo-400 text-white font-bold px-7 py-3 transition shadow-lg shadow-indigo-500/30">
                Jelajahi Produk
            </a>
            @guest
            <a href="{{ route('register') }}"
               class="rounded-full border border-white/30 hover:bg-white/10 text-white font-semibold px-7 py-3 transition">
                Daftar Sekarang
            </a>
            @endguest
        </div>
    </div>
</section>

@endsection
