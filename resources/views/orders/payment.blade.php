@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
@php
    $paymentLabels = [
        'transfer_bank' => 'Transfer Bank',
        'e_wallet' => 'E-Wallet',
    ];
@endphp

<div class="max-w-lg mx-auto" x-data="{ processing: false, verified: false }">
    <a href="{{ route('orders.show', $order) }}" class="text-sm text-slate-500 hover:text-indigo-600 transition">← Kembali ke pesanan</a>

    <h1 class="text-2xl font-bold text-slate-800 mt-3 mb-1">Pembayaran</h1>
    <p class="text-sm text-slate-500 mb-6">{{ $order->order_number }} · {{ $paymentLabels[$order->payment_method] ?? '' }}</p>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 mb-5">
        <div class="flex justify-between text-sm mb-1">
            <span class="text-slate-500">Total Pembayaran</span>
            <span class="text-xl font-bold text-indigo-600">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
        </div>
        <p class="text-xs text-slate-400">{{ $order->items->count() }} item</p>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-5 mb-5 space-y-2 text-sm">
        <p class="font-semibold text-slate-800">Pembayaran diproses oleh Midtrans</p>
        <p class="text-slate-500">Klik tombol di bawah untuk membuka jendela pembayaran. Kamu bisa memilih Transfer Bank / Virtual Account, GoPay, QRIS, atau metode lain yang tersedia.</p>
    </div>

    <div x-show="!processing && !verified">
        <button type="button" @click="processing = true; window.payWithMidtrans()"
                class="w-full rounded-full bg-indigo-600 text-white font-semibold py-3.5 hover:bg-indigo-500 shadow-lg shadow-indigo-200 transition flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Bayar Sekarang
        </button>
        <p class="text-xs text-center text-slate-400 mt-3">
            Status pesanan akan otomatis terupdate setelah pembayaran dikonfirmasi oleh Midtrans.
        </p>
    </div>

    <div x-show="processing" x-cloak class="rounded-2xl border border-indigo-200 bg-indigo-50 p-8 text-center">
        <div class="w-12 h-12 mx-auto mb-4 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
        <p class="font-semibold text-indigo-900">Menunggu pembayaran...</p>
        <p class="text-sm text-indigo-600 mt-1">Mohon tunggu sebentar</p>
    </div>
</div>

<script
    src="{{ $isProduction ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
    data-client-key="{{ $clientKey }}"></script>

<script>
    window.payWithMidtrans = function () {
        snap.pay(@json($snapToken), {
            onSuccess: function () {
                window.location.href = "{{ route('orders.show', $order) }}";
            },
            onPending: function () {
                window.location.href = "{{ route('orders.show', $order) }}";
            },
            onError: function () {
                alert('Pembayaran gagal, silakan coba lagi.');
                window.location.reload();
            },
            onClose: function () {
                window.location.reload();
            }
        });
    };
</script>
@endsection