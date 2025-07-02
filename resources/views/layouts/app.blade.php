<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', '5Zcafeshop')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Default CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Icon (FontAwesome) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-mtHfU0bUgzYvKMi1SODQo0tukDCWTKp+I1Z1iDd9SAsC0x4QEvyaXJYSmhA6Z2LxMZABFSei4VZUlD8h7wF6Ug==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Extra Styles (from children) -->
    @stack('styles')
</head>
<body>

    {{-- Navbar jika global --}}
    {{-- @include('component.navbar') --}}

    {{-- Main content --}}
    @yield('content')
    {{-- Scripts --}}
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
