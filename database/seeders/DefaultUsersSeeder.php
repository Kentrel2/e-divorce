<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DefaultUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Judge
        $judge = User::firstOrCreate(
            ['email' => 'judge@edivorce.com'],
            [
                'name' => 'Judge User',
                'password' => bcrypt('judge12345'),
            ]
        );
        $judge->assignRole('judge');

        // Lawyer
        $lawyer = User::firstOrCreate(
            ['email' => 'lawyer@edivorce.com'],
            [
                'name' => 'Lawyer User',
                'password' => bcrypt('lawyer12345'),
            ]
        );
        $lawyer->assignRole('lawyer');

        // Citizen
        $citizen = User::firstOrCreate(
            ['email' => 'citizen@edivorce.com'],
            [
                'name' => 'Citizen User',
                'password' => bcrypt('citizen12345'),
            ]
        );
        $citizen->assignRole('citizen');
    }
}
