<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderNotification;
use App\Http\Controllers\WhatsAppController;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->get();
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.menu_item' => 'required|string',
            'items.*.variant' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'promo' => 'nullable|string'
        ]);

        $cart = session()->get('cart', []);

        foreach ($validated['items'] as $item) {
            $cart[] = [
                'menu_item' => $item['menu_item'],
                'variant' => $item['variant'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ];
        }

        session(['cart' => $cart]);

        $promoCode = strtoupper(trim($request->input('promo')));
        $discount = 0;

        if ($promoCode === 'DISKON10') {
            $discount = 10;
        }

        session([
            'promo_code' => $promoCode,
            'discount_percent' => $discount
        ]);

        return redirect()->route('user.cart')->with('success', 'Item dan promo berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,canceled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('orders.index')->with('success', 'Order status updated!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }

    public function create(Request $request)
    {
        $menuName = urldecode($request->input('menu'));

        $menuVariants = [
            'Hot Coffe' => [
                ['name' => 'Americano', 'price' => 20000],
                ['name' => 'Espresso', 'price' => 18000],
                ['name' => 'Cappuccino', 'price' => 25000],
                ['name' => 'Cafe Latte', 'price' => 25000],
                ['name' => 'Mochaccino', 'price' => 28000],
                ['name' => 'Caramel Macchiato', 'price' => 30000],
            ],
            'Cold Coffe' => [
                ['name' => 'Iced Americano', 'price' => 22000],
                ['name' => 'Iced Cafe Latte', 'price' => 25000],
                ['name' => 'Iced Cappucino', 'price' => 26000],
                ['name' => 'Iced Mochaccino', 'price' => 28000],
                ['name' => 'Iced Cafe Hazelnut', 'price' => 26000],
                ['name' => 'Cold Brew', 'price' => 30000],
            ],
            'Dessert' => [
                ['name' => 'Chocolate Lava Cake', 'price' => 28000],
                ['name' => 'Tiramisu in Cup', 'price' => 30000],
                ['name' => 'Pudding Regal', 'price' => 18000],
                ['name' => 'Mango Sticky Rice', 'price' => 25000],
                ['name' => 'Matcha Panna Cotta', 'price' => 22000],
            ],
            'Food' => [
                ['name' => 'Chicken Teriyaki Rice', 'price' => 35000],
                ['name' => 'Beef Bulgogi Bowl', 'price' => 42000],
                ['name' => 'Spaghetti Aglio Olio', 'price' => 33000],
                ['name' => 'Nasi Ayam Sambal Matah', 'price' => 30000],
                ['name' => 'Thai Basil Chicken', 'price' => 38000],
            ],
            'Bread & Pastry' => [
                ['name' => 'Croissant Butter', 'price' => 15000],
                ['name' => 'Pain au Chocolat', 'price' => 18000],
                ['name' => 'Cinnamon Roll', 'price' => 20000],
                ['name' => 'Cheese Danish', 'price' => 17000],
                ['name' => 'Banana Bread Slice', 'price' => 12000],
            ],
            'Other Drink' => [
                ['name' => 'Chocolate Frappe', 'price' => 28000],
                ['name' => 'Matcha Latte', 'price' => 26000],
                ['name' => 'Strawberry Yakult', 'price' => 24000],
                ['name' => 'Mango Smoothie', 'price' => 27000],
                ['name' => 'Taro Milk', 'price' => 25000],
            ],
        ];

        $variants = $menuVariants[$menuName] ?? [];
        $allMenus = array_keys($menuVariants);

        return view('orders.create', compact('menuName', 'variants', 'allMenus'));
    }

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('user.cart', compact('cart'));
    }

    public function removeFromCart($index)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$index])) {
            unset($cart[$index]);
            session()->put('cart', array_values($cart));
        }
        return redirect()->route('user.cart')->with('success', 'Item berhasil dihapus.');
    }
}
