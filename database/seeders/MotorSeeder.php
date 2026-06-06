<?php

namespace Database\Seeders;

use App\Models\Motor;
use Illuminate\Database\Seeder;

class MotorSeeder extends Seeder
{
    public function run(): void
    {
        $motors = [
            [
                'name' => 'Motor 1',
                'plate_number' => 'B 1234 ABC',
                'brand' => 'Yadea',
                'battery_capacity' => 72,
                'status' => 'available',
                'is_active' => true,
            ],
            [
                'name' => 'Motor 2',
                'plate_number' => 'B 5678 DEF',
                'brand' => 'Gesits',
                'battery_capacity' => 60,
                'status' => 'available',
                'is_active' => true,
            ],
            [
                'name' => 'Motor 3',
                'plate_number' => 'B 9012 GHI',
                'brand' => 'Alva One',
                'battery_capacity' => 45,
                'status' => 'available',
                'is_active' => true,
            ]
        ];

        foreach ($motors as $motor) {
            Motor::firstOrCreate(['plate_number' => $motor['plate_number']], $motor);
        }
    }
}
