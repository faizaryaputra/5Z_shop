@extends('layouts.admin')

@section('title', 'Detail Pengguna')

@section('content')
<div class="p-6 space-y-6">
    <h2 class="text-2xl font-bold mb-4">Detail Pengguna</h2>

    <div class="bg-white rounded shadow p-4">
        <h4 class="text-lg font-semibold text-gray-700 mb-2">Informasi Dasar</h4>
        <ul class="list-group">
            <li class="list-group-item"><strong>Nama:</strong> {{ $user->name }}</li>
            <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
            <li class="list-group-item"><strong>Dibuat pada:</strong> {{ $user->created_at->format('d M Y, H:i') }}</li>
        </ul>
    </div>

    <div class="bg-white rounded shadow p-4 mt-4">
        <h4 class="text-lg font-semibold text-gray-700 mb-2">Riwayat Transaksi</h4>
        @if($user->transactions && $user->transactions->count() > 0)
            <table class="table table-bordered mt-2">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->transactions as $trx)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>Rp{{ number_format($trx->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $trx->status == 'success' ? 'success' : 'warning' }}">
                                {{ ucfirst($trx->status) }}
                            </span>
                        </td>
                        <td>{{ $trx->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted">Belum ada transaksi.</p>
        @endif
    </div>
</div>
@endsection
