<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuStock;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Kopi Susu Gula Aren',
                'description' => 'Es kopi susu dengan gula aren asli pilihan.',
                'price' => 15000,
                'category' => 'Coffee',
                'is_active' => true,
            ],
            [
                'name' => 'Americano',
                'description' => 'Kopi hitam murni dari biji kopi arabika.',
                'price' => 12000,
                'category' => 'Coffee',
                'is_active' => true,
            ],
            [
                'name' => 'Kopi Matcha',
                'description' => 'Perpaduan espresso dan matcha premium.',
                'price' => 18000,
                'category' => 'Coffee',
                'is_active' => true,
            ],
            [
                'name' => 'Cokelat Klasik',
                'description' => 'Es cokelat lezat yang pas manisnya.',
                'price' => 15000,
                'category' => 'Non-Coffee',
                'is_active' => true,
            ],
            [
                'name' => 'Roti Bakar Keju',
                'description' => 'Roti bakar empuk dengan topping keju melimpah.',
                'price' => 10000,
                'category' => 'Snack',
                'is_active' => true,
            ]
        ];

        foreach ($menus as $item) {
            $menu = Menu::firstOrCreate(['name' => $item['name']], $item);

            // Buat default stok pusat untuk tiap menu (misalnya 100 pcs tiap menu)
            MenuStock::firstOrCreate(
                ['menu_id' => $menu->id],
                [
                    'current_stock' => 100,
                    'low_stock_threshold' => 20,
                ]
            );
        }
    }
}
