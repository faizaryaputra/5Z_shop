@extends('layouts.admin')

@section('content')
<div class="p-6 space-y-6">
    <h2 class="text-2xl font-bold text-gray-800">📦 Daftar Pesanan</h2>

    <div class="bg-white rounded-xl shadow p-4 overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2">User</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $order->user->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td class="px-4 py-2">
  Subtotal: Rp{{ number_format($order->total_before_discount, 0, ',', '.') }} <br>
  Diskon: -Rp{{ number_format($order->discount, 0, ',', '.') }} <br>
  <strong>Total: Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong>
</td>

                    <td class="px-4 py-2">
        @php
            $status = $order->transaction->status ?? $order->status ?? 'draft';
            $badge = match(strtolower($status)) {
                'success', 'completed' => 'badge-success',
                'pending' => 'badge-warning',
                'failed', 'expired' => 'badge-danger',
                default => 'badge-secondary',
            };
        @endphp
        <span class="badge {{ $badge }}">{{ ucfirst($status) }}</span>
    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:underline">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-3 text-center text-gray-500">Belum ada pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
