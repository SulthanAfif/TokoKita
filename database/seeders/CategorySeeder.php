<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Elektronik', 'Fashion Pria', 'Fashion Wanita', 'Rumah Tangga', 'Olahraga', 'Kesehatan'];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
