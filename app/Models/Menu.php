<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MenuCategory;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'image'];

    public function category()
{
    return $this->belongsTo(MenuCategory::class, 'menu_category_id');
}
}
