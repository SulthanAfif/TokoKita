{{-- Ikon keranjang + badge notifikasi --}}
@props([
    'count' => null,
    'size' => 'md',
])

@php
    $count = $count ?? ($cartCount ?? 0);
    $iconClass = match($size) {
        'sm' => 'w-5 h-5',
        'lg' => 'w-7 h-7',
        default => 'w-6 h-6',
    };
    $padClass = match($size) {
        'sm' => 'p-2',
        'lg' => 'p-3',
        default => 'p-2.5',
    };
@endphp

<a href="{{ auth()->check() ? route('cart.index') : route('login') }}"
   {{ $attributes->merge([
       'class' => "relative inline-flex items-center justify-center {$padClass} text-slate-600 rounded-lg
                   transition-all duration-200
                   hover:text-indigo-600 hover:bg-indigo-50 hover:scale-110 active:scale-95",
       'title' => 'Keranjang' . ($count > 0 ? " ({$count} item)" : ''),
       'aria-label' => 'Keranjang belanja' . ($count > 0 ? ", {$count} item" : ''),
   ]) }}>
    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconClass }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.892-4.7 2.354-7.135A1.125 1.125 0 0018.75 5.25H5.106M7.5 14.25L5.106 5.25M7.5 14.25L4.5 18.75m0 0h15" />
    </svg>

    @if($count > 0)
        <span class="absolute -top-0.5 -right-0.5 z-10 flex h-5 min-w-[1.25rem] items-center justify-center
                     rounded-full bg-red-500 px-1 text-[10px] font-bold leading-none text-white
                     ring-2 ring-white shadow-md
                     animate-[cart-pop_0.45s_ease-out]">
            {{ $count > 99 ? '99+' : $count }}
        </span>
    @endif
</a>

@once
<style>
@keyframes cart-pop {
    0% { transform: scale(0); opacity: 0; }
    55% { transform: scale(1.25); opacity: 1; }
    100% { transform: scale(1); opacity: 1; }
}
</style>
@endonce
