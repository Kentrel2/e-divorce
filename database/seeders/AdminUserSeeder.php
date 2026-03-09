<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@edivorce.com'],
            [
                'name' => 'System Admin',
                'password' => bcrypt('admin12345'),
            ]
        );

        $admin->assignRole('admin');
    }
}


