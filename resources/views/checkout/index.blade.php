@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<h1 class="text-2xl font-bold text-slate-800 mb-8">Checkout</h1>

<form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    @csrf

    <div class="lg:col-span-2 space-y-6">
        {{-- ALAMAT --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Alamat Pengiriman</h3>

            @forelse($addresses as $address)
                <label class="flex items-start gap-3 border border-slate-200 rounded-xl p-4 mb-3 cursor-pointer has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="address_id" value="{{ $address->id }}" class="mt-1" required>
                    <div class="text-sm">
                        <p class="font-semibold">{{ $address->recipient_name }} &middot; {{ $address->phone }}</p>
                        <p class="text-slate-500">{{ $address->full_address }}, {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
                    </div>
                </label>
            @empty
                <p class="text-sm text-slate-400">Anda belum punya alamat tersimpan. Tambahkan alamat di halaman profil terlebih dahulu.</p>
            @endforelse
        </div>

        {{-- METODE PEMBAYARAN --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Metode Pembayaran</h3>
            @foreach(['transfer_bank' => 'Transfer Bank', 'e_wallet' => 'E-Wallet', 'cod' => 'Bayar di Tempat (COD)'] as $value => $label)
                <label class="flex items-center gap-3 border border-slate-200 rounded-xl p-4 mb-3 cursor-pointer has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="payment_method" value="{{ $value }}" required>
                    <span class="text-sm font-medium">{{ $label }}</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- RINGKASAN --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 h-fit">
        <h3 class="font-semibold text-slate-800 mb-4">Ringkasan Pesanan</h3>
        @foreach($cart->items as $item)
            <div class="flex justify-between text-sm mb-2">
                <span class="text-slate-500">{{ $item->product->name }} x{{ $item->quantity }}</span>
                <span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
        @endforeach
        <hr class="my-3">
        <div class="flex justify-between text-sm mb-1">
            <span class="text-slate-500">Subtotal</span>
            <span>Rp{{ number_format($cart->total, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-sm mb-3">
            <span class="text-slate-500">Ongkos Kirim</span>
            <span>Rp15.000</span>
        </div>
        <div class="flex justify-between font-bold text-indigo-600 text-base">
            <span>Total</span>
            <span>Rp{{ number_format($cart->total + 15000, 0, ',', '.') }}</span>
        </div>

        <button type="submit"
                class="mt-6 w-full rounded-full bg-indigo-600 text-white font-semibold py-3 hover:bg-indigo-500">
            Buat Pesanan
        </button>
    </div>
</form>
@endsection
