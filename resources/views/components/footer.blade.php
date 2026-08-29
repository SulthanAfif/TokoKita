<footer class="mt-20 border-t border-slate-200 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8">
            <div class="col-span-2 md:col-span-1">
                <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">
                    <span class="text-indigo-600">Toko</span><span class="text-slate-800">Kita</span>
                </a>
                <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                    Belanja online terpercaya dengan produk berkualitas dan harga bersahabat.
                </p>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-slate-800 mb-3">Jelajahi</h4>
                <ul class="space-y-2 text-sm text-slate-500">
                    <li><a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition">Semua Produk</a></li>
                    <li><a href="{{ route('pages.about') }}" class="hover:text-indigo-600 transition">Tentang Kami</a></li>
                    <li><a href="{{ route('pages.contact') }}" class="hover:text-indigo-600 transition">Hubungi Kami</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-slate-800 mb-3">Akun</h4>
                <ul class="space-y-2 text-sm text-slate-500">
                    @auth
                        <li><a href="{{ route('orders.index') }}" class="hover:text-indigo-600 transition">Pesanan Saya</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-indigo-600 transition">Keranjang</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="hover:text-indigo-600 transition">Profil</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:text-indigo-600 transition">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-indigo-600 transition">Daftar</a></li>
                    @endauth
                </ul>
            </div>

            <div>
                <h4 class="text-sm font-semibold text-slate-800 mb-3">Kontak</h4>
                <ul class="space-y-2 text-sm text-slate-500">
                    <li>support@tokokita.com</li>
                    <li>+62 812-3456-7890</li>
                    <li>Jakarta, Indonesia</li>
                </ul>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-slate-100 text-center text-sm text-slate-400">
            &copy; {{ date('Y') }} TokoKita. All rights reserved.
        </div>
    </div>
</footer>
