@extends('layouts.admin')

@section('title', 'Detail Transaksi')

@section('content')
<div class="p-6 space-y-6">
    <h2 class="text-2xl font-bold mb-4">Detail Transaksi</h2>

    <div class="bg-white rounded shadow p-4 space-y-2">
        <p><strong>ID Transaksi:</strong> {{ $transaction->id }}</p>
        <p><strong>Nama Pengguna:</strong> {{ $transaction->user->name ?? '-' }}</p>
        <p><strong>Email:</strong> {{ $transaction->user->email ?? '-' }}</p>
        <p><strong>Total Pembayaran:</strong> Rp{{ number_format($transaction->total_price, 0, ',', '.') }}</p>
        <p><strong>Status:</strong>
            <span class="badge bg-{{ $transaction->status == 'success' ? 'success' : 'warning' }}">
                {{ ucfirst($transaction->status) }}
            </span>
        </p>
        <p><strong>Tanggal Transaksi:</strong> {{ $transaction->created_at->format('d M Y, H:i') }}</p>
    </div>

    @if($transaction->proof)
        <div class="bg-white rounded shadow p-4 mt-4">
            <h4 class="text-lg font-semibold text-gray-700 mb-2">Bukti Pembayaran</h4>
            <img src="{{ asset('storage/' . $transaction->proof) }}" alt="Bukti Transfer" class="img-fluid rounded border">
        </div>
    @endif
    @if($transaction->status === 'pending')
    <form action="{{ route('admin.transactions.confirm', $transaction->id) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button>
    </form>
@endif
</div>
@endsection
