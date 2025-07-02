<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function user()
{
    return $this->belongsTo(User::class);
}

// App\Models\Transaction.php
public function order()
{
    return $this->hasOne(Order::class, 'transaction_id');
}

protected $fillable = [
    'user_id',
    'order_id',
    'description',
    'total_price', 
    'status',
    'proof',
];

}
