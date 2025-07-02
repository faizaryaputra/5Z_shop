<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\Order;

class PaymentController extends Controller
{
    /**
     * Tampilkan daftar metode pembayaran, transaksi, dan pesanan terakhir.
     */
    public function index()
    {
        $user = auth()->user();
        $paymentMethods = PaymentMethod::all();
        $transactions = Transaction::where('user_id', $user->id)->latest()->get();
        $latestOrder = Order::where('user_id', $user->id)->latest()->first();

        return view('user.payment.form', compact('paymentMethods', 'transactions', 'latestOrder'));
    }

    /**
     * Simpan metode pembayaran baru untuk user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'payment_type' => 'required|string',
            'account_number' => 'required|string|max:30',
        ]);

        PaymentMethod::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'payment_type' => $request->payment_type,
            'account_number' => $request->account_number,
        ]);

        return back()->with('status', 'Metode pembayaran berhasil ditambahkan.');
    }

    /**
     * Upload bukti pembayaran.
     */
    public function uploadProof(Request $request)
    {
        $request->validate([
            'proof' => 'required|image|max:2048',
        ]);

        $path = $request->file('proof')->store('payment_proofs', 'public');

        $transaction = auth()->user()->transactions()->latest()->first();
        if ($transaction) {
            $transaction->update([
                'proof' => $path,
                'status' => 'pending',
            ]);
        }

        return back()->with('status', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi.');
    }

    /**
     * Tampilkan halaman checkout untuk order user yang belum dibayar.
     */
    public function showCheckout()
    {
        $user = auth()->user();

        $order = $user->orders()
            ->where('status', 'belum dibayar')
            ->with('items')
            ->latest()
            ->first();

        if (!$order) {
            return redirect()->route('menu.index')->with('status', 'Tidak ada pesanan yang perlu dibayar.');
        }

        $paymentMethods = PaymentMethod::where('user_id', $user->id)->get();
        $transactions = $user->transactions()->latest()->get();

        $orderData = [
        'items' => $order->items,
        'total_before_discount' => $order->total_before_discount,
        'discount' => $order->discount,
        'total_price' => $order->total_price,
        'id' => $order->id,
    ];
        return view('user.payment.show', compact('orderData', 'paymentMethods', 'transactions'));
    }

    public function checkout(Request $request)
    {
        $user = auth()->user();
        $cart = session('cart', []);
        $discountPercent = session('discount_percent', 0);

        if (empty($cart)) {
            return redirect()->route('user.cart')->with('error', 'Keranjang Anda kosong.');
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $discountTotal = ($total * $discountPercent) / 100;
        $finalTotal = $total - $discountTotal;

        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $finalTotal,
            'total_before_discount' => $total,
            'discount' => $discountTotal,
            'status' => 'pending',
        ]);

        foreach ($cart as $item) {
            $order->items()->create([
                'menu_item' => $item['menu_item'],
                'variant' => $item['variant'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'total_price' => $finalTotal,
            'status' => 'pending',
        ]);

        $order->update([
            'transaction_id' => $transaction->id,
            'total_price' => $finalTotal,
        ]);

        session()->forget(['cart', 'promo_code', 'discount_percent']);

        return redirect()->route('user.payment.form')->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');
    }

    /**
     * Proses pembayaran dan buat transaksi.
     */
    public function checkoutPay(Request $request)
{
    $request->validate([
        'order_id' => 'required',
        'payment_method_id' => 'required',
    ]);

    $order = auth()->user()->orders()->where('id', $request->order_id)->with('items')->firstOrFail();

    if ($order->transaction_id) {
        return redirect()->back()->with('error', 'Pesanan ini sudah memiliki transaksi.');
    }

    // Jika order belum memiliki data diskon (null), hitung ulang dari cart/session backup (jika ada)
    if (is_null($order->discount) || is_null($order->total_before_discount)) {
        $items = json_decode($order->items, true); // ubah ke array dari string JSON

$total = collect($items)->sum(function ($item) {
    return $item['price'] * $item['quantity'];
});

        $discountPercent = session('discount_percent', 0);
        $discountTotal = ($total * $discountPercent) / 100;
        $finalTotal = $total - $discountTotal;

        $order->update([
            'total_before_discount' => $total,
            'discount' => $discountTotal,
            'total_price' => $finalTotal,
        ]);
    }

    // Buat transaksi
    $transaction = Transaction::create([
        'user_id' => auth()->id(),
        'description' => 'Pembayaran pesanan #' . $order->id,
        'total_price' => $order->total_price,
        'status' => 'pending',
        'payment_method_id' => $request->payment_method_id,
    ]);

    // Update order
    $order->update([
        'transaction_id' => $transaction->id,
        'status' => 'menunggu pembayaran',
    ]);

    return redirect()->route('user.payment.show')->with('status', 'Silakan upload bukti pembayaran.');
}

    /**
     * Menampilkan halaman pembayaran dari order tertentu.
     */
    public function fromOrder(Order $order)
    {
        $order->load('items');
        $paymentMethods = PaymentMethod::all();

        return view('user.payment.show', [
            'order' => $order,
            'paymentMethods' => $paymentMethods,
        ]);
    }
}
