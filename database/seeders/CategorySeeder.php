<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Category::create([
            'name' => 'CURSOS',
            'image' => 'CURSOS.png'
        ]);

        Category::create([
            'name' => 'TENIS',
            'image' => 'TENIS.png'
        ]);
        Category::create([
            'name' => 'CELULARES',
            'image' => 'CELULARES.png'
        ]);
        Category::create([
            'name' => 'COMPUTADORAS',
            'image' => 'COMPUTADORAS.png'
        ]);
    }
}
