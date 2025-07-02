<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Pembayaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --bg-light: #f9fafb;
            --bg-white: #ffffff;
            --border: #e5e7eb;
            --text-gray: #374151;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-gray);
            padding: 2rem;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: var(--bg-white);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }

        h2, h3 {
            margin-bottom: 1rem;
        }

        form {
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 0.5rem;
        }

        input, select {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            border: 1px solid var(--border);
            border-radius: 0.5rem;
        }

        button {
            padding: 0.75rem 1.5rem;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: var(--primary-hover);
        }

        .alert {
            background-color: #d1fae5;
            color: #065f46;
            padding: 1rem;
            border-left: 5px solid #10b981;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .error {
            color: red;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            text-align: left;
            padding: 1rem;
            border-bottom: 1px solid var(--border);
        }

        th {
            background-color: #f3f4f6;
        }

        .badge {
            padding: 0.3rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.8rem;
            color: white;
            font-weight: bold;
        }

        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-danger  { background-color: #dc3545; }
        .badge-secondary { background-color: #6c757d; }

        .payment-info ul {
            padding-left: 1rem;
            margin-bottom: 2rem;
        }

        .payment-info img {
            margin-top: 1rem;
            max-width: 150px;
            border-radius: 0.5rem;
            border: 1px solid var(--border);
        }

        @media (max-width: 640px) {
            body {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
<div class="container">

    <h2>🧾 Simpan Metode Pembayaran</h2>

    @if (session('status'))
        <div class="alert">{{ session('status') }}</div>
    @endif

    <form action="{{ route('user.payment.store') }}" method="POST" id="paymentForm">
        @csrf
        <div class="form-group">
            <label for="payment_type">Jenis Pembayaran</label>
            <select name="payment_type" required>
                <option value="">-- Pilih --</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="E-Wallet">E-Wallet</option>
                <option value="Kartu Kredit">Kartu Kredit</option>
            </select>
            @error('payment_type')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="account_number">Nomor Rekening / Akun</label>
            <input type="text" name="account_number" required minlength="5">
            @error('account_number')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit">Simpan Metode</button>
    </form>
    <h2>💳 Riwayat Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $tx)
                <tr>
                    <td>{{ $tx->description }}</td>
                    <td>Rp {{ number_format($tx->total_price, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $badge = match(strtolower($tx->status)) {
                                'completed' => 'badge-success',
                                'pending' => 'badge-warning',
                                'failed', 'expired' => 'badge-danger',
                                default => 'badge-secondary'
                            };
                        @endphp
                        <span class="badge {{ $badge }}">{{ ucfirst($tx->status) }}</span>
                    </td>
                    <td>{{ $tx->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
