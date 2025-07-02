<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'total_price',
    'total_before_discount',
    'discount',
    'status',
    'items',
    'transaction_id',
];

    protected $casts = [
        'items' => 'array',
    ];

    public function items()
{
    return $this->hasMany(OrderItem::class);
}

    public function user()
    {
        return $this->belongsTo(User::class);
    }   

// Order.php
// App\Models\Order.php
public function transaction()
{
    return $this->belongsTo(Transaction::class, 'transaction_id');
}



public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

}
