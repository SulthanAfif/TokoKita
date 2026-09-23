<?php $__env->startSection('title', 'Semua Produk'); ?>

<?php $__env->startSection('content'); ?>


<div class="-mx-4 sm:-mx-6 lg:-mx-8 mb-6">
    <div class="border-b border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-1 overflow-x-auto py-0
                        [scrollbar-width:none] [-ms-overflow-style:none]
                        [&::-webkit-scrollbar]:hidden">

                <a href="<?php echo e(route('products.index', request()->only('search', 'sort'))); ?>"
                   class="relative shrink-0 px-4 py-3.5 text-sm font-medium whitespace-nowrap transition-all duration-200
                          <?php echo e(!request('category') ? 'text-indigo-600' : 'text-slate-600 hover:text-indigo-600'); ?>">
                    Semua
                    <?php if (! (request('category'))): ?>
                        <span class="absolute bottom-0 left-2 right-2 h-0.5 rounded-full bg-indigo-600"></span>
                    <?php endif; ?>
                </a>

                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('products.index', array_merge(request()->only('search', 'sort'), ['category' => $category->slug]))); ?>"
                       class="relative shrink-0 px-4 py-3.5 text-sm font-medium whitespace-nowrap transition-all duration-200
                              <?php echo e(request('category') == $category->slug ? 'text-indigo-600' : 'text-slate-600 hover:text-indigo-600'); ?>">
                        <?php echo e($category->name); ?>

                        <?php if(request('category') == $category->slug): ?>
                            <span class="absolute bottom-0 left-2 right-2 h-0.5 rounded-full bg-indigo-600"></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>


<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-lg font-bold text-slate-800">
            <?php if(request('category')): ?>
                <?php echo e($categories->firstWhere('slug', request('category'))?->name ?? 'Produk'); ?>

            <?php elseif(request('search')): ?>
                Hasil: “<?php echo e(request('search')); ?>”
            <?php else: ?>
                Semua Produk
            <?php endif; ?>
        </h1>
        <p class="text-sm text-slate-500"><?php echo e($products->total()); ?> produk ditemukan</p>
    </div>

    <form method="GET" class="flex items-center gap-2">
        <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
        <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
        <label class="text-xs text-slate-400 hidden sm:inline">Urutkan</label>
        <select name="sort" onchange="this.form.submit()"
                class="text-sm rounded-lg border-slate-200 bg-white focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">Terbaru</option>
            <option value="price_asc" <?php if(request('sort')=='price_asc'): echo 'selected'; endif; ?>>Harga Terendah</option>
            <option value="price_desc" <?php if(request('sort')=='price_desc'): echo 'selected'; endif; ?>>Harga Tertinggi</option>
        </select>
    </form>
</div>


<?php if($products->isEmpty()): ?>
    <div class="text-center py-20 text-slate-400">
        <p class="text-base">Produk tidak ditemukan.</p>
        <a href="<?php echo e(route('products.index')); ?>" class="inline-block mt-3 text-sm font-medium text-indigo-600 hover:underline">Lihat semua produk</a>
    </div>
<?php else: ?>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('products._card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="mt-8">
        <?php echo e($products->links()); ?>

    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\proyekporto\project\TokoKita\resources\views/products/index.blade.php ENDPATH**/ ?>