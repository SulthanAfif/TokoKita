
<?php if(auth()->guard()->check()): ?>
<?php
    $orders = auth()->user()->orders()->latest()->take(8)->get();
    $notifCount = auth()->user()->orders()
        ->whereIn('status', ['pending', 'paid', 'processing', 'shipped'])
        ->count();
?>

<div class="relative" x-data="{ open: false }" @click.outside="open = false">
    <button type="button" @click="open = !open"
            class="relative inline-flex items-center justify-center p-2.5 text-slate-600 rounded-lg
                   transition-all duration-200 hover:text-indigo-600 hover:bg-indigo-50 hover:scale-110 active:scale-95"
            title="Notifikasi" aria-label="Notifikasi">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        <?php if($notifCount > 0): ?>
            <span class="absolute -top-0.5 -right-0.5 z-10 flex h-5 min-w-[1.25rem] items-center justify-center
                         rounded-full bg-red-500 px-1 text-[10px] font-bold leading-none text-white ring-2 ring-white shadow-md">
                <?php echo e($notifCount > 9 ? '9+' : $notifCount); ?>

            </span>
        <?php endif; ?>
    </button>

    
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 translate-y-1 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-1 scale-95"
         class="absolute right-0 mt-2 w-80 sm:w-96 rounded-2xl border border-slate-200 bg-white shadow-xl z-50 overflow-hidden">

        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800">Notifikasi</h3>
            <a href="<?php echo e(route('orders.index')); ?>" class="text-xs font-medium text-indigo-600 hover:text-indigo-500">Lihat Semua</a>
        </div>

        
        <?php
            $statusIcons = [
                'pending' => ['label' => 'Menunggu Pembayaran', 'color' => 'text-amber-600 bg-amber-50'],
                'paid' => ['label' => 'Sudah Dibayar', 'color' => 'text-blue-600 bg-blue-50'],
                'processing' => ['label' => 'Diproses', 'color' => 'text-indigo-600 bg-indigo-50'],
                'shipped' => ['label' => 'Dikirim', 'color' => 'text-violet-600 bg-violet-50'],
                'completed' => ['label' => 'Selesai', 'color' => 'text-green-600 bg-green-50'],
                'cancelled' => ['label' => 'Dibatalkan', 'color' => 'text-red-600 bg-red-50'],
            ];
            $counts = [
                'pending' => auth()->user()->orders()->where('status', 'pending')->count(),
                'paid' => auth()->user()->orders()->where('status', 'paid')->count(),
                'processing' => auth()->user()->orders()->where('status', 'processing')->count(),
                'shipped' => auth()->user()->orders()->where('status', 'shipped')->count(),
            ];
        ?>

        <div class="grid grid-cols-4 gap-1 px-3 py-3 border-b border-slate-100 bg-slate-50/50">
            <?php $__currentLoopData = [
                'pending' => ['Menunggu', 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
                'paid' => ['Dibayar', 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                'processing' => ['Diproses', 'M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182'],
                'shipped' => ['Dikirim', 'M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st => $meta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('orders.index', ['status' => $st])); ?>"
                   class="flex flex-col items-center gap-1 p-2 rounded-xl hover:bg-white transition text-center">
                    <span class="relative w-10 h-10 rounded-full <?php echo e($statusIcons[$st]['color']); ?> flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo e($meta[1]); ?>" />
                        </svg>
                        <?php if(($counts[$st] ?? 0) > 0): ?>
                            <span class="absolute -top-0.5 -right-0.5 h-4 min-w-[1rem] px-0.5 rounded-full bg-red-500 text-[9px] font-bold text-white flex items-center justify-center">
                                <?php echo e($counts[$st]); ?>

                            </span>
                        <?php endif; ?>
                    </span>
                    <span class="text-[10px] text-slate-600 leading-tight"><?php echo e($meta[0]); ?></span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="max-h-64 overflow-y-auto divide-y divide-slate-50">
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php $si = $statusIcons[$order->status] ?? ['label' => $order->status, 'color' => 'bg-slate-100 text-slate-600']; ?>
                <a href="<?php echo e(route('orders.show', $order)); ?>"
                   class="flex items-start gap-3 px-4 py-3 hover:bg-slate-50 transition">
                    <span class="mt-0.5 shrink-0 w-8 h-8 rounded-full <?php echo e($si['color']); ?> flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.824.696 2.057 1.668" />
                        </svg>
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-slate-800 truncate"><?php echo e($order->order_number); ?></p>
                        <p class="text-xs text-slate-500"><?php echo e($si['label']); ?> · <?php echo e($order->created_at->diffForHumans()); ?></p>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-4 py-8 text-center text-sm text-slate-400">Belum ada notifikasi pesanan.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php /**PATH C:\proyek porto\TokoKita\resources\views/components/notif-icon.blade.php ENDPATH**/ ?>