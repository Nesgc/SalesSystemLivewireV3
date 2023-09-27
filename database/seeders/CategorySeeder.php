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
            'image' => 'https://dummyimage.com/400x300/f20323/ffffff.jpg&text=CURSOS'
        ]);
        
        Category::create([
            'name' => 'TENIS',
            'image' => 'https://dummyimage.com/400x300/f20323/ffffff.jpg&text=TENIS'
        ]);
        Category::create([
            'name' => 'CELULARES',
            'image' => 'https://dummyimage.com/400x300/f20323/ffffff.jpg&text=CELULARES'
        ]);
        Category::create([
            'name' => 'COMPUTADORAS',
            'image' => 'https://dummyimage.com/400x300/f20323/ffffff.jpg&text=COMPUTADORAS'
        ]);
    }
}
