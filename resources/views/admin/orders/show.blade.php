@extends('layouts.admin')

@section('content')
<div class="p-6 space-y-6">
    <h2 class="text-2xl font-bold text-gray-800">🧾 Detail Pesanan #{{ $order->id }}</h2>

    <div class="bg-white p-4 rounded-xl shadow space-y-3">
        <p><strong>User:</strong> {{ $order->user->name ?? '-' }}</p>
        <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
        <p><strong>Total Sebelum Diskon:</strong> Rp{{ number_format($order->total_before_discount, 0, ',', '.') }}</p>
<p><strong>Diskon:</strong> Rp{{ number_format($order->discount, 0, ',', '.') }}</p>
<p><strong>Total Akhir:</strong> Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->transaction->status ?? $order->status) }}</p>
    </div>

    <div class="bg-white p-4 rounded-xl shadow mt-4">
        <h3 class="font-semibold text-gray-700 mb-2">🧺 Item Pesanan</h3>
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-3 py-2">Menu</th>
                    <th class="px-3 py-2">Qty</th>
                    <th class="px-3 py-2">Harga</th>
                </tr>
            </thead>
            <tbody>
    @foreach($order->orderItems as $item)
    <tr class="border-b">
        <td class="px-3 py-2">
    {{ $item->menu_item }}<br>
    <small class="text-gray-500">{{ $item->variant }}</small>
</td>
        <td class="px-3 py-2">{{ $item->quantity }}</td>
        <td class="px-3 py-2">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
    </tr>
    @endforeach
</tbody>
        </table>
    </div>
</div>
@endsection
