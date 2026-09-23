<?php $__env->startSection('title', 'Statistik & Konten Beranda'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="homePreview()" class="space-y-6">
    <div>
        <h2 class="text-lg font-semibold text-slate-800">Edit Konten Beranda</h2>
        <p class="text-sm text-slate-500">Ubah teks di kiri — preview langsung di kanan (mirip tampilan toko).</p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 items-start">

        
        <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" class="space-y-5" id="settings-form">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            
            <div class="rounded-2xl border border-slate-200 bg-white p-5 space-y-3">
                <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-2 text-sm">Hero</h3>

                <?php $__currentLoopData = [
                    'hero_badge' => 'Badge',
                    'hero_title_1' => 'Judul baris 1',
                    'hero_title_2' => 'Judul baris 2',
                    'hero_subtitle' => 'Subjudul',
                    'hero_stat_1_value' => 'Stat 1 nilai',
                    'hero_stat_1_label' => 'Stat 1 label',
                    'hero_stat_2_value' => 'Stat 2 nilai',
                    'hero_stat_2_label' => 'Stat 2 label',
                    'hero_stat_3_value' => 'Stat 3 nilai',
                    'hero_stat_3_label' => 'Stat 3 label',
                    'hero_card_title' => 'Kartu kanan judul',
                    'hero_card_subtitle' => 'Kartu kanan subjudul',
                    'hero_badge_promo' => 'Badge PROMO',
                    'hero_badge_flash' => 'Badge Flash Sale',
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1"><?php echo e($label); ?></label>
                        <?php if(in_array($key, ['hero_subtitle', 'hero_card_title'])): ?>
                            <textarea name="<?php echo e($key); ?>" rows="2" x-model="<?php echo e($key); ?>"
                                      class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 text-sm"><?php echo e(old($key, $settings[$key]->value ?? $fields[$key][0])); ?></textarea>
                        <?php else: ?>
                            <input type="text" name="<?php echo e($key); ?>" x-model="<?php echo e($key); ?>"
                                   value="<?php echo e(old($key, $settings[$key]->value ?? $fields[$key][0])); ?>"
                                   class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <?php endif; ?>
                        <?php $__errorArgs = [$key];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="rounded-2xl border border-slate-200 bg-white p-5 space-y-3">
                <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-2 text-sm">Trust Bar</h3>
                <div class="grid sm:grid-cols-2 gap-3">
                    <?php $__currentLoopData = [1,2,3,4]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="rounded-xl border border-slate-100 p-3 space-y-2">
                            <p class="text-[10px] font-semibold text-slate-400 uppercase">Kartu <?php echo e($i); ?></p>
                            <input type="text" name="trust_<?php echo e($i); ?>_title" x-model="trust_<?php echo e($i); ?>_title"
                                   value="<?php echo e(old('trust_'.$i.'_title', $settings['trust_'.$i.'_title']->value ?? $fields['trust_'.$i.'_title'][0])); ?>"
                                   placeholder="Judul"
                                   class="w-full rounded-lg border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <input type="text" name="trust_<?php echo e($i); ?>_desc" x-model="trust_<?php echo e($i); ?>_desc"
                                   value="<?php echo e(old('trust_'.$i.'_desc', $settings['trust_'.$i.'_desc']->value ?? $fields['trust_'.$i.'_desc'][0])); ?>"
                                   placeholder="Deskripsi"
                                   class="w-full rounded-lg border-slate-200 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="rounded-2xl border border-slate-200 bg-white p-5 space-y-3">
                <h3 class="font-semibold text-slate-800 border-b border-slate-100 pb-2 text-sm">Banner Promo</h3>
                <?php $__currentLoopData = [
                    'promo_eyebrow' => 'Label kecil',
                    'promo_title' => 'Judul',
                    'promo_subtitle' => 'Subjudul',
                    'promo_button' => 'Teks tombol',
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1"><?php echo e($label); ?></label>
                        <input type="text" name="<?php echo e($key); ?>" x-model="<?php echo e($key); ?>"
                               value="<?php echo e(old($key, $settings[$key]->value ?? $fields[$key][0])); ?>"
                               class="w-full rounded-xl border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <button type="submit"
                    class="w-full sm:w-auto rounded-xl bg-indigo-600 text-white px-6 py-2.5 text-sm font-semibold hover:bg-indigo-500 shadow-lg shadow-indigo-200 transition">
                Simpan Semua Perubahan
            </button>
        </form>

        
        <div class="xl:sticky xl:top-20 space-y-4">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Preview langsung</p>

            
            <div class="rounded-2xl overflow-hidden bg-gradient-to-br from-violet-600 via-indigo-600 to-blue-600 text-white p-6 shadow-xl">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 text-[11px] font-semibold border border-white/20 mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span x-text="hero_badge"></span>
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold leading-tight">
                    <span x-text="hero_title_1"></span><br>
                    <span class="bg-gradient-to-r from-yellow-200 via-pink-200 to-white bg-clip-text text-transparent" x-text="hero_title_2"></span>
                </h1>
                <p class="mt-3 text-sm text-indigo-100 leading-relaxed" x-text="hero_subtitle"></p>

                <div class="mt-5 flex flex-wrap gap-5">
                    <div>
                        <p class="text-xl font-extrabold" x-text="hero_stat_1_value"></p>
                        <p class="text-[10px] text-indigo-200" x-text="hero_stat_1_label"></p>
                    </div>
                    <div>
                        <p class="text-xl font-extrabold" x-text="hero_stat_2_value"></p>
                        <p class="text-[10px] text-indigo-200" x-text="hero_stat_2_label"></p>
                    </div>
                    <div>
                        <p class="text-xl font-extrabold" x-text="hero_stat_3_value"></p>
                        <p class="text-[10px] text-indigo-200" x-text="hero_stat_3_label"></p>
                    </div>
                </div>

                <div class="mt-5 flex flex-wrap gap-2">
                    <span class="bg-gradient-to-r from-pink-500 to-rose-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full" x-text="hero_badge_promo"></span>
                    <span class="bg-white text-indigo-700 text-[10px] font-bold px-2.5 py-1 rounded-full" x-text="hero_badge_flash"></span>
                </div>
                <p class="mt-3 text-xs text-indigo-200/80">
                    Kartu: <span class="font-semibold text-white" x-text="hero_card_title.replace(/\\n/g, ' ')"></span>
                    · <span x-text="hero_card_subtitle"></span>
                </p>
            </div>

            
            <div class="grid grid-cols-2 gap-2">
                <template x-for="(t, i) in [
                    {title: trust_1_title, desc: trust_1_desc},
                    {title: trust_2_title, desc: trust_2_desc},
                    {title: trust_3_title, desc: trust_3_desc},
                    {title: trust_4_title, desc: trust_4_desc},
                ]" :key="i">
                    <div class="rounded-xl bg-white border border-slate-100 p-3 shadow-sm">
                        <p class="text-xs font-bold text-slate-800" x-text="t.title"></p>
                        <p class="text-[10px] text-slate-400" x-text="t.desc"></p>
                    </div>
                </template>
            </div>

            
            <div class="rounded-2xl bg-gradient-to-r from-rose-500 via-pink-500 to-orange-400 text-white p-5 shadow-lg">
                <p class="text-[10px] font-bold uppercase tracking-widest text-white/80 mb-1" x-text="promo_eyebrow"></p>
                <h3 class="text-lg font-extrabold" x-text="promo_title"></h3>
                <p class="text-xs text-white/80 mt-1" x-text="promo_subtitle"></p>
                <span class="inline-block mt-3 rounded-full bg-white text-pink-600 text-xs font-bold px-4 py-1.5" x-text="promo_button"></span>
            </div>
        </div>
    </div>
</div>

<script>
function homePreview() {
    return {
        hero_badge: <?php echo json_encode(old('hero_badge', $settings['hero_badge']->value ?? $fields['hero_badge'][0]), 512) ?>,
        hero_title_1: <?php echo json_encode(old('hero_title_1', $settings['hero_title_1']->value ?? $fields['hero_title_1'][0]), 512) ?>,
        hero_title_2: <?php echo json_encode(old('hero_title_2', $settings['hero_title_2']->value ?? $fields['hero_title_2'][0]), 512) ?>,
        hero_subtitle: <?php echo json_encode(old('hero_subtitle', $settings['hero_subtitle']->value ?? $fields['hero_subtitle'][0]), 512) ?>,
        hero_stat_1_value: <?php echo json_encode(old('hero_stat_1_value', $settings['hero_stat_1_value']->value ?? $fields['hero_stat_1_value'][0]), 512) ?>,
        hero_stat_1_label: <?php echo json_encode(old('hero_stat_1_label', $settings['hero_stat_1_label']->value ?? $fields['hero_stat_1_label'][0]), 512) ?>,
        hero_stat_2_value: <?php echo json_encode(old('hero_stat_2_value', $settings['hero_stat_2_value']->value ?? $fields['hero_stat_2_value'][0]), 512) ?>,
        hero_stat_2_label: <?php echo json_encode(old('hero_stat_2_label', $settings['hero_stat_2_label']->value ?? $fields['hero_stat_2_label'][0]), 512) ?>,
        hero_stat_3_value: <?php echo json_encode(old('hero_stat_3_value', $settings['hero_stat_3_value']->value ?? $fields['hero_stat_3_value'][0]), 512) ?>,
        hero_stat_3_label: <?php echo json_encode(old('hero_stat_3_label', $settings['hero_stat_3_label']->value ?? $fields['hero_stat_3_label'][0]), 512) ?>,
        hero_card_title: <?php echo json_encode(old('hero_card_title', $settings['hero_card_title']->value ?? $fields['hero_card_title'][0]), 512) ?>,
        hero_card_subtitle: <?php echo json_encode(old('hero_card_subtitle', $settings['hero_card_subtitle']->value ?? $fields['hero_card_subtitle'][0]), 512) ?>,
        hero_badge_promo: <?php echo json_encode(old('hero_badge_promo', $settings['hero_badge_promo']->value ?? $fields['hero_badge_promo'][0]), 512) ?>,
        hero_badge_flash: <?php echo json_encode(old('hero_badge_flash', $settings['hero_badge_flash']->value ?? $fields['hero_badge_flash'][0]), 512) ?>,
        trust_1_title: <?php echo json_encode(old('trust_1_title', $settings['trust_1_title']->value ?? $fields['trust_1_title'][0]), 512) ?>,
        trust_1_desc: <?php echo json_encode(old('trust_1_desc', $settings['trust_1_desc']->value ?? $fields['trust_1_desc'][0]), 512) ?>,
        trust_2_title: <?php echo json_encode(old('trust_2_title', $settings['trust_2_title']->value ?? $fields['trust_2_title'][0]), 512) ?>,
        trust_2_desc: <?php echo json_encode(old('trust_2_desc', $settings['trust_2_desc']->value ?? $fields['trust_2_desc'][0]), 512) ?>,
        trust_3_title: <?php echo json_encode(old('trust_3_title', $settings['trust_3_title']->value ?? $fields['trust_3_title'][0]), 512) ?>,
        trust_3_desc: <?php echo json_encode(old('trust_3_desc', $settings['trust_3_desc']->value ?? $fields['trust_3_desc'][0]), 512) ?>,
        trust_4_title: <?php echo json_encode(old('trust_4_title', $settings['trust_4_title']->value ?? $fields['trust_4_title'][0]), 512) ?>,
        trust_4_desc: <?php echo json_encode(old('trust_4_desc', $settings['trust_4_desc']->value ?? $fields['trust_4_desc'][0]), 512) ?>,
        promo_eyebrow: <?php echo json_encode(old('promo_eyebrow', $settings['promo_eyebrow']->value ?? $fields['promo_eyebrow'][0]), 512) ?>,
        promo_title: <?php echo json_encode(old('promo_title', $settings['promo_title']->value ?? $fields['promo_title'][0]), 512) ?>,
        promo_subtitle: <?php echo json_encode(old('promo_subtitle', $settings['promo_subtitle']->value ?? $fields['promo_subtitle'][0]), 512) ?>,
        promo_button: <?php echo json_encode(old('promo_button', $settings['promo_button']->value ?? $fields['promo_button'][0]), 512) ?>,
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\proyek porto\TokoKita\resources\views/admin/settings/edit.blade.php ENDPATH**/ ?>