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
            'name' => 'Courses',
            'image' => 'categories/CURSOS.png'
        ]);

        Category::create([
            'name' => 'Sneakers',
            'image' => 'categories/TENIS.png'
        ]);
        Category::create([
            'name' => 'Smartphones',
            'image' => 'categories/CELULARES.png'
        ]);
        Category::create([
            'name' => 'Computers',
            'image' => 'categories/COMPUTADORAS.png'
        ]);
    }
}
