{{-- Kartu produk --}}
<a href="{{ route('products.show', $product->slug) }}"
   class="group flex flex-col rounded-2xl bg-white border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl hover:shadow-indigo-500/10 hover:border-indigo-100 hover:-translate-y-1 transition-all duration-300">

    <div class="aspect-square bg-gradient-to-br from-slate-50 to-slate-100 overflow-hidden relative">
        @if($product->thumbnail)
            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                 loading="lazy">
        @else
            <div class="w-full h-full flex items-center justify-center text-slate-300">
                <svg class="w-14 h-14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                </svg>
            </div>
        @endif

        @if($product->has_discount)
            @php
                $pct = $product->price > 0
                    ? round((($product->price - $product->final_price) / $product->price) * 100)
                    : 0;
            @endphp
            <span class="absolute top-2.5 left-2.5 bg-gradient-to-r from-red-500 to-rose-500 text-white text-[11px] font-bold px-2.5 py-1 rounded-full shadow-md">
                -{{ $pct }}%
            </span>
        @endif

        {{-- Hover overlay --}}
        <div class="absolute inset-x-0 bottom-0 p-3 translate-y-full group-hover:translate-y-0 transition duration-300">
            <span class="block text-center rounded-xl bg-indigo-600/95 backdrop-blur text-white text-xs font-semibold py-2 shadow-lg">
                Lihat Detail
            </span>
        </div>
    </div>

    <div class="p-3.5 sm:p-4 flex flex-col flex-1">
        @if($product->category)
            <p class="text-[10px] sm:text-[11px] text-indigo-500 font-semibold uppercase tracking-wider">{{ $product->category->name }}</p>
        @endif
        <h3 class="mt-1 text-sm font-semibold text-slate-800 line-clamp-2 leading-snug group-hover:text-indigo-600 transition">
            {{ $product->name }}
        </h3>

        <div class="mt-auto pt-2.5 flex items-baseline gap-1.5 flex-wrap">
            <span class="text-indigo-600 font-extrabold text-sm sm:text-base">
                Rp{{ number_format($product->final_price, 0, ',', '.') }}
            </span>
            @if($product->has_discount)
                <span class="text-xs text-slate-400 line-through">
                    Rp{{ number_format($product->price, 0, ',', '.') }}
                </span>
            @endif
        </div>
    </div>
</a>
