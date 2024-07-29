<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'read user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);

        $role = Role::whereName('common')->first();
        $role->givePermissionTo('read user');

        $role = Role::whereName('manager')->first();
        $role->givePermissionTo(['create user', 'read user', 'update user']);

        $role = Role::whereName('super-admin')->first();
        $role->givePermissionTo(['create user', 'read user', 'update user','delete user']);

        $role = Role::whereName('saas-super-admin')->first();
        $role->givePermissionTo(['create user', 'read user', 'update user','delete user']);
    }
}
