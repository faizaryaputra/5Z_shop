<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->get();
        return response()->json($menus);
    }
}