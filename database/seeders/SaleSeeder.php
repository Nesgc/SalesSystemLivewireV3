<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\User;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtén los 4 usuarios por defecto (asegúrate de que existan en tu base de datos)
        $users = User::limit(4)->get();

        foreach ($users as $user) {
            // Genera ventas de ejemplo para cada usuario
            for ($i = 0; $i < 5; $i++) {
                Sale::create([
                    'total' => rand(50, 500),
                    'items' => rand(1, 10),
                    'cash' => rand(50, 500),
                    'change' => rand(0, 50),
                    'status' => 'PAID', // Puedes cambiar el estado según tus necesidades
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
