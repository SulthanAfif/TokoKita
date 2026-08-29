@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
@php
    $statusColors = [
        'pending' => 'bg-amber-50 text-amber-700',
        'paid' => 'bg-blue-50 text-blue-700',
        'processing' => 'bg-indigo-50 text-indigo-700',
        'shipped' => 'bg-violet-50 text-violet-700',
        'completed' => 'bg-green-50 text-green-700',
        'cancelled' => 'bg-red-50 text-red-700',
    ];
    $statusLabels = [
        'pending' => 'Menunggu Pembayaran',
        'paid' => 'Sudah Dibayar',
        'processing' => 'Diproses',
        'shipped' => 'Dikirim',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];
    $paymentLabels = [
        'transfer_bank' => 'Transfer Bank',
        'e_wallet' => 'E-Wallet',
        'cod' => 'Bayar di Tempat (COD)',
    ];
@endphp

<div class="max-w-2xl mx-auto">
    <a href="{{ route('orders.index') }}" class="text-sm text-slate-500 hover:text-indigo-600 transition">← Kembali ke pesanan</a>

    <div class="flex flex-wrap items-center gap-3 mt-3 mb-6">
        <h1 class="text-2xl font-bold text-slate-800">{{ $order->order_number }}</h1>
        <span class="inline-block text-xs px-3 py-1 rounded-full font-medium {{ $statusColors[$order->status] ?? 'bg-slate-100' }}">
            {{ $statusLabels[$order->status] ?? $order->status }}
        </span>
    </div>

    {{-- Banner bayar --}}
    @if($order->status === 'pending' && in_array($order->payment_method, ['transfer_bank', 'e_wallet']))
    <div class="rounded-2xl border border-indigo-200 bg-indigo-50 p-6 mb-6">
        <h3 class="font-semibold text-indigo-900 mb-1">Menunggu Pembayaran</h3>
        <p class="text-sm text-indigo-700 mb-4">
            Total: <span class="font-bold text-lg">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
            via {{ $paymentLabels[$order->payment_method] ?? '' }}
        </p>
        <a href="{{ route('orders.payment', $order) }}"
           class="inline-flex items-center justify-center w-full sm:w-auto rounded-full bg-indigo-600 text-white font-semibold px-8 py-3 hover:bg-indigo-500 shadow-lg shadow-indigo-200 transition">
            Bayar Sekarang →
        </a>
        <p class="text-xs text-indigo-600/70 mt-2">Verifikasi otomatis setelah pembayaran. Status langsung update di admin.</p>
    </div>
    @endif

    @if($order->status === 'paid')
    <div class="rounded-2xl border border-green-200 bg-green-50 p-5 mb-6 text-sm text-green-800">
        <p class="font-semibold">✓ Pembayaran terverifikasi otomatis</p>
        <p class="mt-0.5">Dibayar pada {{ $order->paid_at?->format('d M Y, H:i') }}. Menunggu admin memproses pesanan.</p>
    </div>
    @endif

    @if($order->status === 'pending' && $order->payment_method === 'cod')
    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 mb-6 text-sm text-amber-800">
        <p class="font-semibold mb-1">Bayar di Tempat (COD)</p>
        <p>Siapkan uang tunai <strong>Rp{{ number_format($order->total, 0, ',', '.') }}</strong> saat barang tiba.</p>
    </div>
    @endif

    {{-- Item --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 mb-6">
        <h3 class="font-semibold text-slate-800 mb-3">Item Pesanan</h3>
        @foreach($order->items as $item)
            <div class="flex justify-between text-sm mb-2">
                <span class="text-slate-600">{{ $item->product_name }} x{{ $item->quantity }}</span>
                <span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
        @endforeach
        <hr class="my-3 border-slate-100">
        <div class="flex justify-between text-sm mb-1">
            <span class="text-slate-500">Subtotal</span>
            <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-sm mb-1">
            <span class="text-slate-500">Ongkos Kirim</span>
            <span>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between font-bold text-indigo-600">
            <span>Total</span>
            <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Metode Pembayaran --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 mb-6">
        <h3 class="font-semibold text-slate-800 mb-2">Metode Pembayaran</h3>
        <p class="text-sm text-slate-600 mb-3">
            {{ $paymentLabels[$order->payment_method] ?? ($order->payment_method ?? '-') }}
            @if($order->paid_at)
                <span class="text-green-600 text-xs ml-1">· Dibayar {{ $order->paid_at->format('d M Y H:i') }}</span>
            @endif
        </p>

        @if($order->status === 'pending')
            <form action="{{ route('orders.updatePayment', $order) }}" method="POST" class="space-y-3">
                @csrf
                @method('PATCH')
                <label class="block text-xs text-slate-500 mb-1">Ubah metode pembayaran</label>
                <div class="flex flex-wrap gap-2">
                    @foreach(['transfer_bank' => 'Transfer Bank', 'e_wallet' => 'E-Wallet', 'cod' => 'COD'] as $val => $label)
                        <label class="flex items-center gap-2 rounded-xl border border-slate-200 px-3 py-2 text-sm cursor-pointer has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                            <input type="radio" name="payment_method" value="{{ $val }}"
                                   @checked($order->payment_method === $val) required>
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
                <button type="submit"
                        class="mt-2 rounded-full border border-slate-300 text-slate-700 px-5 py-2 text-sm font-medium hover:bg-slate-50 transition">
                    Simpan Metode
                </button>
            </form>
        @endif
    </div>

    {{-- Alamat --}}
    @if($order->address)
    <div class="rounded-2xl border border-slate-200 bg-white p-6 mb-6">
        <h3 class="font-semibold text-slate-800 mb-2">Alamat Pengiriman</h3>
        <p class="text-sm text-slate-600">
            {{ $order->address->recipient_name }} &middot; {{ $order->address->phone }}<br>
            {{ $order->address->full_address }}, {{ $order->address->city }}, {{ $order->address->province }}
            @if($order->address->postal_code) {{ $order->address->postal_code }} @endif
        </p>
    </div>
    @endif

    {{-- Batalkan --}}
    @if($order->status === 'pending')
    <div class="rounded-2xl border border-red-200 bg-red-50 p-5">
        <h3 class="font-semibold text-red-700 mb-1">Batalkan Pesanan</h3>
        <p class="text-sm text-red-600 mb-3">Pesanan yang dibatalkan tidak dapat dikembalikan. Stok produk akan dikembalikan.</p>
        <form action="{{ route('orders.cancel', $order) }}" method="POST"
              onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
            @csrf
            <button type="submit"
                    class="rounded-full bg-red-600 text-white px-5 py-2.5 text-sm font-semibold hover:bg-red-500 transition">
                Batalkan Pesanan
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
