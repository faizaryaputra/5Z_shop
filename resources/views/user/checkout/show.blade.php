<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Checkout</title>
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

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-gray);
            padding: 2rem;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: var(--bg-white);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }

        h2, h3 {
            margin-bottom: 1rem;
        }

        .summary {
            margin-bottom: 2rem;
        }

        .summary p {
            margin: 0.5rem 0;
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
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: var(--primary-hover);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        th, td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
        }

        th {
            background-color: #f3f4f6;
            text-align: left;
        }

        .alert {
            background: #d1fae5;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 5px solid #10b981;
            color: #065f46;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>🧾 Checkout Pesanan</h2>

    @if (session('status'))
        <div class="alert">{{ session('status') }}</div>
    @endif

    {{-- Ringkasan Pesanan --}}
    <h3>Ringkasan</h3>
    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderData['items'] as $item)
                <tr>
                    <td>{{ $item['menu_item'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="3">Total</th>
                <td>Rp {{ number_format($orderData['total_price'], 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h3>Metode Pembayaran</h3>
    <form action="{{ route('checkout.confirm') }}" method="POST">
    @csrf
    <input type="hidden" name="order_id" value="{{ session('current_order_id') }}">

    <label for="payment_method">Pilih Metode:</label>
    <select name="payment_method_id" required>
        <option value="">-- Pilih Metode --</option>
        @foreach ($paymentMethods as $method)
            <option value="{{ $method->id }}">{{ $method->name }} - {{ $method->account_number }}</option>
        @endforeach
    </select>

    <button type="submit">Lanjutkan Pembayaran</button>
</form>

</div>
</body>
</html>
