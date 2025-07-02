<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::all();

        foreach ($orders as $order) {
            Transaction::create([
    'user_id'     => $order->user_id,
    'order_id'    => $order->id,
    'total_price'      => $order->total_price,
    'status'      => 'success',
    'description' => 'Pembayaran untuk pesanan #' . $order->id,  // ✅ ini ditambahkan
]);
        }
    }
}
