
<header class="sticky top-0 z-50 bg-white border-b border-slate-200/80 shadow-sm" x-data="{ mobileOpen: false }">

    
    <div class="hidden md:block border-b border-slate-100 bg-slate-50/80">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-end h-9 gap-1 text-xs">
                <a href="<?php echo e(route('pages.about')); ?>"
                   class="px-2.5 py-1 text-slate-500 hover:text-indigo-600 transition-colors duration-200
                          <?php echo e(request()->routeIs('pages.about') ? 'text-indigo-600 font-medium' : ''); ?>">
                    Tentang
                </a>
                <span class="text-slate-300">|</span>
                <a href="<?php echo e(route('pages.contact')); ?>"
                   class="px-2.5 py-1 text-slate-500 hover:text-indigo-600 transition-colors duration-200
                          <?php echo e(request()->routeIs('pages.contact') ? 'text-indigo-600 font-medium' : ''); ?>">
                    Kontak
                </a>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->isAdmin()): ?>
                        <span class="text-slate-300">|</span>
                        <a href="<?php echo e(route('admin.dashboard')); ?>"
                           class="px-2.5 py-1 text-indigo-600 font-medium hover:text-indigo-500 transition-colors duration-200">
                            Admin Panel
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center h-[68px] gap-4 lg:gap-6">

            
            <div class="flex items-center gap-3 shrink-0">
                <a href="<?php echo e(route('home')); ?>"
                   class="text-2xl font-extrabold tracking-tight transition-transform duration-200 hover:scale-105 active:scale-95">
                    <span class="text-indigo-600">Toko</span><span class="text-slate-800">Kita</span>
                </a>
                <a href="<?php echo e(route('products.index')); ?>"
                   class="hidden sm:inline-flex items-center gap-1 px-3 py-2 text-sm font-medium text-slate-600 rounded-lg
                          transition-all duration-200 hover:text-indigo-600 hover:bg-indigo-50
                          <?php echo e(request()->routeIs('products.*') ? 'text-indigo-600 bg-indigo-50' : ''); ?>">
                    Produk
                </a>
            </div>

            
            <form action="<?php echo e(route('products.index')); ?>" method="GET" class="hidden sm:flex flex-1 min-w-0">
                <div class="relative w-full group">
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                           placeholder="Cari produk..."
                           class="w-full rounded-lg border border-slate-200 bg-white pl-4 pr-12 py-2.5 text-sm
                                  transition-all duration-300 ease-out
                                  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:shadow-md focus:shadow-indigo-50
                                  group-hover:border-indigo-300">
                    <button type="submit"
                            class="absolute right-1.5 top-1/2 -translate-y-1/2 flex items-center justify-center
                                   w-9 h-8 rounded-md bg-indigo-600 text-white
                                   transition-all duration-200 hover:bg-indigo-500 hover:scale-105 active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                </div>
            </form>

            
            <div class="hidden sm:flex items-center shrink-0 gap-1">
                <?php if(auth()->guard()->check()): ?>
                    
                    <?php if (isset($component)) { $__componentOriginal04a243689af4e54eeed72acf3cbb05d6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal04a243689af4e54eeed72acf3cbb05d6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.orders-icon','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('orders-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal04a243689af4e54eeed72acf3cbb05d6)): ?>
<?php $attributes = $__attributesOriginal04a243689af4e54eeed72acf3cbb05d6; ?>
<?php unset($__attributesOriginal04a243689af4e54eeed72acf3cbb05d6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal04a243689af4e54eeed72acf3cbb05d6)): ?>
<?php $component = $__componentOriginal04a243689af4e54eeed72acf3cbb05d6; ?>
<?php unset($__componentOriginal04a243689af4e54eeed72acf3cbb05d6); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalff467597409d3d5104c229cfe35ec26e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalff467597409d3d5104c229cfe35ec26e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cart-icon','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cart-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalff467597409d3d5104c229cfe35ec26e)): ?>
<?php $attributes = $__attributesOriginalff467597409d3d5104c229cfe35ec26e; ?>
<?php unset($__attributesOriginalff467597409d3d5104c229cfe35ec26e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff467597409d3d5104c229cfe35ec26e)): ?>
<?php $component = $__componentOriginalff467597409d3d5104c229cfe35ec26e; ?>
<?php unset($__componentOriginalff467597409d3d5104c229cfe35ec26e); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal6ebcfe4cdda59dadbf9997ea22f8f370 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6ebcfe4cdda59dadbf9997ea22f8f370 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notif-icon','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('notif-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6ebcfe4cdda59dadbf9997ea22f8f370)): ?>
<?php $attributes = $__attributesOriginal6ebcfe4cdda59dadbf9997ea22f8f370; ?>
<?php unset($__attributesOriginal6ebcfe4cdda59dadbf9997ea22f8f370); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6ebcfe4cdda59dadbf9997ea22f8f370)): ?>
<?php $component = $__componentOriginal6ebcfe4cdda59dadbf9997ea22f8f370; ?>
<?php unset($__componentOriginal6ebcfe4cdda59dadbf9997ea22f8f370); ?>
<?php endif; ?>

                    <div class="w-px h-7 bg-slate-200 mx-2"></div>

                    <?php if (isset($component)) { $__componentOriginal32077e48dfcf7eeccbd729b994858fc5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32077e48dfcf7eeccbd729b994858fc5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.profile-avatar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('profile-avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal32077e48dfcf7eeccbd729b994858fc5)): ?>
<?php $attributes = $__attributesOriginal32077e48dfcf7eeccbd729b994858fc5; ?>
<?php unset($__attributesOriginal32077e48dfcf7eeccbd729b994858fc5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal32077e48dfcf7eeccbd729b994858fc5)): ?>
<?php $component = $__componentOriginal32077e48dfcf7eeccbd729b994858fc5; ?>
<?php unset($__componentOriginal32077e48dfcf7eeccbd729b994858fc5); ?>
<?php endif; ?>

                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                                class="px-2.5 py-2 text-sm font-medium text-slate-500 rounded-lg transition-all duration-200
                                       hover:text-red-600 hover:bg-red-50" title="Keluar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                        </button>
                    </form>
                <?php else: ?>
                    
                    <?php if (isset($component)) { $__componentOriginalff467597409d3d5104c229cfe35ec26e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalff467597409d3d5104c229cfe35ec26e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cart-icon','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cart-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalff467597409d3d5104c229cfe35ec26e)): ?>
<?php $attributes = $__attributesOriginalff467597409d3d5104c229cfe35ec26e; ?>
<?php unset($__attributesOriginalff467597409d3d5104c229cfe35ec26e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff467597409d3d5104c229cfe35ec26e)): ?>
<?php $component = $__componentOriginalff467597409d3d5104c229cfe35ec26e; ?>
<?php unset($__componentOriginalff467597409d3d5104c229cfe35ec26e); ?>
<?php endif; ?>

                    
                    <div class="w-px h-7 bg-slate-200 mx-2"></div>

                    <a href="<?php echo e(route('login')); ?>"
                       class="px-4 py-2 text-sm font-semibold text-indigo-600 border border-indigo-600 rounded-lg
                              transition-all duration-200 hover:bg-indigo-50 hover:scale-[1.02] active:scale-95">
                        Masuk
                    </a>
                    <a href="<?php echo e(route('register')); ?>"
                       class="ml-1.5 px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow-sm
                              transition-all duration-200 hover:bg-indigo-500 hover:scale-[1.02] hover:shadow-md hover:shadow-indigo-200 active:scale-95">
                        Daftar
                    </a>
                <?php endif; ?>
            </div>

            
            <div class="flex items-center gap-1 sm:hidden ml-auto">
                <?php if(auth()->guard()->check()): ?>
                    <?php if (isset($component)) { $__componentOriginal04a243689af4e54eeed72acf3cbb05d6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal04a243689af4e54eeed72acf3cbb05d6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.orders-icon','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('orders-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal04a243689af4e54eeed72acf3cbb05d6)): ?>
<?php $attributes = $__attributesOriginal04a243689af4e54eeed72acf3cbb05d6; ?>
<?php unset($__attributesOriginal04a243689af4e54eeed72acf3cbb05d6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal04a243689af4e54eeed72acf3cbb05d6)): ?>
<?php $component = $__componentOriginal04a243689af4e54eeed72acf3cbb05d6; ?>
<?php unset($__componentOriginal04a243689af4e54eeed72acf3cbb05d6); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalff467597409d3d5104c229cfe35ec26e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalff467597409d3d5104c229cfe35ec26e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cart-icon','data' => ['size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cart-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalff467597409d3d5104c229cfe35ec26e)): ?>
<?php $attributes = $__attributesOriginalff467597409d3d5104c229cfe35ec26e; ?>
<?php unset($__attributesOriginalff467597409d3d5104c229cfe35ec26e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff467597409d3d5104c229cfe35ec26e)): ?>
<?php $component = $__componentOriginalff467597409d3d5104c229cfe35ec26e; ?>
<?php unset($__componentOriginalff467597409d3d5104c229cfe35ec26e); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal6ebcfe4cdda59dadbf9997ea22f8f370 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6ebcfe4cdda59dadbf9997ea22f8f370 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notif-icon','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('notif-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6ebcfe4cdda59dadbf9997ea22f8f370)): ?>
<?php $attributes = $__attributesOriginal6ebcfe4cdda59dadbf9997ea22f8f370; ?>
<?php unset($__attributesOriginal6ebcfe4cdda59dadbf9997ea22f8f370); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6ebcfe4cdda59dadbf9997ea22f8f370)): ?>
<?php $component = $__componentOriginal6ebcfe4cdda59dadbf9997ea22f8f370; ?>
<?php unset($__componentOriginal6ebcfe4cdda59dadbf9997ea22f8f370); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal32077e48dfcf7eeccbd729b994858fc5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal32077e48dfcf7eeccbd729b994858fc5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.profile-avatar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('profile-avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal32077e48dfcf7eeccbd729b994858fc5)): ?>
<?php $attributes = $__attributesOriginal32077e48dfcf7eeccbd729b994858fc5; ?>
<?php unset($__attributesOriginal32077e48dfcf7eeccbd729b994858fc5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal32077e48dfcf7eeccbd729b994858fc5)): ?>
<?php $component = $__componentOriginal32077e48dfcf7eeccbd729b994858fc5; ?>
<?php unset($__componentOriginal32077e48dfcf7eeccbd729b994858fc5); ?>
<?php endif; ?>
                <?php else: ?>
                    <?php if (isset($component)) { $__componentOriginalff467597409d3d5104c229cfe35ec26e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalff467597409d3d5104c229cfe35ec26e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.cart-icon','data' => ['size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('cart-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalff467597409d3d5104c229cfe35ec26e)): ?>
<?php $attributes = $__attributesOriginalff467597409d3d5104c229cfe35ec26e; ?>
<?php unset($__attributesOriginalff467597409d3d5104c229cfe35ec26e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff467597409d3d5104c229cfe35ec26e)): ?>
<?php $component = $__componentOriginalff467597409d3d5104c229cfe35ec26e; ?>
<?php unset($__componentOriginalff467597409d3d5104c229cfe35ec26e); ?>
<?php endif; ?>
                <?php endif; ?>
                <button @click="mobileOpen = !mobileOpen" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    
    <div x-show="mobileOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="sm:hidden border-t border-slate-100 bg-white">
        <div class="px-4 py-3 space-y-1">
            <form action="<?php echo e(route('products.index')); ?>" method="GET" class="mb-3">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                       placeholder="Cari produk..."
                       class="w-full rounded-lg border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </form>
            <a href="<?php echo e(route('products.index')); ?>" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Produk</a>
            <a href="<?php echo e(route('pages.about')); ?>" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Tentang</a>
            <a href="<?php echo e(route('pages.contact')); ?>" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Kontak</a>
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('orders.index')); ?>" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Pesanan</a>
                <a href="<?php echo e(route('profile.edit')); ?>" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Profil</a>
                <?php if(auth()->user()->isAdmin()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-indigo-600 hover:bg-indigo-50 transition">Admin Panel</a>
                <?php endif; ?>
                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full text-left px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition">Keluar</button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Masuk</a>
                <a href="<?php echo e(route('register')); ?>" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-indigo-600 hover:bg-indigo-50 transition">Daftar</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<?php /**PATH C:\proyek porto\TokoKita\resources\views/components/navbar.blade.php ENDPATH**/ ?>