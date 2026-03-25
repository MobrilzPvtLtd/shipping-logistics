<?php

namespace Modules\User\Database\Seeders;

use Modules\User\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        // Create super admin user
        $superAdmin = User::firstOrCreate(
            ['email' => env('DEMO_SUPERADMIN_EMAIL', 'superadmin@laracorekit.com')],
            [
                'name' => ' Super Admin',
                'password' => Hash::make(env('DEMO_SUPERADMIN_PASSWORD', 'password')),
                'email_verified_at' => now(),
            ]
        );

        if (class_exists(\Spatie\Permission\Models\Role::class)) {
            $superAdminRole = \Spatie\Permission\Models\Role::where('name', 'Super Admin')->first();
            if ($superAdminRole && !$superAdmin->hasRole('Super Admin')) {
                $superAdmin->assignRole('Super Admin');
            }
        }

        // Create admin user using `.env` values (fallback when not set)
        $admin = User::firstOrCreate(
            ['email' => env('DEMO_ADMIN_EMAIL', 'admin@laracorekit.com')],
            [
                'name' => ' Admin',
                'password' => Hash::make(env('DEMO_ADMIN_PASSWORD', 'password')),
                'email_verified_at' => now(),
            ]
        );

        // Assign Admin role if it exists
        if (class_exists(\Spatie\Permission\Models\Role::class)) {
            $adminRole = \Spatie\Permission\Models\Role::where('name', 'Admin')->first();
            if ($adminRole && !$admin->hasRole('Admin')) {
                $admin->assignRole('Admin');
            }
        }


        // Create warehouse staff user
        $warehouse = User::firstOrCreate(
            ['email' => env('DEMO_WAREHOUSE_EMAIL', 'warehouse@laracorekit.com')],
            [
                'name' => ' Warehouse Staff',
                'password' => Hash::make(env('DEMO_WAREHOUSE_PASSWORD', 'password')),
                'email_verified_at' => now(),
            ]
        );

        if (class_exists(\Spatie\Permission\Models\Role::class)) {
            $warehouseRole = \Spatie\Permission\Models\Role::where('name', 'Warehouse Staff')->first();
            if ($warehouseRole && !$warehouse->hasRole('Warehouse Staff')) {
                $warehouse->assignRole('Warehouse Staff');
            }
        }

        // Create regular user
        $user = User::firstOrCreate(
            ['email' => env('DEMO_USER_EMAIL', 'user@laracorekit.com')],
            [
                'name' => ' User',
                'password' => Hash::make(env('DEMO_USER_PASSWORD', 'password')),
                'email_verified_at' => now(),
            ]
        );

        if (class_exists(\Spatie\Permission\Models\Role::class)) {
            $userRole = \Spatie\Permission\Models\Role::where('name', 'User')->first();
            if ($userRole && !$user->hasRole('User')) {
                $user->assignRole('User');
            }
        }
    }
}
