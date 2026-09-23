<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>

<nav class="text-sm text-slate-500 mb-6">
    <a href="<?php echo e(route('home')); ?>" class="hover:text-indigo-600">Beranda</a>
    <span class="mx-1.5">/</span>
    <a href="<?php echo e(route('products.index')); ?>" class="hover:text-indigo-600">Produk</a>
    <?php if($product->category): ?>
        <span class="mx-1.5">/</span>
        <a href="<?php echo e(route('products.index', ['category' => $product->category->slug])); ?>" class="hover:text-indigo-600"><?php echo e($product->category->name); ?></a>
    <?php endif; ?>
    <span class="mx-1.5">/</span>
    <span class="text-slate-800"><?php echo e($product->name); ?></span>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

    
    <div class="flex justify-center lg:justify-start">
        <div class="w-full max-w-[320px] sm:max-w-[360px] aspect-square rounded-2xl bg-slate-100 overflow-hidden border border-slate-200 shadow-sm">
            <?php if($product->thumbnail): ?>
                <img src="<?php echo e($product->thumbnail_url); ?>" alt="<?php echo e($product->name); ?>"
                     class="w-full h-full object-cover">
            <?php else: ?>
                <div class="w-full h-full flex items-center justify-center text-slate-300">
                    <svg class="w-14 h-14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                    </svg>
                </div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="flex flex-col">
        <?php if($product->category): ?>
            <p class="text-sm text-indigo-500 font-medium"><?php echo e($product->category->name); ?></p>
        <?php endif; ?>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 mt-1 leading-tight"><?php echo e($product->name); ?></h1>

        <div class="mt-4 flex items-center gap-3">
            <span class="text-2xl sm:text-3xl font-bold text-indigo-600">
                Rp<?php echo e(number_format($product->final_price, 0, ',', '.')); ?>

            </span>
            <?php if($product->has_discount): ?>
                <span class="text-lg text-slate-400 line-through">Rp<?php echo e(number_format($product->price, 0, ',', '.')); ?></span>
                <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-0.5 rounded-full">DISKON</span>
            <?php endif; ?>
        </div>

        <p class="mt-3 text-sm <?php echo e($product->stock > 0 ? 'text-green-600' : 'text-red-600'); ?> font-medium">
            <?php if($product->stock > 0): ?>
                ✓ Stok tersedia: <?php echo e($product->stock); ?>

            <?php else: ?>
                ✗ Stok habis
            <?php endif; ?>
        </p>

        <?php if($product->description): ?>
            <div class="mt-6 text-slate-600 leading-relaxed text-sm sm:text-base">
                <?php echo e($product->description); ?>

            </div>
        <?php endif; ?>

        <div class="mt-8">
            <?php if(auth()->guard()->check()): ?>
                <?php if($product->stock > 0): ?>
                    <form action="<?php echo e(route('cart.add', $product)); ?>" method="POST" class="flex flex-wrap items-center gap-3">
                        <?php echo csrf_field(); ?>
                        <div class="flex items-center rounded-full border border-slate-300 overflow-hidden">
                            <button type="button" onclick="this.nextElementSibling.stepDown()"
                                    class="px-3 py-2.5 text-slate-500 hover:bg-slate-50 text-lg leading-none">−</button>
                            <input type="number" name="quantity" value="1" min="1" max="<?php echo e($product->stock); ?>"
                                   class="w-14 border-0 text-center text-sm focus:ring-0 py-2.5">
                            <button type="button" onclick="this.previousElementSibling.stepUp()"
                                    class="px-3 py-2.5 text-slate-500 hover:bg-slate-50 text-lg leading-none">+</button>
                        </div>
                        <button type="submit"
                                class="flex-1 sm:flex-none rounded-full bg-indigo-600 text-white px-8 py-3 font-semibold hover:bg-indigo-500 shadow-lg shadow-indigo-200 transition">
                            Tambah ke Keranjang
                        </button>
                    </form>
                <?php else: ?>
                    <button disabled class="rounded-full bg-slate-200 text-slate-500 px-8 py-3 font-semibold cursor-not-allowed">
                        Stok Habis
                    </button>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>"
                   class="inline-block rounded-full bg-indigo-600 text-white px-8 py-3 font-semibold hover:bg-indigo-500 shadow-lg shadow-indigo-200 transition">
                    Masuk untuk Membeli
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php if($related->isNotEmpty()): ?>
<section class="mt-16">
    <h2 class="text-xl font-bold text-slate-800 mb-6">Produk Terkait</h2>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('products._card', ['product' => $item], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\proyekporto\project\TokoKita\resources\views/products/show.blade.php ENDPATH**/ ?>