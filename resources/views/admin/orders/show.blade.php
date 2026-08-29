@extends('layouts.admin')

@section('title', 'Pesanan ' . $order->order_number)

@section('content')
<div class="max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-slate-500 hover:text-indigo-600 transition">← Kembali</a>
        <div class="flex flex-wrap items-center gap-3 mt-2">
            <h2 class="text-lg font-semibold text-slate-800">{{ $order->order_number }}</h2>
            @php
                $statusColors = [
                    'pending' => 'bg-amber-50 text-amber-700',
                    'paid' => 'bg-blue-50 text-blue-700',
                    'processing' => 'bg-indigo-50 text-indigo-700',
                    'shipped' => 'bg-violet-50 text-violet-700',
                    'completed' => 'bg-green-50 text-green-700',
                    'cancelled' => 'bg-red-50 text-red-700',
                ];
            @endphp
            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $statusColors[$order->status] ?? 'bg-slate-100' }}">
                {{ $order->status }}
            </span>
        </div>
        <p class="text-sm text-slate-500 mt-1">
            {{ $order->user->name ?? '-' }} · {{ $order->created_at->format('d M Y, H:i') }}
        </p>
    </div>

    @if($order->status === 'paid' && $order->paid_at)
    <div class="rounded-2xl border border-green-200 bg-green-50 p-4 mb-5 text-sm text-green-800">
        <p class="font-semibold">✓ Pembayaran terverifikasi otomatis</p>
        <p>Customer membayar pada {{ $order->paid_at->format('d M Y, H:i') }}. Silakan proses pesanan.</p>
    </div>
    @endif

    {{-- Ubah Status --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 mb-5">
        <h3 class="font-semibold text-slate-800 mb-3">Ubah Status Pesanan</h3>
        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex flex-wrap items-end gap-3">
            @csrf
            @method('PATCH')
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs text-slate-500 mb-1">Status baru</label>
                <select name="status" required
                        class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach(['pending','paid','processing','shipped','completed','cancelled'] as $s)
                        <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                    class="rounded-xl bg-indigo-600 text-white px-5 py-2.5 text-sm font-semibold hover:bg-indigo-500 transition">
                Update Status
            </button>
        </form>
        <p class="text-xs text-slate-400 mt-2">Status akan langsung terlihat di akun customer.</p>
    </div>

    {{-- Item --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 mb-5">
        <h3 class="font-semibold text-slate-800 mb-3">Item Pesanan</h3>
        @foreach($order->items as $item)
            <div class="flex justify-between text-sm mb-2">
                <span class="text-slate-600">{{ $item->product_name }} × {{ $item->quantity }}</span>
                <span class="font-medium">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
        @endforeach
        <hr class="my-3 border-slate-100">
        <div class="flex justify-between text-sm mb-1">
            <span class="text-slate-500">Subtotal</span>
            <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between text-sm mb-1">
            <span class="text-slate-500">Ongkir</span>
            <span>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between font-bold text-indigo-600">
            <span>Total</span>
            <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
        </div>
        @php
            $payLabels = ['transfer_bank' => 'Transfer Bank', 'e_wallet' => 'E-Wallet', 'cod' => 'COD'];
        @endphp
        <p class="text-xs text-slate-400 mt-2">
            Pembayaran: {{ $payLabels[$order->payment_method] ?? ($order->payment_method ?? '-') }}
            @if($order->paid_at)
                · Dibayar: {{ $order->paid_at->format('d M Y H:i') }}
            @endif
        </p>
    </div>

    @if($order->address)
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <h3 class="font-semibold text-slate-800 mb-2">Alamat Pengiriman</h3>
        <p class="text-sm text-slate-600">
            {{ $order->address->recipient_name }} · {{ $order->address->phone }}<br>
            {{ $order->address->full_address }}, {{ $order->address->city }}, {{ $order->address->province }} {{ $order->address->postal_code }}
        </p>
    </div>
    @endif
</div>
@endsection
