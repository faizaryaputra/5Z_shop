<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah ke Keranjang - {{ ucfirst($menuName) }}</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
            text-decoration: none; list-style: none;
            resize: none; outline: none; border: none;
        }
        :root {
            --color-bg: #e1e1e1;
            --color-text: #212121;
            --color-primary: linear-gradient(45deg, #ff6600, #00c8ff);
            --color-secondary: linear-gradient(45deg, #e65c00, #0099cc); 
            --color-tertiary: rgb(0, 200, 255);
            --shadow: 6px 6px 12px #bababa, -6px -6px 12px #ffffff;
            --inner-shadow: inset 6px 6px 12px #bababa, inset -6px -6px 12px #ffffff;
            --transition: all 0.4s ease-in;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: var(--color-bg);
            color: var(--color-text);
            padding: 2rem;
        }

        .main-layout {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2rem;
    padding: 2rem;
}

        .order-form-container {
            flex: 1 1 400px;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .order-form-container h2 {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--color-text);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        #total-price {
            font-size: 1.25rem;
            font-weight: bold;
            margin-top: 0.5rem;
        }

        button[type="submit"],
        #applyPromo {
            padding: 0.75rem 1rem;
            background: var(--color-text);
            color: var(--color-bg);
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button[type="submit"]:hover,
        #applyPromo:hover {
            background: var(--color-tertiary);
        }

        .promo-row {
            display: flex;
            gap: 10px;
        }

        /* Carousel */
        .carousel-container {
            flex: 1 1 0px;
            max-width: 480px;
        }

        .swiper {
            padding-bottom: 2rem;
        }

        .swiper-slide {
            width: auto;
        }

        .menu-card {
            background: #f4f4f4;
            border-radius: 10px;
            padding: 1rem;
            width: 180px;
            text-align: center;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
        }

        .menu-card img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 0.5rem;
        }

        .menu-card h4 {
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .menu-card a {
            display: inline-block;
            background: #00c8ff;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: bold;
        }

        .menu-card a:hover {
            background: #0099cc;
        }
    </style>
</head>
<body style="background-color: #e2e2e2;">
    <div class="main-layout" style="display: flex; flex-direction: column; align-items: center; gap: 2rem; padding: 2rem;">        <!-- Carousel -->
        @if (!empty($allMenus))
        <div class="carousel-container" style="width: 100%; max-width: 200px;">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach ($allMenus as $menu)
                        @if ($menu !== $menuName)
                        <div class="swiper-slide">
                            <div class="menu-card" style="text-align: center; padding: 1rem; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); background: #fff;">
                                @if(isset($menuImages[$menu]))
                                    <img src="{{ asset('storage/' . $menuImages[$menu]) }}" alt="{{ $menu }}" style="width: 100%; max-width: 150px;">
                                @else
                                    <img src="https://via.placeholder.com/150x100?text={{ urlencode($menu) }}" alt="{{ $menu }}">
                                @endif
                                <h4>{{ $menu }}</h4>
                                <a href="{{ route('orders.create', ['menu' => urlencode($menu)]) }}">Lihat Menu</a>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        @endif

        <!-- Form -->
        <div class="order-form-container" style="max-width: 600px; width: 100%; background: #fff; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h2>🛒 Tambah ke Keranjang: {{ ucfirst($menuName) }}</h2>
            <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                @csrf

                <input type="hidden" name="items[0][menu_item]" value="{{ $menuName }}">
                <input type="hidden" name="items[0][price]" id="price-hidden" value="{{ $variants[0]['price'] ?? 0 }}">

                <div class="form-group">
                    <label for="variant">Pilih Varian {{ ucfirst($menuName) }}</label>
                    <select name="items[0][variant]" id="variant" required>
                        @foreach ($variants as $variant)
                            <option value="{{ $variant['name'] }}" data-price="{{ $variant['price'] }}">
                                {{ $variant['name'] }} - Rp {{ number_format($variant['price'], 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Jumlah</label>
                    <input type="number" name="items[0][quantity]" id="quantity" value="1" min="1" required>
                </div>

                <div class="form-group">
                    <label for="promo">Gunakan Promo (Opsional)</label>
                    <div class="promo-row" style="display: flex; gap: 1rem;">
                        <input type="text" name="promo" id="promo" placeholder="Masukkan kode promo" style="flex: 1;">
                        <button type="button" id="applyPromo">Terapkan Promo</button>
                    </div>
                </div>

                <div class="form-group">
                    <label>Total Harga</label>
                    <p id="total-price">Rp 0</p>
                </div>

                <button type="submit">Tambah ke Keranjang</button>
            </form>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const variantSelect = document.getElementById('variant');
        const quantityInput = document.getElementById('quantity');
        const totalPriceDisplay = document.getElementById('total-price');
        const priceHiddenInput = document.getElementById('price-hidden');
        const promoInput = document.getElementById('promo');
        const applyPromoBtn = document.getElementById('applyPromo');

        let currentDiscount = 0;

        function updateTotal() {
            const selectedOption = variantSelect.options[variantSelect.selectedIndex];
            const price = parseInt(selectedOption.getAttribute('data-price'));
            const qty = parseInt(quantityInput.value);
            let total = price * qty;

            if (currentDiscount > 0) {
                total -= total * currentDiscount / 100;
            }

            totalPriceDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
            priceHiddenInput.value = price;
        }

        applyPromoBtn.addEventListener('click', function() {
            const promo = promoInput.value.trim().toUpperCase();
            if (promo === 'DISKON10') {
                currentDiscount = 10;
                alert('Promo DISKON10 diterapkan! Diskon 10%');
            } else {
                currentDiscount = 0;
                alert('Kode promo tidak valid atau tidak tersedia.');
            }
            updateTotal();
        });

        variantSelect.addEventListener('change', updateTotal);
        quantityInput.addEventListener('input', updateTotal);
        window.addEventListener('DOMContentLoaded', updateTotal);

        const swiper = new Swiper('.mySwiper', {
    slidesPerView: 1,
    spaceBetween: 20,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    }
});
    </script>
</body>
</html>
