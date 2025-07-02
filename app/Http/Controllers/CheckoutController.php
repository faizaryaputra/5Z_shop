<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout.
     */
    public function showCheckout(Request $request)
    {
        $user = Auth::user();

        $order = Order::where('user_id', $user->id)
                      ->where('status', 'draft')
                      ->latest()
                      ->first();

        $paymentMethods = PaymentMethod::all();

        return view('user.checkout.show', compact('order', 'paymentMethods'));
    }

    /**
     * Simpan data order ke database dan arahkan ke halaman pembayaran.
     */
    public function confirmOrder(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang kosong.');
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // Simpan order
        $order = Order::create([
            'user_id'     => Auth::id(),
            'status'      => 'draft',
            'total_price' => $total,
            'kode_unik'   => strtoupper(Str::random(6)),
            'items'       => json_encode($cart), // jika masih pakai kolom items
        ]);

        // Simpan item ke tabel order_items
        foreach ($cart as $item) {
            $order->items()->create([
                'menu_item' => $item['menu_item'],
                'variant'   => $item['variant'] ?? null,
                'quantity'  => $item['quantity'],
                'price'     => $item['price'],
            ]);
        }

        session()->put('current_order_id', $order->id);

        return redirect()->route('user.payment.show');
    }

    /**
     * Tampilkan halaman pembayaran.
     */
    public function show()
    {
        $orderId = session('current_order_id');
        if (!$orderId) {
            return redirect()->route('home')->with('status', 'Tidak ada pesanan untuk ditampilkan.');
        }

        $order = Order::find($orderId);
        if (!$order) {
            return redirect()->route('home')->with('status', 'Pesanan tidak ditemukan.');
        }
$order->items = json_decode($order->items, true);
        $paymentMethods = PaymentMethod::all();

        // Ganti 'order' menjadi 'orderData' agar cocok dengan view
        return view('user.payment.show', [
            'orderData' => $order,
            'paymentMethods' => $paymentMethods,
        ]);
    }

    /**
     * Proses checkout: simpan transaksi dan hubungkan dengan order.
     */
    public function proceed(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'payment_method_id' => 'required|exists:payment_methods,id',
    ]);

    $user = Auth::user();

    $order = Order::find($request->order_id);

    if (!$order || $order->user_id !== $user->id) {
        return redirect()->route('home')->with('error', 'Pesanan tidak ditemukan.');
    }

    // Buat transaksi
    $transaction = Transaction::create([
        'user_id' => $user->id,
        'payment_method_id' => $request->payment_method_id,
        'total' => $order->total_price,
        'status' => 'menunggu_pembayaran',
    ]);

    // Update order dengan transaction_id
    $order->update([
        'transaction_id' => $transaction->id,
        'status' => 'menunggu_pembayaran',
    ]);

    // Bersihkan session jika pakai session cart
    session()->forget('cart');
    session()->forget('current_order_id');

    return redirect()->route('checkout.success', ['id' => $transaction->id]);
}
    /**
     * Halaman sukses setelah checkout.
     */
    public function success($id)
    {
        $transaction = Transaction::with('paymentMethod')->findOrFail($id);
        return view('user.payment.success', compact('transaction'));
    }
}
