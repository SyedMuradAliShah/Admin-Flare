<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminPermissionSeeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'view:admin', 'guard_name' => 'admin', 'protected' => true],
            ['name' => 'create:admin', 'guard_name' => 'admin', 'protected' => true],
            ['name' => 'update:admin', 'guard_name' => 'admin', 'protected' => true],
            ['name' => 'delete:admin', 'guard_name' => 'admin', 'protected' => true],

            ['name' => 'view:admin-role-permission', 'guard_name' => 'admin', 'protected' => true],
            ['name' => 'create:admin-role-permission', 'guard_name' => 'admin', 'protected' => true],
            ['name' => 'update:admin-role-permission', 'guard_name' => 'admin', 'protected' => true],
            ['name' => 'delete:admin-role-permission', 'guard_name' => 'admin', 'protected' => true],

            // ['name' => 'view:blogs', 'guard_name'=>'admin'],
            // ['name' => 'create:blogs', 'guard_name'=>'admin'],
            // ['name' => 'update:blogs', 'guard_name'=>'admin'],
            // ['name' => 'delete:blogs', 'guard_name'=>'admin'],

            // ['name' => 'view:blog-categories', 'guard_name'=>'admin'],
            // ['name' => 'create:blog-categories', 'guard_name'=>'admin'],
            // ['name' => 'update:blog-categories', 'guard_name'=>'admin'],
            // ['name' => 'delete:blog-categories', 'guard_name'=>'admin'],

            // ['name' => 'view:blog-tags', 'guard_name'=>'admin'],
            // ['name' => 'create:blog-tags', 'guard_name'=>'admin'],
            // ['name' => 'update:blog-tags', 'guard_name'=>'admin'],
            // ['name' => 'delete:blog-tags', 'guard_name'=>'admin'],

            // ['name' => 'view:pages', 'guard_name'=>'admin'],
            // ['name' => 'create:pages', 'guard_name'=>'admin'],
            // ['name' => 'update:pages', 'guard_name'=>'admin'],
            // ['name' => 'delete:pages', 'guard_name'=>'admin'],

            // ['name' => 'view:languages', 'guard_name'=>'admin'],
            // ['name' => 'create:languages', 'guard_name'=>'admin'],
            // ['name' => 'update:languages', 'guard_name'=>'admin'],
            // ['name' => 'delete:languages', 'guard_name'=>'admin'],

            // ['name' => 'view:translations', 'guard_name'=>'admin'],
            // ['name' => 'create:translations', 'guard_name'=>'admin'],
            // ['name' => 'update:translations', 'guard_name'=>'admin'],
            // ['name' => 'delete:translations', 'guard_name'=>'admin'],

            // ['name' => 'view:users', 'guard_name'=>'admin'],
            // ['name' => 'create:users', 'guard_name'=>'admin'],
            // ['name' => 'update:users', 'guard_name'=>'admin'],
            // ['name' => 'delete:users', 'guard_name'=>'admin'],

            // ['name' => 'view:user-roles', 'guard_name'=>'admin'],
            // ['name' => 'create:user-roles', 'guard_name'=>'admin'],
            // ['name' => 'update:user-roles', 'guard_name'=>'admin'],
            // ['name' => 'delete:user-roles', 'guard_name'=>'admin'],

            // ['name' => 'view:user-permissions', 'guard_name'=>'admin'],
            // ['name' => 'create:user-permissions', 'guard_name'=>'admin'],
            // ['name' => 'update:user-permissions', 'guard_name'=>'admin'],
            // ['name' => 'delete:user-permissions', 'guard_name'=>'admin'],

            // ['name' => 'view:menus', 'guard_name'=>'admin'],
            // ['name' => 'create:menus', 'guard_name'=>'admin'],
            // ['name' => 'update:menus', 'guard_name'=>'admin'],
            // ['name' => 'delete:menus', 'guard_name'=>'admin'],

            ['name' => 'view:settings', 'guard_name' => 'admin'],
            ['name' => 'update:settings', 'guard_name' => 'admin'],
        ];

        // Loop through each permission and use updateOrCreate to avoid duplicates
        foreach ($permissions as $permission) {
            Permission::query()->updateOrCreate(['name' => $permission['name'], 'guard_name' => $permission['guard_name'], 'protected' => $permission['protected'] ?? false]);
        }

        // Create or update the role 'super-admin'
        $adminRole = Role::query()->updateOrCreate(['name' => 'administrator', 'guard_name' => 'admin', 'protected' => true]);

        // Assign all created permissions to the super-admin role
        $adminRole->givePermissionTo(Permission::query()->where('guard_name', 'admin')->get());

        // $adminRole->givePermissionTo($createdPermissions);
    }
}
