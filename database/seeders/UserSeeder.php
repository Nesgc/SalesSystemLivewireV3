<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'Nes GC',
            'phone' => '2333035355',
            'email' => 'nesgc@gmail.com',
            'role' => 'Admin',
            'status' => 'ACTIVE',
            'password' => bcrypt('admin'),
            'image' => 'users/mapache.jpg'
        ]);
        User::create([
            'name' => 'Melissa Hall',
            'phone' => '785035355',
            'email' => 'melissah@gmail.com',
            'role' => 'Employee',
            'status' => 'ACTIVE',
            'password' => bcrypt('123')
        ]);
    }
}
