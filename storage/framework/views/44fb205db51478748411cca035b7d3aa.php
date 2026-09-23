<?php $__env->startSection('title', $page->title ?? 'Tentang Kami'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-slate-800"><?php echo e($page->title ?? 'Tentang TokoKita'); ?></h1>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-8 sm:p-10 space-y-4 text-slate-600 leading-relaxed">
        <?php if($page && $page->content): ?>
            <?php $__currentLoopData = preg_split('/\n\s*\n/', $page->content); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paragraph): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(trim($paragraph)): ?>
                    <p><?php echo e(trim($paragraph)); ?></p>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <p class="text-slate-400 text-center">Konten belum tersedia.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\proyekporto\project\TokoKita\resources\views/pages/about.blade.php ENDPATH**/ ?>