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

        //create permission to profile
        Permission::create(['name' => 'create profile']);
        Permission::create(['name' => 'reload profile']);
        Permission::create(['name' => 'update profile']);
        Permission::create(['name' => 'delete profile']);
        //create permission to navigate
        Permission::create(['name' => 'view navigate role']);
        //create permission to role
        Permission::create(['name' => 'read role']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'update role']);
        Permission::create(['name' => 'delete role']);
        Permission::create(['name' => 'restore role']);
        Permission::create(['name' => 'forceDelete role']);
        //create permission to permission
        Permission::create(['name' => 'create permission']);
        Permission::create(['name' => 'read permission']);
        Permission::create(['name' => 'update permission']);
        Permission::create(['name' => 'delete permission']);
        Permission::create(['name' => 'restore permission']);
        Permission::create(['name' => 'forceDelete permission']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'common']);
        $role->givePermissionTo('update profile');

        // or may be done by chaining
        $role = Role::create(['name' => 'manager'])
            ->givePermissionTo(['create profile', 'reload profile', 'update profile']);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(['create profile', 'reload profile', 'update profile', 'delete profile']);
        //Sass-super-admin
        $role = Role::create(['name' => 'saas-super-admin']);
        $role->givePermissionTo(Permission::all());
    }
}
