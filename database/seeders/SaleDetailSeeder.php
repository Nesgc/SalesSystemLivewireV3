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

        foreach ($sales as $sale) {
            // Genera detalles de venta de ejemplo para cada venta
            for ($i = 0; $i < 3; $i++) {
                SaleDetail::create([
                    'price' => rand(10, 100),
                    'quantity' => rand(1, 5),
                    'sale_id' => $sale->id,
                    'product_id' => $products->random()->id, // Asigna un producto aleatorio a la venta
                ]);
            }
        }
    }
}
