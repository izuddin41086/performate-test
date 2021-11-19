<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $Project["create"] = Permission::create(['name' => 'Create Project']);
        $Project["read"] = Permission::create(['name' => 'Read Project']);
        $Project["update"] = Permission::create(['name' => 'Update Project']);
        $Project["delete"] = Permission::create(['name' => 'Delete Project']);
        $Project["finish"] = Permission::create(['name' => 'Finishing Project']);

        $roleSuperadmin = Role::create(['name' => 'SuperAdmin']);
        $roleSuperadmin->givePermissionTo($Project["create"]);
        $roleSuperadmin->givePermissionTo($Project["read"]);
        $roleSuperadmin->givePermissionTo($Project["update"]);
        $roleSuperadmin->givePermissionTo($Project["delete"]);
        $roleSuperadmin->givePermissionTo($Project["finish"]);

        $roleSuperior = Role::create(['name' => 'Superior']);
        $roleSuperior->givePermissionTo($Project["finish"]);
        $roleSuperior->givePermissionTo($Project["read"]);

        $roleStaff = Role::create(['name' => 'Staff']);
        $roleStaff->givePermissionTo($Project["read"]);
    }
}
