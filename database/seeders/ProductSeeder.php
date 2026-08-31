<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

        \Illuminate\Support\Facades\DB::table('order_items')->update(['product_id' => null]);
        \Illuminate\Support\Facades\DB::table('cart_items')->delete();
        \Illuminate\Support\Facades\DB::table('product_images')->delete();
        \Illuminate\Support\Facades\DB::table('products')->delete();

        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        if ($driver === 'mysql') {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE products AUTO_INCREMENT = 1');
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE product_images AUTO_INCREMENT = 1');
        } elseif ($driver === 'sqlite') {
            \Illuminate\Support\Facades\DB::statement("DELETE FROM sqlite_sequence WHERE name='products'");
            \Illuminate\Support\Facades\DB::statement("DELETE FROM sqlite_sequence WHERE name='product_images'");
        }

        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $catElektronik = Category::firstOrCreate(['name' => 'Elektronik'], ['slug' => 'elektronik'])->id;
        $catFashionPria = Category::firstOrCreate(['name' => 'Fashion Pria'], ['slug' => 'fashion-pria'])->id;
        $catFashionWanita = Category::firstOrCreate(['name' => 'Fashion Wanita'], ['slug' => 'fashion-wanita'])->id;
        $catRumahTangga = Category::firstOrCreate(['name' => 'Rumah Tangga'], ['slug' => 'rumah-tangga'])->id;
        $catOlahraga = Category::firstOrCreate(['name' => 'Olahraga'], ['slug' => 'olahraga'])->id;
        $catKesehatan = Category::firstOrCreate(['name' => 'Kesehatan'], ['slug' => 'kesehatan'])->id;

        $products = [
            // ELEKTRONIK (10)
            ['category_id' => $catElektronik, 'name' => 'ASUS ROG Strix G16 Intel Core i7-13650HX RTX 4060', 'price' => 21500000],
            ['category_id' => $catElektronik, 'name' => 'Samsung Galaxy A55 5G 8/256GB', 'price' => 5299000],
            ['category_id' => $catElektronik, 'name' => 'iPhone 13 128GB', 'price' => 9999000],
            ['category_id' => $catElektronik, 'name' => 'Xiaomi Redmi Note 13 Pro 8/256GB', 'price' => 3799000],
            ['category_id' => $catElektronik, 'name' => 'JBL Tune 510BT Wireless On-Ear Headphones', 'price' => 449000],
            ['category_id' => $catElektronik, 'name' => 'Apple AirPods Pro 2nd Generation', 'price' => 3299000],
            ['category_id' => $catElektronik, 'name' => 'Logitech MX Master 3S Wireless Mouse', 'price' => 1399000],
            ['category_id' => $catElektronik, 'name' => 'Anker PowerCore 20000mAh Power Bank', 'price' => 399000],
            ['category_id' => $catElektronik, 'name' => 'Xiaomi Mi Smart Band 8', 'price' => 349000],
            ['category_id' => $catElektronik, 'name' => 'LG 24 Inch Full HD IPS Monitor 24MP400', 'price' => 1650000],

            // FASHION PRIA (8)
            ['category_id' => $catFashionPria, 'name' => 'Uniqlo Airism Cotton Crew Neck T-Shirt Pria', 'price' => 149000],
            ['category_id' => $catFashionPria, 'name' => 'Erigo Kemeja Flanel Lengan Panjang Pria', 'price' => 159000],
            ['category_id' => $catFashionPria, 'name' => 'Levis 511 Slim Fit Jeans Pria', 'price' => 649000],
            ['category_id' => $catFashionPria, 'name' => 'Nike Sportswear Club Fleece Hoodie Pria', 'price' => 799000],
            ['category_id' => $catFashionPria, 'name' => 'Adidas Cloudfoam Pure Sneakers Pria', 'price' => 549000],
            ['category_id' => $catFashionPria, 'name' => 'Converse Chuck Taylor All Star Classic', 'price' => 599000],
            ['category_id' => $catFashionPria, 'name' => 'Eiger Jaket Parasut Windbreaker Pria', 'price' => 299000],
            ['category_id' => $catFashionPria, 'name' => 'Zara Man Slim Fit Formal Shirt', 'price' => 429000],

            // FASHION WANITA (8)
            ['category_id' => $catFashionWanita, 'name' => 'Zara Woman Floral Print Midi Dress', 'price' => 599000],
            ['category_id' => $catFashionWanita, 'name' => 'H&M Basic Ribbed Tank Top Wanita', 'price' => 149000],
            ['category_id' => $catFashionWanita, 'name' => 'Uniqlo Ultra Light Down Jacket Wanita', 'price' => 799000],
            ['category_id' => $catFashionWanita, 'name' => 'Adidas Stan Smith Sneakers Wanita', 'price' => 1199000],
            ['category_id' => $catFashionWanita, 'name' => 'Charles & Keith Block Heel Sandals', 'price' => 899000],
            ['category_id' => $catFashionWanita, 'name' => 'Erigo Cargo Pants Wanita', 'price' => 259000],
            ['category_id' => $catFashionWanita, 'name' => 'Pull&Bear Oversized Denim Jacket Wanita', 'price' => 549000],
            ['category_id' => $catFashionWanita, 'name' => 'Mango Satin Wrap Blouse Wanita', 'price' => 449000],

            // RUMAH TANGGA (8)
            ['category_id' => $catRumahTangga, 'name' => 'IKEA Sprei Katun Motif Minimalis 160x200', 'price' => 249000],
            ['category_id' => $catRumahTangga, 'name' => 'Tupperware One Touch Topper Set', 'price' => 385000],
            ['category_id' => $catRumahTangga, 'name' => 'Philips Air Fryer HD9200 4.1L', 'price' => 899000],
            ['category_id' => $catRumahTangga, 'name' => 'Electrolux Rice Cooker Digital 1.8L', 'price' => 749000],
            ['category_id' => $catRumahTangga, 'name' => 'Maspion Panci Set Stainless Steel 5pcs', 'price' => 425000],
            ['category_id' => $catRumahTangga, 'name' => 'Xiaomi Mi Smart Kettle Pro', 'price' => 599000],
            ['category_id' => $catRumahTangga, 'name' => 'Ace Hardware Rak Serbaguna 4 Susun', 'price' => 349000],
            ['category_id' => $catRumahTangga, 'name' => 'Chigo Kipas Angin Berdiri 16 Inch', 'price' => 289000],

            // OLAHRAGA (8)
            ['category_id' => $catOlahraga, 'name' => 'Nike Revolution 6 Sepatu Lari Pria', 'price' => 649000],
            ['category_id' => $catOlahraga, 'name' => 'Adidas Duramo SL Sepatu Lari Wanita', 'price' => 599000],
            ['category_id' => $catOlahraga, 'name' => 'Decathlon Domyos Matras Yoga 8mm', 'price' => 149000],
            ['category_id' => $catOlahraga, 'name' => 'Under Armour Training Gym Bag', 'price' => 449000],
            ['category_id' => $catOlahraga, 'name' => 'Specs Bola Sepak Accelerator Pro', 'price' => 275000],
            ['category_id' => $catOlahraga, 'name' => 'Decathlon Dumbbell Set 2x5kg', 'price' => 199000],
            ['category_id' => $catOlahraga, 'name' => 'Puma Training T-Shirt Dry Cell', 'price' => 249000],
            ['category_id' => $catOlahraga, 'name' => 'Eiger Tas Ransel Hiking 40L', 'price' => 549000],

            // KESEHATAN (8)
            ['category_id' => $catKesehatan, 'name' => 'Omron HEM-8712 Tensimeter Digital', 'price' => 385000],
            ['category_id' => $catKesehatan, 'name' => 'Xiaomi Mi Body Composition Scale 2', 'price' => 279000],
            ['category_id' => $catKesehatan, 'name' => 'Termometer Digital Infrared Gun Non Kontak', 'price' => 129000],
            ['category_id' => $catKesehatan, 'name' => 'Sensi Masker Medis 3 Ply 50pcs', 'price' => 39000],
            ['category_id' => $catKesehatan, 'name' => 'Nebulizer Omron NE-C801 Compressor', 'price' => 649000],
            ['category_id' => $catKesehatan, 'name' => 'Blackmores Vitamin C 500mg 60 Tablet', 'price' => 149000],
            ['category_id' => $catKesehatan, 'name' => 'Oximeter Fingertip Pulse Digital', 'price' => 99000],
            ['category_id' => $catKesehatan, 'name' => 'Kotak P3K Lengkap First Aid Kit', 'price' => 175000],
        ];

        foreach ($products as $item) {
            $price = $item['price'];

            Product::updateOrCreate(
                ['name' => $item['name']],
                [
                    'category_id' => $item['category_id'],
                    'description' => fake()->paragraph(3),
                    'price' => $price,
                    'discount_price' => fake()->boolean(25) ? round($price * 0.85, -3) : null,
                    'stock' => fake()->numberBetween(5, 150),
                    'sku' => 'SKU-' . strtoupper(Str::random(8)),
                    'thumbnail' => null,
                    'is_active' => true,
                ]
            );
        }
    }
}
