<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'create profile']);
        Permission::create(['name' => 'reload profile']);
        Permission::create(['name' => 'update profile']);
        Permission::create(['name' => 'delete profile']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'common']);
        $role->givePermissionTo('update profile');

        // or may be done by chaining
        $role = Role::create(['name' => 'manager'])
            ->givePermissionTo(['create profile', 'reload profile', 'update profile']);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
    }
}
