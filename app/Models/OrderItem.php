<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'menu_item',
        'variant',
        'quantity',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    // App\Models\OrderItem.php
public function menu()
{
    return $this->belongsTo(Menu::class, 'menu_id');
}

}
