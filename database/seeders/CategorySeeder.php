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
            'image' => 'categories/CURSOS.png'
        ]);

        Category::create([
            'name' => 'TENIS',
            'image' => 'categories/TENIS.png'
        ]);
        Category::create([
            'name' => 'CELULARES',
            'image' => 'categories/CELULARES.png'
        ]);
        Category::create([
            'name' => 'COMPUTADORAS',
            'image' => 'categories/COMPUTADORAS.png'
        ]);
    }
}
