<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seeder AMAN: tidak menghapus user, pesanan, atau data existing.
     * Hanya memastikan akun demo ada + kategori/produk.
     */
    public function run(): void
    {
        // Admin demo — tidak menimpa password jika sudah diubah
        $admin = User::firstOrCreate(
            ['email' => 'admin@toko.com'],
            [
                'name' => 'Admin Toko',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );
        // Pastikan admin selalu terverifikasi & role benar
        $admin->forceFill([
            'role' => 'admin',
            'email_verified_at' => $admin->email_verified_at ?? now(),
        ])->save();

        // Customer demo
        $customer = User::firstOrCreate(
            ['email' => 'customer@toko.com'],
            [
                'name' => 'Afif',
                'password' => bcrypt('password'),
                'role' => 'customer',
            ]
        );
        $customer->forceFill([
            'role' => 'customer',
            'email_verified_at' => $customer->email_verified_at ?? now(),
        ])->save();

        // Kategori & produk (updateOrCreate — TIDAK menghapus pesanan)
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            SiteSettingSeeder::class,
        ]);
    }
}
