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
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'PASSWORD' => bcrypt('admin')
        ]);
        User::create([
            'name' => 'Melissa Hall',
            'phone' => '785035355',
            'email' => 'melissah@gmail.com',
            'profile' => 'EMPLOYEE',
            'status' => 'ACTIVE',
            'PASSWORD' => bcrypt('123')
        ]);
    }
}
