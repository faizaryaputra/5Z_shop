<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Menu;
use App\Models\OrderItem;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::all();
        $menus = Menu::all();

        foreach ($orders as $order) {
            foreach ($menus->random(2) as $menu) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item' => $menu->name, // karena tidak ada menu_id
                    'variant' => 'reguler',
                    'quantity' => rand(1, 3),
                    'price' => $menu->price,
                ]);
            }
        }
    }
}
