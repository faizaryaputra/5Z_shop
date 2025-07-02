<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e1e1e1;
            padding: 2rem;
        }

        .cart-container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
        }

        th, td {
            padding: 0.75rem;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        .summary {
            font-size: 1.1rem;
            text-align: right;
            margin-top: 1rem;
        }

        .summary p {
            margin: 0.25rem 0;
        }

        .actions {
            text-align: center;
            margin-top: 1.5rem;
        }

        .btn {
            background: #212121;
            color: #fff;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #00c8ff;
        }

        .empty {
            text-align: center;
            font-size: 1.2rem;
            padding: 2rem;
        }
    </style>
</head>
<body>
<div class="cart-container">
    <h2>🛒 Keranjang Belanja</h2>

    @if (session('cart') && count(session('cart')) > 0)
        <table>
<thead>
    <tr>
        <th>Menu</th>
        <th>Varian</th>
        <th>Jumlah</th>
        <th>Harga Satuan</th>
        <th>Total</th>
        <th>Aksi</th> <!-- Tambahkan kolom -->
    </tr>
</thead>
<tbody>
    @php $subtotal = 0; @endphp
    @foreach (session('cart') as $index => $item)
        @php
            $total = $item['price'] * $item['quantity'];
            $subtotal += $total;
        @endphp
        <tr>
            <td>{{ $item['menu_item'] }}</td>
            <td>{{ $item['variant'] }}</td>
            <td>{{ $item['quantity'] }}</td>
            <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
            <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
            <td>
                <form action="{{ route('cart.remove', $index) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="background: crimson;">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
        </table>

        @php
            $discountPercent = session('discount_percent', 0);
            $discountAmount = ($discountPercent > 0) ? $subtotal * $discountPercent / 100 : 0;
            $grandTotal = $subtotal - $discountAmount;
        @endphp

        <div class="summary">
            <p><strong>Subtotal:</strong> Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
            @if ($discountPercent > 0)
                <p><strong>Diskon ({{ $discountPercent }}%):</strong> -Rp {{ number_format($discountAmount, 0, ',', '.') }}</p>
            @endif
            <p><strong>Total:</strong> Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
        </div>

        <div class="actions">
  <form action="{{ route('checkout.confirm') }}" method="POST">
    @csrf
    <input type="hidden" name="total_price" value="{{ $total }}">
    @foreach ($cart as $index => $item)
        <input type="hidden" name="items[{{ $index }}][name]" value="{{ $item['menu_item'] }}">
        <input type="hidden" name="items[{{ $index }}][variant]" value="{{ $item['variant'] ?? '-' }}">
        <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item['quantity'] }}">
        <input type="hidden" name="items[{{ $index }}][price]" value="{{ $item['price'] }}">
    @endforeach
    <button type="submit" class="btn">Lanjut ke Pembayaran</button>
</form>
        </div>
    @else
        <div class="empty">
            Keranjang kamu kosong 😢<br><br>
            <a href="{{ route('home') }}" class="btn">Cari Menu</a>
        </div>
    @endif
</div>
</body>
</html>
