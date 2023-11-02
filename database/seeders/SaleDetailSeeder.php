<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\Sale;

class SaleDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtén todas las ventas de ejemplo creadas previamente
        $sales = Sale::all();

        // Obtén todos los productos (asegúrate de que existan en tu base de datos)
        $products = Product::all();


        SaleDetail::create([
            'price' => 1050,
            'quantity' => 1,
            'sale_id' => 1,
            'product_id' => 1,
        ]);
        SaleDetail::create([
            'price' => 6000,
            'quantity' => 1,
            'sale_id' => 2,
            'product_id' => 2,
        ]);
        SaleDetail::create([
            'price' => 1050,
            'quantity' => 1,
            'sale_id' => 3,
            'product_id' => 1,
        ]);
        SaleDetail::create([
            'price' => 6000,
            'quantity' => 1,
            'sale_id' => 4,
            'product_id' => 2,
        ]);
        SaleDetail::create([
            'price' => 1050,
            'quantity' => 1,
            'sale_id' => 5,
            'product_id' => 1,
        ]);
        SaleDetail::create([
            'price' => 6000,
            'quantity' => 1,
            'sale_id' => 6,
            'product_id' => 2,
        ]);
        SaleDetail::create([
            'price' => 1050,
            'quantity' => 1,
            'sale_id' => 7,
            'product_id' => 1,
        ]);
        SaleDetail::create([
            'price' => 6000,
            'quantity' => 1,
            'sale_id' => 8,
            'product_id' => 2,
        ]);
    }
}
