<?php $__env->startSection('title', 'Checkout'); ?>

<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold text-slate-800 mb-8">Checkout</h1>

<form action="<?php echo e(route('checkout.store')); ?>" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <?php echo csrf_field(); ?>

    <div class="lg:col-span-2 space-y-6">
        
        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Alamat Pengiriman</h3>

            <?php $__empty_1 = true; $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <label class="flex items-start gap-3 border border-slate-200 rounded-xl p-4 mb-3 cursor-pointer has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="address_id" value="<?php echo e($address->id); ?>" class="mt-1" required>
                    <div class="text-sm">
                        <p class="font-semibold"><?php echo e($address->recipient_name); ?> &middot; <?php echo e($address->phone); ?></p>
                        <p class="text-slate-500"><?php echo e($address->full_address); ?>, <?php echo e($address->city); ?>, <?php echo e($address->province); ?> <?php echo e($address->postal_code); ?></p>
                    </div>
                </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-slate-400">Anda belum punya alamat tersimpan. Tambahkan alamat di halaman profil terlebih dahulu.</p>
            <?php endif; ?>
        </div>

        
        <div class="rounded-2xl border border-slate-200 bg-white p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Metode Pembayaran</h3>
            <?php $__currentLoopData = ['transfer_bank' => 'Transfer Bank', 'e_wallet' => 'E-Wallet', 'cod' => 'Bayar di Tempat (COD)']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <label class="flex items-center gap-3 border border-slate-200 rounded-xl p-4 mb-3 cursor-pointer has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input type="radio" name="payment_method" value="<?php echo e($value); ?>" required>
                    <span class="text-sm font-medium"><?php echo e($label); ?></span>
                </label>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div class="rounded-2xl border border-slate-200 bg-white p-6 h-fit">
        <h3 class="font-semibold text-slate-800 mb-4">Ringkasan Pesanan</h3>
        <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex justify-between text-sm mb-2">
                <span class="text-slate-500"><?php echo e($item->product->name); ?> x<?php echo e($item->quantity); ?></span>
                <span>Rp<?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <hr class="my-3">
        <div class="flex justify-between text-sm mb-1">
            <span class="text-slate-500">Subtotal</span>
            <span>Rp<?php echo e(number_format($cart->total, 0, ',', '.')); ?></span>
        </div>
        <div class="flex justify-between text-sm mb-3">
            <span class="text-slate-500">Ongkos Kirim</span>
            <span>Rp15.000</span>
        </div>
        <div class="flex justify-between font-bold text-indigo-600 text-base">
            <span>Total</span>
            <span>Rp<?php echo e(number_format($cart->total + 15000, 0, ',', '.')); ?></span>
        </div>

        <button type="submit"
                class="mt-6 w-full rounded-full bg-indigo-600 text-white font-semibold py-3 hover:bg-indigo-500">
            Buat Pesanan
        </button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\proyekporto\project\TokoKita\resources\views/checkout/index.blade.php ENDPATH**/ ?>