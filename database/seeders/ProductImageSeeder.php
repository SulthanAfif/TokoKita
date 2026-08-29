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
            'Laptop' => 'gaming laptop computer',
            'Smartphone' => 'modern smartphone',
            'Earbuds' => 'wireless earbuds',
            'Smartwatch' => 'smartwatch',
            'Powerbank' => 'power bank',
            'Kabel' => 'usb c cable',
            'Mouse' => 'wireless mouse',
            'Keyboard' => 'mechanical keyboard',
            'Monitor' => 'computer monitor',
            'Flashdisk' => 'usb flash drive',
            'Microphone' => 'studio microphone',
            'Webcam' => 'webcam',
            'Ring Light' => 'ring light',
            'Drawing' => 'drawing tablet',
            'Headset' => 'gaming headset',
            'Cooling' => 'laptop cooling pad',
            'Lensa' => 'phone camera lens',
            'Kemeja Flanel' => 'men flannel shirt',
            'Kaos' => 'plain t-shirt',
            'Jeans' => 'men jeans',
            'Hoodie' => 'hoodie jacket',
            'Sneakers' => 'white sneakers',
            'Ransel' => 'laptop backpack',
            'Topi' => 'baseball cap',
            'Dompet Kulit' => 'leather wallet',
            'Jam Tangan Pria' => 'men analog watch',
            'Sabuk' => 'men belt',
            'Chino' => 'chino pants',
            'Batik' => 'batik shirt',
            'Rompi' => 'men knit vest',
            'Bomber' => 'bomber jacket',
            'Sandal Kulit' => 'men leather sandals',
            'Aviator' => 'aviator sunglasses',
            'Boardshort' => 'board shorts',
            'Dress Floral' => 'floral dress',
            'Blouse' => 'women blouse',
            'Kulot' => 'women culottes',
            'Rok' => 'pleated skirt',
            'Cardigan' => 'women cardigan',
            'Selempang' => 'women shoulder bag',
            'Flat Shoes' => 'ballet flats',
            'Heels' => 'women heels',
            'Rose Gold' => 'women rose gold watch',
            'Dompet Panjang' => 'women wallet',
            'Oversize' => 'oversized linen shirt',
            'Gamis' => 'muslimah dress',
            'Pashmina' => 'pashmina hijab',
            'Scarf' => 'silk scarf',
            'Cat Eye' => 'cat eye glasses',
            'Sandal Tali' => 'women strap sandals',
            'Piyama' => 'silk pajama set',
            'Sprei' => 'bed sheet',
            'Bantal' => 'pillow',
            'Selimut' => 'blanket',
            'Lampu Meja' => 'desk lamp',
            'Karpet' => 'fluffy carpet',
            'Rak Sepatu' => 'shoe rack',
            'Kotak Penyimpanan' => 'storage box',
            'Wajan' => 'frying pan',
            'Panci' => 'cooking pot',
            'Spatula' => 'wooden spatula',
            'Pisau' => 'kitchen knife set',
            'Blender' => 'portable blender',
            'Setrika' => 'electric iron',
            'Kipas' => 'desk fan',
            'Jemuran' => 'clothes drying rack',
            'Pel Lantai' => 'spin mop',
            'Skipping' => 'jump rope',
            'Sepatu Lari' => 'running shoes',
            'Pull Up' => 'pull up bar',
            'Dumbbell' => 'dumbbell',
            'Matras' => 'yoga mat',
            'Botol Minum' => 'sports water bottle',
            'Handuk' => 'sports towel',
            'Kacamata Sepeda' => 'cycling glasses',
            'Waist Bag' => 'running waist bag',
            'Resistance' => 'resistance band',
            'Baju Lari' => 'running shirt',
            'Training' => 'training pants',
            'Jersey' => 'cycling jersey',
            'Helm' => 'bike helmet',
            'Sarung Tangan' => 'gym gloves',
            'Renang' => 'swimming goggles',
            'Raket' => 'badminton racket',
            'Masker' => 'medical face mask',
            'Sanitizer' => 'hand sanitizer',
            'Termometer' => 'infrared thermometer',
            'Oximeter' => 'pulse oximeter',
            'Timbangan' => 'digital scale',
            'Gula Darah' => 'blood glucose meter',
            'Vitamin' => 'vitamin c tablets',
            'Telon' => 'baby oil bottle',
            'Kayu Putih' => 'eucalyptus oil',
            'P3K' => 'first aid kit',
            'Pijat' => 'neck massager',
            'Korset' => 'back support belt',
            'Bahu' => 'shoulder support',
            'Tetes Mata' => 'eye drops',
            'Plester' => 'band aid',
            'Sabun' => 'hand soap',
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
