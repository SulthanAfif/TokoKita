@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<h1 class="text-2xl font-bold text-slate-800 mb-8">Keranjang Belanja</h1>

@if($cart->items->isEmpty())
    <div class="text-center py-20">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100 flex items-center justify-center">
            <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.892-4.7 2.354-7.135A1.125 1.125 0 0018.75 5.25H5.106M7.5 14.25L5.106 5.25M7.5 14.25L4.5 18.75m0 0h15" />
            </svg>
        </div>
        <p class="text-slate-400 mb-3">Keranjang Anda masih kosong.</p>
        <a href="{{ route('products.index') }}" class="text-indigo-600 font-medium hover:text-indigo-500">Mulai belanja →</a>
    </div>
@else
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <div class="lg:col-span-2 space-y-3">
        @foreach($cart->items as $item)
            <div class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4">
                <div class="w-20 h-20 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0">
                    @if($item->product->thumbnail)
                        <img src="{{ $item->product->thumbnail_url }}" class="w-full h-full object-cover" alt="">
                    @endif
                </div>

                <div class="flex-1 min-w-0">
                    <a href="{{ route('products.show', $item->product->slug) }}"
                       class="font-semibold text-slate-800 text-sm hover:text-indigo-600 line-clamp-1">
                        {{ $item->product->name }}
                    </a>
                    <p class="text-indigo-600 font-bold text-sm mt-1">
                        Rp{{ number_format($item->product->final_price, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-slate-400 mt-0.5">
                        Subtotal: Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                    </p>
                </div>

                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-1">
                    @csrf @method('PATCH')
                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                           max="{{ $item->product->stock }}"
                           onchange="this.form.submit()"
                           class="w-16 rounded-lg border-slate-300 text-center text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </form>

                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition" title="Hapus">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </button>
                </form>
            </div>
        @endforeach
    </div>

    {{-- Ringkasan --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 h-fit sticky top-24">
        <h3 class="font-semibold text-slate-800 mb-4">Ringkasan Belanja</h3>
        <div class="flex justify-between text-sm mb-1">
            <span class="text-slate-500">Subtotal ({{ $cart->items->sum('quantity') }} item)</span>
            <span class="font-semibold">Rp{{ number_format($cart->total, 0, ',', '.') }}</span>
        </div>
        <p class="text-xs text-slate-400 mb-5">Ongkos kirim dihitung saat checkout.</p>
        <a href="{{ route('checkout.index') }}"
           class="block text-center rounded-full bg-indigo-600 text-white font-semibold py-3 hover:bg-indigo-500 shadow-lg shadow-indigo-200 transition">
            Lanjut ke Checkout
        </a>
        <a href="{{ route('products.index') }}"
           class="block text-center text-sm text-slate-500 hover:text-indigo-600 mt-3 transition">
            ← Lanjut belanja
        </a>
    </div>
</div>
@endif
@endsection
