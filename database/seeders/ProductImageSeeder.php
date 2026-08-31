<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * Update gambar untuk produk yang sudah ada di database.
 * Jalankan: php artisan db:seed --class=ProductImageSeeder
 */
class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $keywordMap = [
            // ELEKTRONIK
            'ROG Strix' => 'asus rog gaming laptop',
            'Galaxy A55' => 'samsung galaxy smartphone',
            'iPhone 13' => 'iphone smartphone',
            'Redmi Note' => 'xiaomi redmi smartphone',
            'JBL Tune' => 'jbl wireless headphones',
            'AirPods Pro' => 'apple airpods pro earbuds',
            'MX Master' => 'logitech wireless mouse',
            'PowerCore' => 'anker power bank',
            'Smart Band' => 'xiaomi smart band fitness tracker',
            '24MP400' => 'lg computer monitor',

            // FASHION PRIA
            'Airism' => 'uniqlo plain t-shirt',
            'Kemeja Flanel' => 'men flannel shirt',
            'Levis 511' => 'levis jeans men',
            'Fleece Hoodie' => 'nike hoodie jacket',
            'Cloudfoam' => 'adidas sneakers men',
            'Chuck Taylor' => 'converse chuck taylor sneakers',
            'Windbreaker' => 'windbreaker jacket men',
            'Zara Man' => 'men formal shirt',

            // FASHION WANITA
            'Floral Print' => 'floral dress women',
            'Tank Top' => 'women tank top',
            'Down Jacket' => 'women down jacket',
            'Stan Smith' => 'adidas stan smith sneakers',
            'Block Heel' => 'women block heel sandals',
            'Cargo Pants' => 'women cargo pants',
            'Denim Jacket' => 'women denim jacket',
            'Wrap Blouse' => 'women satin blouse',

            // RUMAH TANGGA
            'Sprei' => 'bed sheet',
            'Tupperware' => 'plastic food container set',
            'Air Fryer' => 'philips air fryer',
            'Rice Cooker' => 'electric rice cooker',
            'Panci' => 'cooking pot set',
            'Smart Kettle' => 'electric kettle',
            'Rak Serbaguna' => 'storage shelf rack',
            'Kipas Angin' => 'standing fan',

            // OLAHRAGA
            'Revolution 6' => 'nike running shoes',
            'Duramo' => 'adidas running shoes women',
            'Matras Yoga' => 'yoga mat',
            'Gym Bag' => 'gym duffel bag',
            'Bola Sepak' => 'soccer ball',
            'Dumbbell' => 'dumbbell set',
            'Dry Cell' => 'sports training t-shirt',
            'Ransel Hiking' => 'hiking backpack',

            // KESEHATAN
            'Tensimeter' => 'blood pressure monitor',
            'Body Composition Scale' => 'digital body scale',
            'Termometer' => 'infrared thermometer gun',
            'Masker' => 'medical face mask',
            'Nebulizer' => 'nebulizer machine',
            'Vitamin C' => 'vitamin c tablets',
            'Oximeter' => 'pulse oximeter',
            'P3K' => 'first aid kit',
        ];

        $updated = 0;
        foreach (Product::all() as $product) {
            $keyword = 'product';
            foreach ($keywordMap as $key => $img) {
                if (stripos($product->name, $key) !== false) {
                    $keyword = $img;
                    break;
                }
            }

            $seed = abs(crc32($product->name)) % 100000;
            $prompt = urlencode("professional product photo of {$keyword}, clean white background, studio lighting, e-commerce catalog");
            $url = "https://image.pollinations.ai/prompt/{$prompt}?width=600&height=600&seed={$seed}&nologo=true";

            $product->update(['thumbnail' => $url]);
            $updated++;
        }

        $this->command?->info("Updated images for {$updated} products.");
    }
}