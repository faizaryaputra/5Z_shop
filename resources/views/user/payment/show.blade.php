<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Pesanan</title>
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

    <h2>🛒 Konfirmasi & Pembayaran Pesanan</h2>

    @if (session('status'))
        <div class="alert">{{ session('status') }}</div>
    @endif

    @php
    $cart = session('cart', []);
    $discountPercent = session('discount_percent', 0);
    $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    $discountAmount = ($discountPercent > 0) ? ($subtotal * $discountPercent / 100) : 0;
    $grandTotal = $subtotal - $discountAmount;
@endphp

<h3>📋 Detail Pesanan</h3>
<table>
    <thead>
        <tr>
            <th>Menu</th>
            <th>Varian</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cart as $item)
            <tr>
                <td>{{ $item['menu_item'] }}</td>
                <td>{{ $item['variant'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr>
            <th colspan="4">Subtotal</th>
            <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
        </tr>
        @if ($discountAmount > 0)
        <tr>
            <th colspan="4">Diskon ({{ $discountPercent }}%)</th>
            <td>Rp -{{ number_format($discountAmount, 0, ',', '.') }}</td>
        </tr>
        @endif
        <tr>
            <th colspan="4">Total Akhir</th>
            <td><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
        </tr>
    </tbody>
</table>

    {{-- Form Pilih Metode Pembayaran --}}
    <h3>💳 Pilih Metode Pembayaran</h3>
    <form action="{{ route('checkout.pay') }}" method="POST">
        @csrf
<input type="hidden" name="order_id" value="{{ $orderData['id'] ?? '' }}">
        <div class="form-group">
            <label for="payment_method">Metode Pembayaran:</label>
            <select name="payment_method_id" id="payment_method" class="form-control" required>
                <option value="">-- Pilih Metode --</option>
                @foreach($paymentMethods as $method)
                    <option value="{{ $method->id }}">{{ $method->name }} - {{ $method->account_number }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Lanjutkan Pembayaran</button>
    </form>

    {{-- Informasi Pembayaran --}}
    <div class="payment-info mt-4">
        <h3>📌 Transfer ke:</h3>
        <ul>
            <li><strong>Bank BCA:</strong> 1234567890 a.n. PT Contoh</li>
            <li><strong>OVO:</strong> 0812-xxxx-xxxx a.n. Admin Contoh</li>
            <li><strong>QRIS:</strong></li>
            <li><img src="{{ asset('img/qris.png') }}" alt="QRIS" width="200"></li>
        </ul>
    </div>

    {{-- Upload Bukti Transfer --}}
    <h3 class="mt-4">📤 Upload Bukti Transfer</h3>
    <form action="{{ route('user.payment.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="proof" accept="image/*" required>
        @error('proof')
            <div class="error text-danger">{{ $message }}</div>
        @enderror
        <br><br>
        <button type="submit" class="btn btn-success">Upload Bukti</button>
    </form>

</div>
</body>
</html>
