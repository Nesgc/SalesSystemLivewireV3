<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Product::create([
            'name' => 'LARAVEL Y LIVEWIRE',
            'cost' => 200,
            'price' => 350,
            'barcode' => '750213211',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'products/laravellivewire.png'
        ]);
        Product::create([
            'name' => 'RUNNING NIKE',
            'cost' => 600,
            'price' => 1500,
            'barcode' => '750213212',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 2,
            'image' => 'products/runningnike.png'
        ]);
        Product::create([
            'name' => 'IPHONE 15',
            'cost' => 900,
            'price' => 1400,
            'barcode' => '750213213',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 3,
            'image' => 'products/iphone15.png'
        ]);
        Product::create([
            'name' => 'PC GAMER',
            'cost' => 790,
            'price' => 1700,
            'barcode' => '750213214',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 4,
            'image' => 'products/pcgamer.png'
        ]);
    }
}
