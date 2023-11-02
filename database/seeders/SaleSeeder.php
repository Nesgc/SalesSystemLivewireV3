<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\User;
use App\Models\SaleDetail;
use App\Models\Product;
use Illuminate\Support\Str;


class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {


        // Crear venta

        Sale::create([
            'total' => 1050,
            'items' => 3,
            'cash' => 2000,
            'change' => 950,
            'status' => 'PAID',
            'user_id' => 1,
        ]);
        Sale::create([
            'total' => 6000,
            'items' => 4,
            'cash' => 9000,
            'change' => 3000,
            'status' => 'PAID',
            'user_id' => 1,
        ]);
        Sale::create([
            'total' => 1050,
            'items' => 3,
            'cash' => 2000,
            'change' => 950,
            'status' => 'PAID',
            'user_id' => 2,
        ]);
        Sale::create([
            'total' => 6000,
            'items' => 4,
            'cash' => 9000,
            'change' => 3000,
            'status' => 'PAID',
            'user_id' => 2,
        ]);
        Sale::create([
            'total' => 1050,
            'items' => 3,
            'cash' => 2000,
            'change' => 950,
            'status' => 'PAID',
            'user_id' => 3,
        ]);
        Sale::create([
            'total' => 6000,
            'items' => 4,
            'cash' => 9000,
            'change' => 3000,
            'status' => 'PAID',
            'user_id' => 3,
        ]);
        Sale::create([
            'total' => 1050,
            'items' => 3,
            'cash' => 2000,
            'change' => 950,
            'status' => 'PAID',
            'user_id' => 4,
        ]);
        Sale::create([
            'total' => 6000,
            'items' => 4,
            'cash' => 9000,
            'change' => 3000,
            'status' => 'PAID',
            'user_id' => 4,
        ]);
    }
}
