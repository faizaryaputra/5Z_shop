<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 240px;
            background-color: #343a40;
            height: 100vh;
            position: fixed;
            padding-top: 2rem;
        }
        .sidebar a {
            color: #ddd;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
            color: #fff;
        }
        .content {
            margin-left: 240px;
            padding: 2rem;
        }
        .sidebar .nav-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #fff;
            padding-left: 20px;
            margin-bottom: 1.5rem;
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
    </style>
</head>
<body class="font-sans text-gray-900">

    <div class="sidebar">
        <div class="nav-title">Admin Panel</div>
        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="{{ route('admin.orders.index') }}"><i class="bi bi-cart"></i> Orders</a>
        <a href="{{ route('admin.menus.index') }}"><i class="bi bi-list"></i> Menu Management</a>
        <a href="{{ route('admin.menu-categories.index') }}"><i class="bi bi-tags"></i> Categories</a>
        <a href="{{ route('admin.users.index') }}"><i class="bi bi-person"></i> Users</a>
        <a href="{{ route('admin.transactions.index') }}"><i class="bi bi-currency-dollar"></i> Transactions</a>
        <a href="{{ route('admin.chat.index') }}"><i class="bi bi-chat-dots"></i> Live Chat</a>
        <a href="{{ route('admin.logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
           <i class="bi bi-box-arrow-right"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

    <div class="content">
        @yield('content')
    </div>

    @yield('scripts')
    @stack('scripts')

</body>
</html>
