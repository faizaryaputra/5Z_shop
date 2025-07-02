<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '5Zcafeshop')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Tambahan CSS -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #fefefe;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header, footer {
            background-color: #111;
            color: #fff;
            padding: 1rem 2rem;
        }

        nav a {
            color: #fff;
            margin-right: 1rem;
            text-decoration: none;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        footer {
            text-align: center;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <header>
        <nav>
            <a href="{{ url('/') }}">Beranda</a>
            <a href="{{ url('/menu') }}">Menu</a>
            <a href="{{ url('/about') }}">Tentang</a>
            <a href="{{ url('/gallery') }}">Galeri</a>
            <a href="{{ url('/contact') }}">Kontak</a>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="container">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} 5Zcafeshop. All rights reserved.
    </footer>

</body>
</html>
