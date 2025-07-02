<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya & Pengaturan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> {{-- Optional: kalau ada Tailwind/Bootstrap --}}
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: url('{{ asset('images/caffeshop.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .overlay {
            background-color: rgba(255, 255, 255, 0.85);
            min-height: 100vh;
            padding: 60px 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }

        h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 24px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .btn-save {
            background-color: #795548; /* warna kopi */
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-save:hover {
            background-color: #5d4037;
        }

        .alert {
            background: #e0f7e9;
            color: #155724;
            padding: 12px;
            border-left: 5px solid #28a745;
            margin-bottom: 20px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="overlay">
    <div class="container">
        <h2>Profil Saya & Pengaturan</h2>

        @if (session('status'))
            <div class="alert">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.settings.update') }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password Baru <small>(Kosongkan jika tidak ingin diubah)</small></label>
                <input type="password" id="password" name="password" placeholder="Minimal 8 karakter">
            </div>

            <button type="submit" class="btn-save">💾 Simpan Perubahan</button>
        </form>
    </div>
</div>

<script>
    // Sembunyikan alert setelah beberapa detik
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 5000);
</script>

</body>
</html>
