<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class DeliveryController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->delivery_status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Delivery status updated successfully!');
    }
}
