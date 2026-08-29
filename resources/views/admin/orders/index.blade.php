@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-800">Daftar Pesanan</h2>
        <p class="text-sm text-slate-500">
            {{ $orders->total() }} transaksi ·
            <span class="font-semibold text-slate-700">{{ number_format($totalUnits, 0, ',', '.') }} unit</span> produk dipesan
        </p>
    </div>
</div>

{{-- Filter --}}
<form method="GET" class="flex flex-wrap items-center gap-3 mb-5">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. pesanan / pelanggan / produk..."
           class="rounded-xl border-slate-200 bg-white px-4 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 min-w-[220px]">
    <select name="status" onchange="this.form.submit()"
            class="rounded-xl border-slate-200 bg-white px-4 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
        <option value="">Semua Status</option>
        @foreach(['pending','paid','processing','shipped','completed','cancelled'] as $s)
            <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <button type="submit" class="rounded-xl bg-slate-800 text-white px-4 py-2 text-sm font-medium hover:bg-slate-700">Filter</button>
</form>

<div class="rounded-2xl border border-slate-200 bg-white overflow-hidden">
    <div class="overflow-x-auto table-scroll">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-center">
                <tr>
                    <th class="px-4 py-3 font-medium">No. Pesanan</th>
                    <th class="px-4 py-3 font-medium">Pelanggan</th>
                    <th class="px-4 py-3 font-medium">Produk Dipesan</th>
                    <th class="px-4 py-3 font-medium">Jumlah</th>
                    <th class="px-4 py-3 font-medium">Total</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium">Tanggal</th>
                    <th class="px-4 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                    @php
                        $statusColors = [
                            'pending' => 'bg-amber-50 text-amber-700',
                            'paid' => 'bg-blue-50 text-blue-700',
                            'processing' => 'bg-indigo-50 text-indigo-700',
                            'shipped' => 'bg-violet-50 text-violet-700',
                            'completed' => 'bg-green-50 text-green-700',
                            'cancelled' => 'bg-red-50 text-red-700',
                        ];
                        $qty = $order->items->sum('quantity');
                    @endphp
                    <tr class="hover:bg-slate-50/50 text-center">
                        <td class="px-4 py-3.5 font-medium text-slate-800 whitespace-nowrap">{{ $order->order_number }}</td>
                        <td class="px-4 py-3.5 whitespace-nowrap font-medium">{{ $order->user->name ?? '-' }}</td>
                        <td class="px-4 py-3.5">
                            <ul class="space-y-1">
                                @foreach($order->items as $item)
                                    <li class="text-xs">
                                        <span class="text-slate-800 font-medium">{{ $item->product_name }}</span>
                                        <span class="text-slate-400">×{{ $item->quantity }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-4 py-3.5 font-bold text-indigo-600">{{ $qty }}</td>
                        <td class="px-4 py-3.5 font-semibold whitespace-nowrap">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-4 py-3.5">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium capitalize {{ $statusColors[$order->status] ?? 'bg-slate-100 text-slate-600' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-slate-500 whitespace-nowrap">{{ $order->created_at->format('l, d M Y, H:i') }}</td>
                        <td class="px-4 py-3.5">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="px-3 py-1.5 rounded-lg text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-12 text-center text-slate-400">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($orders->hasPages())
    <div class="mt-6">{{ $orders->links() }}</div>
@endif
@endsection
