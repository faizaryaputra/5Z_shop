<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Order::create([
    'user_id' => 1,
    'total_price' => 50000,
    'status' => 'completed',
]);
        }
    }
}
