<?php $__env->startSection('title', 'Profil Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-slate-800 mb-8">Profil Saya</h1>

    
    <div class="rounded-2xl border border-slate-200 bg-white p-6 mb-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-1">Informasi Akun</h2>
        <p class="text-sm text-slate-500 mb-6">Perbarui nama, email, dan nomor telepon Anda.</p>

        <form method="POST" action="<?php echo e(route('profile.update')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>

            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
                <input type="text" id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-slate-700 mb-1">No. Telepon</label>
                <input type="text" id="phone" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>"
                       placeholder="08xxxxxxxxxx"
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <button type="submit"
                    class="rounded-full bg-indigo-600 text-white px-6 py-2.5 text-sm font-semibold hover:bg-indigo-500 transition">
                Simpan Perubahan
            </button>
        </form>
    </div>

    
    <div class="rounded-2xl border border-slate-200 bg-white p-6 mb-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-1">Alamat Pengiriman</h2>
        <p class="text-sm text-slate-500 mb-6">Alamat ini digunakan saat checkout. Minimal 1 alamat diperlukan.</p>

        <?php if($addresses->isNotEmpty()): ?>
            <div class="space-y-3 mb-6">
                <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-start justify-between gap-4 rounded-xl border border-slate-200 p-4">
                        <div class="text-sm">
                            <p class="font-semibold text-slate-800">
                                <?php echo e($address->label); ?>

                                <?php if($address->is_default): ?>
                                    <span class="ml-1 text-xs bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-full">Default</span>
                                <?php endif; ?>
                            </p>
                            <p class="text-slate-600 mt-1"><?php echo e($address->recipient_name); ?> · <?php echo e($address->phone); ?></p>
                            <p class="text-slate-500"><?php echo e($address->full_address); ?>, <?php echo e($address->city); ?>, <?php echo e($address->province); ?> <?php echo e($address->postal_code); ?></p>
                        </div>
                        <form action="<?php echo e(route('profile.address.destroy', $address)); ?>" method="POST"
                              onsubmit="return confirm('Hapus alamat ini?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus</button>
                        </form>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('profile.address.store')); ?>" class="space-y-4 border-t border-slate-100 pt-6">
            <?php echo csrf_field(); ?>
            <p class="text-sm font-medium text-slate-700">Tambah Alamat Baru</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Label</label>
                    <input type="text" name="label" value="<?php echo e(old('label', 'Rumah')); ?>" required
                           class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="Rumah / Kantor">
                    <?php $__errorArgs = ['label'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Nama Penerima</label>
                    <input type="text" name="recipient_name" value="<?php echo e(old('recipient_name', $user->name)); ?>" required
                           class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <?php $__errorArgs = ['recipient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div>
                <label class="block text-sm text-slate-600 mb-1">No. Telepon</label>
                <input type="text" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>" required
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="08xxxxxxxxxx">
                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="block text-sm text-slate-600 mb-1">Alamat Lengkap</label>
                <textarea name="full_address" rows="2" required
                          class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                          placeholder="Jl. Merdeka No. 123, RT 01/02"><?php echo e(old('full_address')); ?></textarea>
                <?php $__errorArgs = ['full_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Kota</label>
                    <input type="text" name="city" value="<?php echo e(old('city')); ?>" required
                           class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Provinsi</label>
                    <input type="text" name="province" value="<?php echo e(old('province')); ?>" required
                           class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <?php $__errorArgs = ['province'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Kode Pos</label>
                    <input type="text" name="postal_code" value="<?php echo e(old('postal_code')); ?>" required
                           class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <?php $__errorArgs = ['postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <button type="submit"
                    class="rounded-full bg-indigo-600 text-white px-6 py-2.5 text-sm font-semibold hover:bg-indigo-500 transition">
                Tambah Alamat
            </button>
        </form>
    </div>

    
    <div class="rounded-2xl border border-slate-200 bg-white p-6 mb-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-1">Ubah Password</h2>
        <p class="text-sm text-slate-500 mb-6">Pastikan akun Anda menggunakan password yang kuat.</p>

        <form method="POST" action="<?php echo e(route('password.update')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div>
                <label for="current_password" class="block text-sm font-medium text-slate-700 mb-1">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password" required
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                       autocomplete="current-password">
                <?php $__errorArgs = ['current_password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                <input type="password" id="password" name="password" required
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                       autocomplete="new-password">
                <?php $__errorArgs = ['password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="w-full rounded-xl border-slate-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                       autocomplete="new-password">
            </div>

            <button type="submit"
                    class="rounded-full bg-indigo-600 text-white px-6 py-2.5 text-sm font-semibold hover:bg-indigo-500 transition">
                Update Password
            </button>
        </form>
    </div>

    
    <div class="rounded-2xl border border-red-200 bg-red-50 p-6">
        <h2 class="text-lg font-semibold text-red-700 mb-1">Hapus Akun</h2>
        <p class="text-sm text-red-600 mb-4">Setelah akun dihapus, semua data akan hilang secara permanen.</p>

        <form method="POST" action="<?php echo e(route('profile.destroy')); ?>"
              onsubmit="return confirm('Yakin ingin menghapus akun? Tindakan ini tidak bisa dibatalkan.')">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>

            <div class="mb-4">
                <label for="delete_password" class="block text-sm font-medium text-red-700 mb-1">Masukkan password untuk konfirmasi</label>
                <input type="password" id="delete_password" name="password" required
                       class="w-full max-w-sm rounded-xl border-red-300 text-sm focus:ring-red-500 focus:border-red-500">
                <?php $__errorArgs = ['password', 'userDeletion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <button type="submit"
                    class="rounded-full bg-red-600 text-white px-6 py-2.5 text-sm font-semibold hover:bg-red-500 transition">
                Hapus Akun Saya
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\proyekporto\project\TokoKita\resources\views/profile/edit.blade.php ENDPATH**/ ?>