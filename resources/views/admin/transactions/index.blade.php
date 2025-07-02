@extends('layouts.admin')

@section('title', 'Manajemen Transaksi')

@section('content')
<div class="p-6 space-y-6">
    <h2 class="text-2xl font-bold mb-4">Riwayat Transaksi</h2>

    <table class="table table-bordered bg-white rounded shadow">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $trx)
            <tr>
                <td>{{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}</td>
                <td>{{ $trx->user->name ?? '—' }}</td>
                <td>Rp{{ number_format($trx->total_price, 0, ',', '.') }}</td>
                <td>
                    <span class="badge bg-{{ $trx->status == 'success' ? 'success' : 'warning' }}">
                        {{ ucfirst($trx->status) }}
                    </span>
                </td>
                <td>{{ $trx->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.transactions.show', $trx->id) }}" class="btn btn-sm btn-info">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $transactions->links() }}
</div>
@endsection
