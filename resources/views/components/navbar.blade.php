{{-- Navbar TokoKita — gaya referensi marketplace --}}
<header class="sticky top-0 z-50 bg-white border-b border-slate-200/80 shadow-sm" x-data="{ mobileOpen: false }">

    {{-- ===== BAR AT (Tentang & Kontak di atas) ===== --}}
    <div class="hidden md:block border-b border-slate-100 bg-slate-50/80">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-end h-9 gap-1 text-xs">
                <a href="{{ route('pages.about') }}"
                   class="px-2.5 py-1 text-slate-500 hover:text-indigo-600 transition-colors duration-200
                          {{ request()->routeIs('pages.about') ? 'text-indigo-600 font-medium' : '' }}">
                    Tentang
                </a>
                <span class="text-slate-300">|</span>
                <a href="{{ route('pages.contact') }}"
                   class="px-2.5 py-1 text-slate-500 hover:text-indigo-600 transition-colors duration-200
                          {{ request()->routeIs('pages.contact') ? 'text-indigo-600 font-medium' : '' }}">
                    Kontak
                </a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <span class="text-slate-300">|</span>
                        <a href="{{ route('admin.dashboard') }}"
                           class="px-2.5 py-1 text-indigo-600 font-medium hover:text-indigo-500 transition-colors duration-200">
                            Admin Panel
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    {{-- ===== BAR UTAMA (lebih lebar & tinggi) ===== --}}
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center h-[68px] gap-4 lg:gap-6">

            {{-- Logo + Produk --}}
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('home') }}"
                   class="text-2xl font-extrabold tracking-tight transition-transform duration-200 hover:scale-105 active:scale-95">
                    <span class="text-indigo-600">Toko</span><span class="text-slate-800">Kita</span>
                </a>
                <a href="{{ route('products.index') }}"
                   class="hidden sm:inline-flex items-center gap-1 px-3 py-2 text-sm font-medium text-slate-600 rounded-lg
                          transition-all duration-200 hover:text-indigo-600 hover:bg-indigo-50
                          {{ request()->routeIs('products.*') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                    Produk
                </a>
            </div>

            {{-- Search (lebar, tengah) --}}
            <form action="{{ route('products.index') }}" method="GET" class="hidden sm:flex flex-1 min-w-0">
                <div class="relative w-full group">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari produk..."
                           class="w-full rounded-lg border border-slate-200 bg-white pl-4 pr-12 py-2.5 text-sm
                                  transition-all duration-300 ease-out
                                  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:shadow-md focus:shadow-indigo-50
                                  group-hover:border-indigo-300">
                    <button type="submit"
                            class="absolute right-1.5 top-1/2 -translate-y-1/2 flex items-center justify-center
                                   w-9 h-8 rounded-md bg-indigo-600 text-white
                                   transition-all duration-200 hover:bg-indigo-500 hover:scale-105 active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Kanan: Keranjang | pembatas | Auth --}}
            <div class="hidden sm:flex items-center shrink-0 gap-1">
                @auth
                    {{-- Ikon: Pesanan · Keranjang · Notifikasi · Avatar --}}
                    <x-orders-icon />
                    <x-cart-icon />
                    <x-notif-icon />

                    <div class="w-px h-7 bg-slate-200 mx-2"></div>

                    <x-profile-avatar />

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="px-2.5 py-2 text-sm font-medium text-slate-500 rounded-lg transition-all duration-200
                                       hover:text-red-600 hover:bg-red-50" title="Keluar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                        </button>
                    </form>
                @else
                    {{-- Keranjang + notifikasi --}}
                    <x-cart-icon />

                    {{-- Pembatas antara keranjang dan Masuk/Daftar --}}
                    <div class="w-px h-7 bg-slate-200 mx-2"></div>

                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-sm font-semibold text-indigo-600 border border-indigo-600 rounded-lg
                              transition-all duration-200 hover:bg-indigo-50 hover:scale-[1.02] active:scale-95">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="ml-1.5 px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow-sm
                              transition-all duration-200 hover:bg-indigo-500 hover:scale-[1.02] hover:shadow-md hover:shadow-indigo-200 active:scale-95">
                        Daftar
                    </a>
                @endauth
            </div>

            {{-- Mobile --}}
            <div class="flex items-center gap-1 sm:hidden ml-auto">
                @auth
                    <x-orders-icon />
                    <x-cart-icon size="sm" />
                    <x-notif-icon />
                    <x-profile-avatar />
                @else
                    <x-cart-icon size="sm" />
                @endauth
                <button @click="mobileOpen = !mobileOpen" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="sm:hidden border-t border-slate-100 bg-white">
        <div class="px-4 py-3 space-y-1">
            <form action="{{ route('products.index') }}" method="GET" class="mb-3">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari produk..."
                       class="w-full rounded-lg border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </form>
            <a href="{{ route('products.index') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Produk</a>
            <a href="{{ route('pages.about') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Tentang</a>
            <a href="{{ route('pages.contact') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Kontak</a>
            @auth
                <a href="{{ route('orders.index') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Pesanan</a>
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Profil</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-indigo-600 hover:bg-indigo-50 transition">Admin Panel</a>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Masuk</a>
                <a href="{{ route('register') }}" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-indigo-600 hover:bg-indigo-50 transition">Daftar</a>
            @endauth
        </div>
    </div>
</header>
