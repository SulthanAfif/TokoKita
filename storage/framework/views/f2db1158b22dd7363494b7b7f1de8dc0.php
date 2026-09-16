<?php $__env->startSection('title', 'Detail Pesanan'); ?>

<?php $__env->startSection('content'); ?>
<?php
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
?>

<div class="max-w-2xl mx-auto">
    <a href="<?php echo e(route('orders.index')); ?>" class="text-sm text-slate-500 hover:text-indigo-600 transition">← Kembali ke pesanan</a>

    <div class="flex flex-wrap items-center gap-3 mt-3 mb-6">
        <h1 class="text-2xl font-bold text-slate-800"><?php echo e($order->order_number); ?></h1>
        <span class="inline-block text-xs px-3 py-1 rounded-full font-medium <?php echo e($statusColors[$order->status] ?? 'bg-slate-100'); ?>">
            <?php echo e($statusLabels[$order->status] ?? $order->status); ?>

        </span>
    </div>

    
    <?php if($order->status === 'pending' && in_array($order->payment_method, ['transfer_bank', 'e_wallet'])): ?>
    <div class="rounded-2xl border border-indigo-200 bg-indigo-50 p-6 mb-6">
        <h3 class="font-semibold text-indigo-900 mb-1">Menunggu Pembayaran</h3>
        <p class="text-sm text-indigo-700 mb-4">
            Total: <span class="font-bold text-lg">Rp<?php echo e(number_format($order->total, 0, ',', '.')); ?></span>
            via <?php echo e($paymentLabels[$order->payment_method] ?? ''); ?>

        </p>
        <a href="<?php echo e(route('orders.payment', $order)); ?>"
           class="inline-flex items-center justify-center w-full sm:w-auto rounded-full bg-indigo-600 text-white font-semibold px-8 py-3 hover:bg-indigo-500 shadow-lg shadow-indigo-200 transition">
            Bayar Sekarang →
        </a>
        <p class="text-xs text-indigo-600/70 mt-2">Verifikasi otomatis setelah pembayaran. Status langsung update di admin.</p>
    </div>
    <?php endif; ?>

    <?php if($order->status === 'paid'): ?>
    <div class="rounded-2xl border border-green-200 bg-green-50 p-5 mb-6 text-sm text-green-800">
        <p class="font-semibold">✓ Pembayaran terverifikasi otomatis</p>
        <p class="mt-0.5">Dibayar pada <?php echo e($order->paid_at?->format('d M Y, H:i')); ?>. Menunggu admin memproses pesanan.</p>
    </div>
    <?php endif; ?>

    <?php if($order->status === 'pending' && $order->payment_method === 'cod'): ?>
    <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 mb-6 text-sm text-amber-800">
        <p class="font-semibold mb-1">Bayar di Tempat (COD)</p>
        <p>Siapkan uang tunai <strong>Rp<?php echo e(number_format($order->total, 0, ',', '.')); ?></strong> saat barang tiba.</p>
    </div>
    <?php endif; ?>

    
    <div class="rounded-2xl border border-slate-200 bg-white p-6 mb-6">
        <h3 class="font-semibold text-slate-800 mb-3">Item Pesanan</h3>
        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex justify-between text-sm mb-2">
                <span class="text-slate-600"><?php echo e($item->product_name); ?> x<?php echo e($item->quantity); ?></span>
                <span>Rp<?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <hr class="my-3 border-slate-100">
        <div class="flex justify-between text-sm mb-1">
            <span class="text-slate-500">Subtotal</span>
            <span>Rp<?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></span>
        </div>
        <div class="flex justify-between text-sm mb-1">
            <span class="text-slate-500">Ongkos Kirim</span>
            <span>Rp<?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></span>
        </div>
        <div class="flex justify-between font-bold text-indigo-600">
            <span>Total</span>
            <span>Rp<?php echo e(number_format($order->total, 0, ',', '.')); ?></span>
        </div>
    </div>

    
    <div class="rounded-2xl border border-slate-200 bg-white p-6 mb-6">
        <h3 class="font-semibold text-slate-800 mb-2">Metode Pembayaran</h3>
        <p class="text-sm text-slate-600 mb-3">
            <?php echo e($paymentLabels[$order->payment_method] ?? ($order->payment_method ?? '-')); ?>

            <?php if($order->paid_at): ?>
                <span class="text-green-600 text-xs ml-1">· Dibayar <?php echo e($order->paid_at->format('d M Y H:i')); ?></span>
            <?php endif; ?>
        </p>

        <?php if($order->status === 'pending'): ?>
            <form action="<?php echo e(route('orders.updatePayment', $order)); ?>" method="POST" class="space-y-3">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <label class="block text-xs text-slate-500 mb-1">Ubah metode pembayaran</label>
                <div class="flex flex-wrap gap-2">
                    <?php $__currentLoopData = ['transfer_bank' => 'Transfer Bank', 'e_wallet' => 'E-Wallet', 'cod' => 'COD']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center gap-2 rounded-xl border border-slate-200 px-3 py-2 text-sm cursor-pointer has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                            <input type="radio" name="payment_method" value="<?php echo e($val); ?>"
                                   <?php if($order->payment_method === $val): echo 'checked'; endif; ?> required>
                            <?php echo e($label); ?>

                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <button type="submit"
                        class="mt-2 rounded-full border border-slate-300 text-slate-700 px-5 py-2 text-sm font-medium hover:bg-slate-50 transition">
                    Simpan Metode
                </button>
            </form>
        <?php endif; ?>
    </div>

    
    <?php if($order->address): ?>
    <div class="rounded-2xl border border-slate-200 bg-white p-6 mb-6">
        <h3 class="font-semibold text-slate-800 mb-2">Alamat Pengiriman</h3>
        <p class="text-sm text-slate-600">
            <?php echo e($order->address->recipient_name); ?> &middot; <?php echo e($order->address->phone); ?><br>
            <?php echo e($order->address->full_address); ?>, <?php echo e($order->address->city); ?>, <?php echo e($order->address->province); ?>

            <?php if($order->address->postal_code): ?> <?php echo e($order->address->postal_code); ?> <?php endif; ?>
        </p>
    </div>
    <?php endif; ?>

    
    <?php if($order->status === 'pending'): ?>
    <div class="rounded-2xl border border-red-200 bg-red-50 p-5">
        <h3 class="font-semibold text-red-700 mb-1">Batalkan Pesanan</h3>
        <p class="text-sm text-red-600 mb-3">Pesanan yang dibatalkan tidak dapat dikembalikan. Stok produk akan dikembalikan.</p>
        <form action="<?php echo e(route('orders.cancel', $order)); ?>" method="POST"
              onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
            <?php echo csrf_field(); ?>
            <button type="submit"
                    class="rounded-full bg-red-600 text-white px-5 py-2.5 text-sm font-semibold hover:bg-red-500 transition">
                Batalkan Pesanan
            </button>
        </form>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\proyekporto\TokoKita\resources\views/orders/show.blade.php ENDPATH**/ ?>