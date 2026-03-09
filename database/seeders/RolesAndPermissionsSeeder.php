<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        Permission::firstOrCreate(['name' => 'create case']);
        Permission::firstOrCreate(['name' => 'view case']);
        Permission::firstOrCreate(['name' => 'update case']);
        Permission::firstOrCreate(['name' => 'delete case']);
        Permission::firstOrCreate(['name' => 'approve divorce']);
        Permission::firstOrCreate(['name' => 'reject divorce']);
        Permission::firstOrCreate(['name' => 'manage users']);
        Permission::firstOrCreate(['name' => 'manage roles']);

        // Create roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $judge = Role::firstOrCreate(['name' => 'judge']);
        $lawyer = Role::firstOrCreate(['name' => 'lawyer']);
        $citizen = Role::firstOrCreate(['name' => 'citizen']);

        // Assign permissions
        $admin->givePermissionTo(Permission::all());

        $judge->givePermissionTo([
            'view case',
            'approve divorce',
            'reject divorce',
        ]);

        $lawyer->givePermissionTo([
            'create case',
            'view case',
            'update case',
        ]);

        $citizen->givePermissionTo([
            'create case',
            'view case',
        ]);
    }
}


