<?php $__env->startSection('title', 'Slide Latar Hero'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-800">Slide Latar Belakang Hero</h2>
        <p class="text-sm text-slate-500">Kelola gambar latar belakang hero beranda. Slide akan berganti otomatis. Disarankan ukuran 1600×700 px atau lebih lebar.</p>
    </div>

    <?php if(session('success')): ?>
        <div class="rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <h3 class="font-semibold text-slate-800 mb-4 text-sm">Tambah Slide Baru</h3>
        <form action="<?php echo e(route('admin.hero-slides.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Upload Gambar</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 file:font-medium hover:file:bg-indigo-100">
                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">atau URL Gambar</label>
                    <input type="url" name="image_url" value="<?php echo e(old('image_url')); ?>"
                           placeholder="https://..."
                           class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <?php $__errorArgs = ['image_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Judul (opsional)</label>
                    <input type="text" name="title" value="<?php echo e(old('title')); ?>"
                           class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                           placeholder="Misal: Promo Lebaran">
                </div>
                <div class="flex items-end">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked
                               class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-slate-700">Aktif</span>
                    </label>
                </div>
            </div>
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 text-white px-5 py-2.5 text-sm font-semibold hover:bg-indigo-500 shadow-sm transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Slide
            </button>
        </form>
    </div>

    
    <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800 text-sm">Daftar Slide (<?php echo e($slides->count()); ?>)</h3>
            <p class="text-xs text-slate-400">Urutan = urutan tampil (kecil dulu)</p>
        </div>

        <?php if($slides->isEmpty()): ?>
            <div class="p-10 text-center text-slate-400 text-sm">
                Belum ada slide. Latar belakang default (gradient) akan dipakai sampai Anda menambahkan gambar.
            </div>
        <?php else: ?>
            <ul class="divide-y divide-slate-100">
                <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="p-4 sm:p-5 hover:bg-slate-50/50">
                        <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                            <div class="w-full sm:w-40 h-24 rounded-xl overflow-hidden bg-slate-100 shrink-0 border border-slate-200">
                                <img src="<?php echo e($slide->image_url); ?>" alt="" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0 space-y-2">
                                <form action="<?php echo e(route('admin.hero-slides.update', $slide)); ?>" method="POST" enctype="multipart/form-data" class="space-y-3">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span class="text-xs font-medium text-slate-500">#<?php echo e($slide->id); ?></span>
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium <?php echo e($slide->is_active ? 'bg-green-50 text-green-700' : 'bg-slate-100 text-slate-500'); ?>">
                                            <?php echo e($slide->is_active ? 'Aktif' : 'Nonaktif'); ?>

                                        </span>
                                        <label class="text-xs text-slate-500">Urutan:
                                            <input type="number" name="sort_order" value="<?php echo e($slide->sort_order); ?>" min="0"
                                                   class="ml-1 w-16 rounded-lg border-slate-200 text-sm py-1">
                                        </label>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <div>
                                            <label class="block text-[11px] text-slate-500 mb-0.5">Ganti gambar (file)</label>
                                            <input type="file" name="image" accept="image/*" class="text-xs w-full">
                                        </div>
                                        <div>
                                            <label class="block text-[11px] text-slate-500 mb-0.5">atau URL baru</label>
                                            <input type="url" name="image_url" placeholder="https://..."
                                                   class="w-full rounded-lg border-slate-200 text-sm py-1.5">
                                        </div>
                                        <div>
                                            <label class="block text-[11px] text-slate-500 mb-0.5">Judul</label>
                                            <input type="text" name="title" value="<?php echo e($slide->title); ?>"
                                                   class="w-full rounded-lg border-slate-200 text-sm py-1.5">
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                            <input type="checkbox" name="is_active" value="1" <?php echo e($slide->is_active ? 'checked' : ''); ?>

                                                   class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                            <span class="text-xs text-slate-700">Aktif</span>
                                        </label>
                                        <button type="submit"
                                                class="rounded-lg bg-indigo-600 text-white px-3 py-1.5 text-xs font-semibold hover:bg-indigo-500">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <form action="<?php echo e(route('admin.hero-slides.destroy', $slide)); ?>" method="POST"
                                  onsubmit="return confirm('Hapus slide ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                        class="rounded-lg border border-red-200 text-red-600 px-3 py-1.5 text-xs font-semibold hover:bg-red-50">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\proyek porto\TokoKita\resources\views/admin/hero-slides/index.blade.php ENDPATH**/ ?>