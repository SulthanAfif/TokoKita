@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<h1 class="text-2xl font-bold text-slate-800 mb-8">Pesanan Saya</h1>

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
@endphp

<div class="space-y-4">
    @forelse($orders as $order)
        <a href="{{ route('orders.show', $order) }}"
           class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-5 hover:shadow-md transition">
            <div>
                <p class="font-semibold text-slate-800">{{ $order->order_number }}</p>
                <p class="text-xs text-slate-400">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</p>
            </div>
            <div class="text-right">
                <p class="font-bold text-indigo-600">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                <span class="inline-block mt-1 text-xs px-2.5 py-1 rounded-full font-medium {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-600' }}">
                    {{ $statusLabels[$order->status] ?? $order->status }}
                </span>
            </div>
        </a>
    @empty
        <p class="text-slate-400 text-center py-20">Anda belum memiliki pesanan.</p>
    @endforelse
</div>

@if($orders->hasPages())
    <div class="mt-8">{{ $orders->links() }}</div>
@endif
@endsection
