<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Admin default
        User::firstOrCreate(
            ['email' => 'admin@kopiajoe.com'],
            [
                'name' => 'Admin Kopi Ajoe',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Manager default
        User::firstOrCreate(
            ['email' => 'manager@kopiajoe.com'],
            [
                'name' => 'Manager Operasional',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'is_active' => true,
            ]
        );

        // Seller default
        User::firstOrCreate(
            ['email' => 'seller@kopiajoe.com'],
            [
                'name' => 'Seller Satu',
                'password' => Hash::make('password'),
                'role' => 'seller',
                'base_salary' => 50000,
                'commission_rate' => 10, // 10%
                'is_active' => true,
            ]
        );
    }
}
