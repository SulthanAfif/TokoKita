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
        $catElektronik = Category::firstOrCreate(['name' => 'Elektronik'], ['slug' => 'elektronik'])->id;
        $catFashionPria = Category::firstOrCreate(['name' => 'Fashion Pria'], ['slug' => 'fashion-pria'])->id;
        $catFashionWanita = Category::firstOrCreate(['name' => 'Fashion Wanita'], ['slug' => 'fashion-wanita'])->id;
        $catRumahTangga = Category::firstOrCreate(['name' => 'Rumah Tangga'], ['slug' => 'rumah-tangga'])->id;
        $catOlahraga = Category::firstOrCreate(['name' => 'Olahraga'], ['slug' => 'olahraga'])->id;
        $catKesehatan = Category::firstOrCreate(['name' => 'Kesehatan'], ['slug' => 'kesehatan'])->id;

        $products = [
            // ELEKTRONIK
            ['category_id' => $catElektronik, 'name' => 'Laptop Gaming Intel Core i7-12700H RTX 3050 8GB', 'price' => 14500000],
            ['category_id' => $catElektronik, 'name' => 'Smartphone 5G RAM 8GB/256GB', 'price' => 4500000],
            ['category_id' => $catElektronik, 'name' => 'True Wireless Earbuds Bluetooth 5.3', 'price' => 250000],
            ['category_id' => $catElektronik, 'name' => 'Smartwatch Amoled Display', 'price' => 750000],
            ['category_id' => $catElektronik, 'name' => 'Powerbank 10000mAh Fast Charging', 'price' => 185000],
            ['category_id' => $catElektronik, 'name' => 'Kabel Data Type-C to Type-C 100W', 'price' => 45000],
            ['category_id' => $catElektronik, 'name' => 'Mouse Wireless Silent Click', 'price' => 95000],
            ['category_id' => $catElektronik, 'name' => 'Keyboard Mekanikal TKL Switch Merah', 'price' => 350000],
            ['category_id' => $catElektronik, 'name' => 'Monitor IPS 24 Inch 100Hz Frameless', 'price' => 1650000],
            ['category_id' => $catElektronik, 'name' => 'Flashdisk USB 3.2 Kapasitas 64GB', 'price' => 85000],
            ['category_id' => $catElektronik, 'name' => 'Microphone Condenser Podcast & Streaming', 'price' => 350000],
            ['category_id' => $catElektronik, 'name' => 'Webcam 1080p 60fps Auto Focus', 'price' => 550000],
            ['category_id' => $catElektronik, 'name' => 'Ring Light LED 10 Inch + Tripod', 'price' => 120000],
            ['category_id' => $catElektronik, 'name' => 'Drawing Pen Tablet Grafis Digital Art', 'price' => 650000],
            ['category_id' => $catElektronik, 'name' => 'Headset Gaming 7.1 Surround Sound', 'price' => 320000],
            ['category_id' => $catElektronik, 'name' => 'Cooling Pad Laptop 5 Kipas LED', 'price' => 145000],
            ['category_id' => $catElektronik, 'name' => 'Lensa Wide/Macro Tambahan iPhone', 'price' => 85000],

            // FASHION PRIA
            ['category_id' => $catFashionPria, 'name' => 'Kemeja Flanel Pria Lengan Panjang', 'price' => 135000],
            ['category_id' => $catFashionPria, 'name' => 'Kaos Polos Cotton Combed 30s Premium', 'price' => 45000],
            ['category_id' => $catFashionPria, 'name' => 'Celana Jeans Pria Reguler Fit', 'price' => 185000],
            ['category_id' => $catFashionPria, 'name' => 'Jaket Hoodie Pria Polos Tebal', 'price' => 150000],
            ['category_id' => $catFashionPria, 'name' => 'Sepatu Sneakers Putih Kanvas Kasual', 'price' => 250000],
            ['category_id' => $catFashionPria, 'name' => 'Tas Ransel Laptop Anti Air 20L', 'price' => 210000],
            ['category_id' => $catFashionPria, 'name' => 'Topi Baseball Polos Katun Pria', 'price' => 35000],
            ['category_id' => $catFashionPria, 'name' => 'Dompet Kulit Sintetis Pria Elegan', 'price' => 95000],
            ['category_id' => $catFashionPria, 'name' => 'Jam Tangan Pria Analog Tali Kulit', 'price' => 175000],
            ['category_id' => $catFashionPria, 'name' => 'Sabuk Pria Kanvas Taktis Gesper Besi', 'price' => 40000],
            ['category_id' => $catFashionPria, 'name' => 'Celana Chino Panjang Slim Fit', 'price' => 160000],
            ['category_id' => $catFashionPria, 'name' => 'Kemeja Batik Pria Lengan Pendek', 'price' => 145000],
            ['category_id' => $catFashionPria, 'name' => 'Rompi Rajut Pria V-Neck Korea', 'price' => 90000],
            ['category_id' => $catFashionPria, 'name' => 'Jaket Bomber Pria Parasut Anti Angin', 'price' => 170000],
            ['category_id' => $catFashionPria, 'name' => 'Sandal Kulit Kasual Pria Premium', 'price' => 125000],
            ['category_id' => $catFashionPria, 'name' => 'Kacamata Hitam Aviator Anti UV', 'price' => 85000],
            ['category_id' => $catFashionPria, 'name' => 'Celana Pendek Santai Boardshort', 'price' => 65000],

            // FASHION WANITA
            ['category_id' => $catFashionWanita, 'name' => 'Dress Floral Motif Bunga Klasik', 'price' => 165000],
            ['category_id' => $catFashionWanita, 'name' => 'Blouse Lengan Panjang Wanita Kasual', 'price' => 125000],
            ['category_id' => $catFashionWanita, 'name' => 'Celana Kulot Highwaist Elegan', 'price' => 110000],
            ['category_id' => $catFashionWanita, 'name' => 'Rok Plisket Premium Panjang', 'price' => 95000],
            ['category_id' => $catFashionWanita, 'name' => 'Jaket Cardigan Rajut Wanita Tebal', 'price' => 135000],
            ['category_id' => $catFashionWanita, 'name' => 'Tas Selempang Wanita Kulit Sintetis', 'price' => 150000],
            ['category_id' => $catFashionWanita, 'name' => 'Sepatu Flat Shoes Balet Nyaman', 'price' => 115000],
            ['category_id' => $catFashionWanita, 'name' => 'Sepatu Heels Wanita Hak 5cm', 'price' => 185000],
            ['category_id' => $catFashionWanita, 'name' => 'Jam Tangan Wanita Rose Gold Anti Air', 'price' => 155000],
            ['category_id' => $catFashionWanita, 'name' => 'Dompet Panjang Wanita Multi Slot', 'price' => 85000],
            ['category_id' => $catFashionWanita, 'name' => 'Kemeja Oversize Linen Wanita Korea', 'price' => 120000],
            ['category_id' => $catFashionWanita, 'name' => 'Baju Gamis Wanita Syari Polos', 'price' => 210000],
            ['category_id' => $catFashionWanita, 'name' => 'Pashmina Ceruty Babydoll Premium', 'price' => 35000],
            ['category_id' => $catFashionWanita, 'name' => 'Scarf Motif Abstrak Sutra Halus', 'price' => 45000],
            ['category_id' => $catFashionWanita, 'name' => 'Kacamata Fashion Wanita Cat Eye', 'price' => 65000],
            ['category_id' => $catFashionWanita, 'name' => 'Sandal Tali Wanita Gaya Korea Nyaman', 'price' => 95000],
            ['category_id' => $catFashionWanita, 'name' => 'Baju Tidur Piyama Set Sutra Lembut', 'price' => 130000],

            // RUMAH TANGGA
            ['category_id' => $catRumahTangga, 'name' => 'Sprei Katun Motif Minimalis 160x200', 'price' => 145000],
            ['category_id' => $catRumahTangga, 'name' => 'Bantal Kepala Silicon Dacron Anti Kempes', 'price' => 60000],
            ['category_id' => $catRumahTangga, 'name' => 'Selimut Bulu Halus Hangat Motif Polos', 'price' => 110000],
            ['category_id' => $catRumahTangga, 'name' => 'Lampu Meja Belajar LED Tiga Warna Lipat', 'price' => 85000],
            ['category_id' => $catRumahTangga, 'name' => 'Karpet Bulu Rasfur Anti Slip 150x200', 'price' => 125000],
            ['category_id' => $catRumahTangga, 'name' => 'Rak Sepatu Susun 4 Tingkat Minimalis', 'price' => 75000],
            ['category_id' => $catRumahTangga, 'name' => 'Kotak Penyimpanan Baju Serbaguna Foldable', 'price' => 55000],
            ['category_id' => $catRumahTangga, 'name' => 'Wajan Anti Lengket 24cm Lapis Marble', 'price' => 165000],
            ['category_id' => $catRumahTangga, 'name' => 'Panci Sup Stainless Steel Tutup Kaca', 'price' => 135000],
            ['category_id' => $catRumahTangga, 'name' => 'Spatula Kayu Set Dapur Anti Panas', 'price' => 45000],
            ['category_id' => $catRumahTangga, 'name' => 'Pisau Dapur Set 5 in 1 Stainless', 'price' => 95000],
            ['category_id' => $catRumahTangga, 'name' => 'Blender Mini Portabel USB Rechargeable', 'price' => 120000],
            ['category_id' => $catRumahTangga, 'name' => 'Setrika Listrik Lapisan Anti Lengket', 'price' => 180000],
            ['category_id' => $catRumahTangga, 'name' => 'Kipas Angin Meja Portabel USB', 'price' => 150000],
            ['category_id' => $catRumahTangga, 'name' => 'Jemuran Baju Lipat Stainless Steel Kuat', 'price' => 250000],
            ['category_id' => $catRumahTangga, 'name' => 'Alat Pel Lantai Putar Otomatis + Ember', 'price' => 145000],

            // OLAHRAGA
            ['category_id' => $catOlahraga, 'name' => 'Tali Skipping Speed Rope Bearing Adjustable', 'price' => 65000],
            ['category_id' => $catOlahraga, 'name' => 'Sepatu Lari Jogging Pria Ringan Breathable', 'price' => 320000],
            ['category_id' => $catOlahraga, 'name' => 'Pull Up Bar Pintu Portabel Pembentuk Bahu', 'price' => 115000],
            ['category_id' => $catOlahraga, 'name' => 'Dumbbell Neoprene Lapis Karet 2.5 KG', 'price' => 75000],
            ['category_id' => $catOlahraga, 'name' => 'Matras Yoga Anti Slip Tebal 8mm Premium', 'price' => 125000],
            ['category_id' => $catOlahraga, 'name' => 'Botol Minum Olahraga Stainless 1 Liter', 'price' => 85000],
            ['category_id' => $catOlahraga, 'name' => 'Handuk Olahraga Microfiber Cepat Kering', 'price' => 35000],
            ['category_id' => $catOlahraga, 'name' => 'Kacamata Sepeda Olahraga Anti UV Lensa Gelap', 'price' => 45000],
            ['category_id' => $catOlahraga, 'name' => 'Tas Pinggang Lari Waist Bag Waterproof', 'price' => 55000],
            ['category_id' => $catOlahraga, 'name' => 'Resistance Band Karet Latihan Otot', 'price' => 40000],
            ['category_id' => $catOlahraga, 'name' => 'Baju Lari Dry Fit Pria Menyerap Keringat', 'price' => 75000],
            ['category_id' => $catOlahraga, 'name' => 'Celana Training Jogger Pria Olahraga', 'price' => 110000],
            ['category_id' => $catOlahraga, 'name' => 'Jersey Sepeda Lengan Pendek Breathable', 'price' => 135000],
            ['category_id' => $catOlahraga, 'name' => 'Helm Sepeda Gunung MTB Standar Safety', 'price' => 210000],
            ['category_id' => $catOlahraga, 'name' => 'Sarung Tangan Gym Angkat Beban Anti Slip', 'price' => 60000],
            ['category_id' => $catOlahraga, 'name' => 'Kacamata Renang Anti Fog Embun Kaca Bening', 'price' => 85000],
            ['category_id' => $catOlahraga, 'name' => 'Raket Badminton Carbon Pro Ringan Kuat', 'price' => 350000],

            // KESEHATAN
            ['category_id' => $catKesehatan, 'name' => 'Masker Medis 3 Ply Sekali Pakai Isi 50', 'price' => 35000],
            ['category_id' => $catKesehatan, 'name' => 'Hand Sanitizer Gel Alkohol 70% 500ml', 'price' => 45000],
            ['category_id' => $catKesehatan, 'name' => 'Termometer Digital Gun Pengukur Suhu Cepat', 'price' => 120000],
            ['category_id' => $catKesehatan, 'name' => 'Oximeter Pengukur Kadar Oksigen Darah Jari', 'price' => 85000],
            ['category_id' => $catKesehatan, 'name' => 'Timbangan Badan Digital Kaca Kuat Akurat', 'price' => 95000],
            ['category_id' => $catKesehatan, 'name' => 'Alat Cek Gula Darah Asam Urat Kolesterol Set', 'price' => 250000],
            ['category_id' => $catKesehatan, 'name' => 'Vitamin C 1000mg Daya Tahan Tubuh Isi 30 Tablet', 'price' => 65000],
            ['category_id' => $catKesehatan, 'name' => 'Minyak Telon Anak Hangat Anti Nyamuk 150ml', 'price' => 40000],
            ['category_id' => $catKesehatan, 'name' => 'Minyak Kayu Putih Asli Murni 120ml', 'price' => 45000],
            ['category_id' => $catKesehatan, 'name' => 'Kotak P3K First Aid Kit Lengkap Portabel', 'price' => 150000],
            ['category_id' => $catKesehatan, 'name' => 'Alat Pijat Refleksi Elektrik Tengkuk Leher', 'price' => 185000],
            ['category_id' => $catKesehatan, 'name' => 'Korset Lumbar Penyangga Tulang Belakang Posisi', 'price' => 210000],
            ['category_id' => $catKesehatan, 'name' => 'Penyangga Bahu Shoulder Support Elastis Aman', 'price' => 145000],
            ['category_id' => $catKesehatan, 'name' => 'Obat Tetes Mata Kering Lelah Ringan Ampuh', 'price' => 25000],
            ['category_id' => $catKesehatan, 'name' => 'Plester Luka Anti Air Transparan Isi 100 Pcs', 'price' => 30000],
            ['category_id' => $catKesehatan, 'name' => 'Sabun Cuci Tangan Anti Bakteri Wangi Lembut', 'price' => 35000],
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
