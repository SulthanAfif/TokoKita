
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'count' => null,
    'size' => 'md',
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'count' => null,
    'size' => 'md',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $count = $count ?? ($cartCount ?? 0);
    $iconClass = match($size) {
        'sm' => 'w-5 h-5',
        'lg' => 'w-7 h-7',
        default => 'w-6 h-6',
    };
    $padClass = match($size) {
        'sm' => 'p-2',
        'lg' => 'p-3',
        default => 'p-2.5',
    };
?>

<a href="<?php echo e(auth()->check() ? route('cart.index') : route('login')); ?>"
   <?php echo e($attributes->merge([
       'class' => "relative inline-flex items-center justify-center {$padClass} text-slate-600 rounded-lg
                   transition-all duration-200
                   hover:text-indigo-600 hover:bg-indigo-50 hover:scale-110 active:scale-95",
       'title' => 'Keranjang' . ($count > 0 ? " ({$count} item)" : ''),
       'aria-label' => 'Keranjang belanja' . ($count > 0 ? ", {$count} item" : ''),
   ])); ?>>
    <svg xmlns="http://www.w3.org/2000/svg" class="<?php echo e($iconClass); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.892-4.7 2.354-7.135A1.125 1.125 0 0018.75 5.25H5.106M7.5 14.25L5.106 5.25M7.5 14.25L4.5 18.75m0 0h15" />
    </svg>

    <?php if($count > 0): ?>
        <span class="absolute -top-0.5 -right-0.5 z-10 flex h-5 min-w-[1.25rem] items-center justify-center
                     rounded-full bg-red-500 px-1 text-[10px] font-bold leading-none text-white
                     ring-2 ring-white shadow-md
                     animate-[cart-pop_0.45s_ease-out]">
            <?php echo e($count > 99 ? '99+' : $count); ?>

        </span>
    <?php endif; ?>
</a>

<?php if (! $__env->hasRenderedOnce('6bfb4e98-782a-4514-85be-8bd6120b42f4')): $__env->markAsRenderedOnce('6bfb4e98-782a-4514-85be-8bd6120b42f4'); ?>
<style>
@keyframes cart-pop {
    0% { transform: scale(0); opacity: 0; }
    55% { transform: scale(1.25); opacity: 1; }
    100% { transform: scale(1); opacity: 1; }
}
</style>
<?php endif; ?>
<?php /**PATH C:\proyek porto\TokoKita\resources\views/components/cart-icon.blade.php ENDPATH**/ ?>