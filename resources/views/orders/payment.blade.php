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

    {{-- Ringkasan --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 mb-5">
        <div class="flex justify-between text-sm mb-1">
            <span class="text-slate-500">Total Pembayaran</span>
            <span class="text-xl font-bold text-indigo-600">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
        </div>
        <p class="text-xs text-slate-400">{{ $order->items->count() }} item</p>
    </div>

    {{-- Instruksi --}}
    @if($order->payment_method === 'transfer_bank')
    <div class="rounded-2xl border border-slate-200 bg-white p-5 mb-5 space-y-3 text-sm">
        <p class="font-semibold text-slate-800">Transfer ke rekening berikut</p>
        <div class="rounded-xl bg-slate-50 p-4 space-y-2">
            <div class="flex justify-between"><span class="text-slate-500">Bank</span><span class="font-medium">BCA</span></div>
            <div class="flex justify-between items-center">
                <span class="text-slate-500">No. Rekening</span>
                <span class="font-mono font-bold text-slate-800 tracking-wide">1234 5678 90</span>
            </div>
            <div class="flex justify-between"><span class="text-slate-500">Atas Nama</span><span class="font-medium">PT TokoKita Indonesia</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Jumlah Transfer</span><span class="font-bold text-indigo-600">Rp{{ number_format($order->total, 0, ',', '.') }}</span></div>
        </div>
        <p class="text-xs text-slate-400">Pastikan nominal transfer sesuai agar verifikasi otomatis berhasil.</p>
    </div>
    @else
    <div class="rounded-2xl border border-slate-200 bg-white p-5 mb-5 space-y-3 text-sm">
        <p class="font-semibold text-slate-800">Bayar via E-Wallet</p>
        <div class="rounded-xl bg-slate-50 p-4 space-y-2">
            <div class="flex justify-between"><span class="text-slate-500">GoPay / OVO / Dana / ShopeePay</span></div>
            <div class="flex justify-between items-center">
                <span class="text-slate-500">Nomor</span>
                <span class="font-mono font-bold text-slate-800">0812-3456-7890</span>
            </div>
            <div class="flex justify-between"><span class="text-slate-500">Atas Nama</span><span class="font-medium">TokoKita</span></div>
            <div class="flex justify-between"><span class="text-slate-500">Jumlah</span><span class="font-bold text-indigo-600">Rp{{ number_format($order->total, 0, ',', '.') }}</span></div>
        </div>
        <p class="text-xs text-slate-400">Setelah transfer, klik tombol di bawah. Sistem akan memverifikasi secara otomatis.</p>
    </div>
    @endif

    {{-- Tombol bayar + animasi verifikasi --}}
    <div x-show="!processing && !verified">
        <form action="{{ route('orders.processPayment', $order) }}" method="POST"
              @submit="processing = true">
            @csrf
            <button type="submit"
                    class="w-full rounded-full bg-indigo-600 text-white font-semibold py-3.5 hover:bg-indigo-500 shadow-lg shadow-indigo-200 transition flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Bayar & Verifikasi Otomatis
            </button>
        </form>
        <p class="text-xs text-center text-slate-400 mt-3">
            Pembayaran akan diverifikasi otomatis oleh sistem. Tidak perlu menunggu konfirmasi admin.
        </p>
    </div>

    {{-- Loading verifikasi --}}
    <div x-show="processing" x-cloak class="rounded-2xl border border-indigo-200 bg-indigo-50 p-8 text-center">
        <div class="w-12 h-12 mx-auto mb-4 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
        <p class="font-semibold text-indigo-900">Memverifikasi pembayaran...</p>
        <p class="text-sm text-indigo-600 mt-1">Mohon tunggu sebentar</p>
    </div>
</div>
@endsection
