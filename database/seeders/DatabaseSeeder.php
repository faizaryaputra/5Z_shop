<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\MenuSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\OrderItemSeeder;
use Database\Seeders\TransactionSeeder;
use Database\Seeders\PaymentMethodSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MenuSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            TransactionSeeder::class,
            PaymentMethodSeeder::class,
        ]);
    }
}
