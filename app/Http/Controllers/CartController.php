<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function add(Request $request)
{
    $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

    $item = $cart->items()->where('menu_id', $request->menu_id)->first();
    if ($item) {
        $item->increment('quantity', $request->quantity);
    } else {
        $cart->items()->create([
            'menu_id' => $request->menu_id,
            'quantity' => $request->quantity,
        ]);
    }

    return redirect()->route('user.cart.show')->with('success', 'Ditambahkan ke keranjang!');
}

public function show()
{
    $cart = Cart::where('user_id', auth()->id())->with('items.menu')->first();
    return view('user.cart.index', compact('cart'));
}

public function remove($index)
{
    $cart = session('cart', []);

    if (isset($cart[$index])) {
        unset($cart[$index]);
        $cart = array_values($cart); // reset index agar tidak lompat
        session(['cart' => $cart]);
    }

    return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
}
}
