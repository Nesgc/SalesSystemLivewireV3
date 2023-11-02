<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'add products']);
        Permission::create(['name' => 'edit products']);
        Permission::create(['name' => 'delete products']);
        Permission::create(['name' => 'add categories']);
        Permission::create(['name' => 'edit categories']);
        Permission::create(['name' => 'delete categories']);
        Permission::create(['name' => 'add denominations']);
        Permission::create(['name' => 'edit denominations']);
        Permission::create(['name' => 'delete denominations']);
        Permission::create(['name' => 'add users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'products index']);
        Permission::create(['name' => 'categories index']);
        Permission::create(['name' => 'denominatons index']);
        Permission::create(['name' => 'report index']);
        Permission::create(['name' => 'cashout index']);


        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'Employee']);
        $role->givePermissionTo('edit products');

        // or may be done by chaining
        $role = Role::create(['name' => 'Admin'])
            ->givePermissionTo(['edit categories', 'delete categories']);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
    }
}
