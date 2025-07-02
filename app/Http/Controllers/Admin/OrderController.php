<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
{
    $orders = Order::with(['user', 'transaction'])->latest()->paginate(10);

    return view('admin.orders.index', compact('orders'));
}

    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.menu'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function confirm($id)
{
    $order = Order::with('transaction')->findOrFail($id);

    // Update status order
    $order->update(['status' => 'success']);

    // Update status transaksi juga jika ada
    if ($order->transaction) {
        $order->transaction->status = 'success';
        $order->transaction->save();
    }

    return redirect()
        ->route('admin.orders.show', $order->id)
        ->with('success', 'Pesanan berhasil dikonfirmasi.');
}

}
