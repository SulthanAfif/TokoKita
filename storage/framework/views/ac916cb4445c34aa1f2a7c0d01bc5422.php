<?php $__env->startSection('title', 'Pesanan Saya'); ?>

<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold text-slate-800 mb-8">Pesanan Saya</h1>

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
?>

<div class="space-y-4">
    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('orders.show', $order)); ?>"
           class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-5 hover:shadow-md transition">
            <div>
                <p class="font-semibold text-slate-800"><?php echo e($order->order_number); ?></p>
                <p class="text-xs text-slate-400"><?php echo e($order->created_at->translatedFormat('d M Y, H:i')); ?></p>
            </div>
            <div class="text-right">
                <p class="font-bold text-indigo-600">Rp<?php echo e(number_format($order->total, 0, ',', '.')); ?></p>
                <span class="inline-block mt-1 text-xs px-2.5 py-1 rounded-full font-medium <?php echo e($statusColors[$order->status] ?? 'bg-slate-100 text-slate-600'); ?>">
                    <?php echo e($statusLabels[$order->status] ?? $order->status); ?>

                </span>
            </div>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-slate-400 text-center py-20">Anda belum memiliki pesanan.</p>
    <?php endif; ?>
</div>

<?php if($orders->hasPages()): ?>
    <div class="mt-8"><?php echo e($orders->links()); ?></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\proyekporto\project\TokoKita\resources\views/orders/index.blade.php ENDPATH**/ ?>