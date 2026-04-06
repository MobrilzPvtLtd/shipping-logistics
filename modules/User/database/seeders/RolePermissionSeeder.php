<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Modules\User\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
            'view-permissions',
            'view-blog',
            'create-blog',
            'edit-blog',
            'delete-blog',
            'publish-blog',
            'view-settings',
            'edit-settings',
            'view-media',
            'upload-media',
            'delete-media',
            'view-shipments',
            'create-shipments',
            'edit-shipments',
            'delete-shipments',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdminRole->syncPermissions(Permission::all());

        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->syncPermissions([
            'view-users',
            'create-users',
            'edit-users',
            'view-roles',
            'view-permissions',
            'view-blog',
            'create-blog',
            'edit-blog',
            'publish-blog',
            'view-settings',
            'edit-settings',
            'view-shipments',
            'create-shipments',
            'edit-shipments',
            'delete-shipments',
        ]);

        $warehouseRole = Role::firstOrCreate(['name' => 'Warehouse Staff']);
        $warehouseRole->syncPermissions([
            'view-blog',
            'view-media',
            'upload-media',
            'view-shipments',
            'create-shipments',
            'edit-shipments',
        ]);

        $userRole = Role::firstOrCreate(['name' => 'User']);
        $userRole->syncPermissions(['view-blog', 'view-shipments', 'create-shipments', 'edit-shipments', 'delete-shipments']);

        // Assign Admin role to existing admin user
        $admin = User::where('email', 'admin@laracorekit.com')->first();
        if ($admin) {
            $admin->assignRole('Admin');
        }
    }
}
