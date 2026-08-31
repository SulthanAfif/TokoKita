
<?php if(auth()->guard()->check()): ?>
<?php
    $name = auth()->user()->name;
    $initial = strtoupper(mb_substr($name, 0, 1));
    # Warna avatar dari hash nama
    $colors = ['bg-indigo-500', 'bg-violet-500', 'bg-blue-500', 'bg-emerald-500', 'bg-rose-500', 'bg-amber-500'];
    $color = $colors[crc32($name) % count($colors)];
?>

<a href="<?php echo e(route('profile.edit')); ?>"
   class="relative inline-flex items-center gap-2 rounded-full transition-all duration-200 hover:scale-105 active:scale-95 group"
   title="<?php echo e($name); ?> — Profil">
    <span class="flex h-9 w-9 items-center justify-center rounded-full <?php echo e($color); ?> text-white text-sm font-bold
                 ring-2 ring-white shadow-md group-hover:ring-indigo-200 transition">
        <?php echo e($initial); ?>

    </span>
    <span class="hidden lg:inline text-sm font-medium text-slate-700 group-hover:text-indigo-600 max-w-[100px] truncate">
        <?php echo e(explode(' ', $name)[0]); ?>

    </span>
</a>
<?php endif; ?>
<?php /**PATH C:\proyek porto\TokoKita\resources\views/components/profile-avatar.blade.php ENDPATH**/ ?>