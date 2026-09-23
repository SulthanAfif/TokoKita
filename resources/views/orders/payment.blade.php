@extends('layouts.app')

@section('title', 'Pembayaran - ' . $order->order_number)

@section('content')
<div class="max-w-lg mx-auto px-4 py-10">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="text-xl font-bold text-slate-800 mb-1">Pembayaran</h1>
        <p class="text-sm text-slate-500 mb-6">Order #{{ $order->order_number }}</p>

        <div class="bg-slate-50 rounded-xl p-4 mb-6 space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-slate-500">Subtotal</span>
                <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Ongkos Kirim</span>
                <span>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
            </div>
            <hr class="border-slate-200">
            <div class="flex justify-between font-bold text-indigo-600 text-base">
                <span>Total Bayar</span>
                <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <button id="pay-button"
                class="w-full rounded-full bg-indigo-600 text-white font-semibold py-3.5 hover:bg-indigo-500 shadow-lg shadow-indigo-200 transition">
            Bayar Sekarang dengan Midtrans
        </button>

        <p class="text-xs text-slate-400 text-center mt-4">
            Pembayaran diproses secara aman melalui Midtrans.<br>
            Status pesanan akan otomatis terupdate setelah pembayaran berhasil.
        </p>

        <a href="{{ route('orders.show', $order) }}"
           class="block text-center text-sm text-slate-500 mt-4 hover:text-indigo-600">
            ← Kembali ke detail pesanan
        </a>
    </div>
</div>
@endsection

@push('scripts')
{{-- Midtrans Snap JS --}}
<script src="{{ $snapJsUrl }}" data-client-key="{{ $clientKey }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                // Redirect ke detail order — status akan diupdate via notification
                window.location.href = '{{ route('orders.show', $order) }}?status=success';
            },
            onPending: function (result) {
                window.location.href = '{{ route('orders.show', $order) }}?status=pending';
            },
            onError: function (result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
                console.error(result);
            },
            onClose: function () {
                // User menutup popup tanpa menyelesaikan
                // Tidak perlu redirect
            }
        });
    });
</script>
@endpush
