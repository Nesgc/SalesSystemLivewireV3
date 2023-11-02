<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AssignRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['model_id' => 1, 'role_id' => 3, 'model_type' => 'App\Models\User'],
            ['model_id' => 2, 'role_id' => 3, 'model_type' => 'App\Models\User'],
            ['model_id' => 3, 'role_id' => 3, 'model_type' => 'App\Models\User'],
            ['model_id' => 4, 'role_id' => 3, 'model_type' => 'App\Models\User'],
            ['model_id' => 5, 'role_id' => 1, 'model_type' => 'App\Models\User'],
        ];

        DB::table('model_has_roles')->insert($data);
    }
}
