<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
{
    PaymentMethod::insert([
        [
            'user_id' => 1,
            'name' => 'BCA',
            'account_number' => '1234567890',
        ],
        [
            'user_id' => 1,
            'name' => 'Gopay',
            'account_number' => '08123456789',
        ],
        [
            'user_id' => 1,
            'name' => 'OVO',
            'account_number' => '08198765432',
        ],
    ]);
}
}