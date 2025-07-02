<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::create(['name' => 'Kopi Hitam', 'price' => 15000]);
        Menu::create(['name' => 'Cappuccino', 'price' => 20000]);
        Menu::create(['name' => 'Latte', 'price' => 18000]);
        Menu::create(['name' => 'Teh Tarik', 'price' => 12000]);
        Menu::create(['name' => 'Air Mineral', 'price' => 5000]);
    }
}
