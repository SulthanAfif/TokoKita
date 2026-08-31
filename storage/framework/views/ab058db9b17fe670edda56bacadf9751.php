<?php if(auth()->guard()->check()): ?>
<a href="<?php echo e(route('orders.index')); ?>"
   class="relative inline-flex items-center justify-center p-2.5 text-slate-600 rounded-lg
          transition-all duration-200 hover:text-indigo-600 hover:bg-indigo-50 hover:scale-110 active:scale-95
          <?php echo e(request()->routeIs('orders.*') ? 'text-indigo-600 bg-indigo-50' : ''); ?>"
   title="Pesanan Saya" aria-label="Pesanan">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.824.696 2.057 1.668" />
    </svg>
</a>
<?php endif; ?>
<?php /**PATH C:\proyek porto\TokoKita\resources\views/components/orders-icon.blade.php ENDPATH**/ ?>