<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Menampilkan semua transaksi admin.
     */
    public function index()
    {
        $transactions = Transaction::with(['user', 'order'])->latest()->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Menampilkan detail satu transaksi.
     */
    public function show($id)
    {
        $transaction = Transaction::with(['user', 'order'])->findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Konfirmasi pembayaran transaksi.
     */
    public function confirm($id)
    {
        $transaction = Transaction::with('order')->findOrFail($id);

        // Update status transaksi
        $transaction->update([
            'status' => 'success',
        ]);

        // Tambahkan ini:
    if ($transaction->order) {
        $transaction->order->status = 'success';
        $transaction->order->save();
    }

        return redirect()
            ->route('admin.transactions.show', $transaction->id)
            ->with('success', 'Transaksi berhasil dikonfirmasi.');
    }
}
