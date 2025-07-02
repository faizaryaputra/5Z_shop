<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('orderItems.menu')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $request->user()->id,
                'status' => 'pending',
                'total_price' => 0 // akan dihitung di bawah
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $menu = Menu::find($item['menu_id']);
                $subtotal = $menu->price * $item['quantity'];
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'quantity' => $item['quantity'],
                    'price' => $menu->price
                ]);
                $total += $subtotal;
            }

            $order->update(['total_price' => $total]);
            DB::commit();

            return response()->json(['message' => 'Pesanan berhasil dibuat', 'order' => $order]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal membuat pesanan', 'details' => $e->getMessage()], 500);
        }
    }
}
