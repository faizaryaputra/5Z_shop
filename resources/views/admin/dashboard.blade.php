@extends('layouts.admin')

@section('content')
<div class="p-6 space-y-8">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-4">Dashboard Admin</h2>

    {{-- Statistik Utama --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        {{-- Total Pesanan --}}
        <div class="flex items-center space-x-4 bg-white border-l-8 border-indigo-600 shadow rounded-2xl p-5">
            <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full text-xl">📦</div>
            <div>
                <p class="text-sm text-gray-600 font-semibold">Total Pesanan</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</p>
            </div>
        </div>
        {{-- Total Pengguna --}}
        <div class="flex items-center space-x-4 bg-white border-l-8 border-green-600 shadow rounded-2xl p-5">
            <div class="bg-green-100 text-green-600 p-3 rounded-full text-xl">👤</div>
            <div>
                <p class="text-sm text-gray-600 font-semibold">Total Pengguna</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
            </div>
        </div>
        {{-- Total Pendapatan --}}
        <div class="flex items-center space-x-4 bg-white border-l-8 border-yellow-600 shadow rounded-2xl p-5">
            <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full text-xl">💰</div>
            <div>
                <p class="text-sm text-gray-600 font-semibold">Total Pendapatan</p>
                <p class="text-2xl font-bold text-gray-800">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Grafik Pesanan dan Pendapatan --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Pesanan per Bulan --}}
        <div class="bg-white shadow-md rounded-2xl p-5">
            <h3 class="text-lg font-semibold mb-3 text-gray-800">📦 Pesanan per Bulan</h3>
            <div class="w-full h-[300px] relative">
                <canvas id="ordersChart" class="!w-full !h-full"></canvas>
            </div>
        </div>
        {{-- Pendapatan per Bulan --}}
        <div class="bg-white shadow-md rounded-2xl p-5">
            <h3 class="text-lg font-semibold mb-3 text-gray-800">💰 Pendapatan per Bulan</h3>
            <div class="w-full h-[300px] relative">
                <canvas id="revenueChart" class="!w-full !h-full"></canvas>
            </div>
        </div>
    </div>

    {{-- Menu Terlaris --}}
    <div class="bg-white shadow-md rounded-2xl p-5">
        <h3 class="text-lg font-semibold mb-3 text-gray-800">🔥 Menu Terlaris</h3>
        <ul class="list-disc list-inside text-gray-700 space-y-1">
            @forelse($bestSellingMenus as $menu)
                <li><span class="font-semibold">{{ $menu['menu_name'] }}</span> - {{ $menu['total_sold'] }} terjual</li>
            @empty
                <li class="text-gray-500">Tidak ada data menu.</li>
            @endforelse
        </ul>
    </div>

    {{-- Riwayat Pesanan Terbaru --}}
    <div class="bg-white shadow-md rounded-2xl p-5">
        <h3 class="text-lg font-semibold mb-3 text-gray-800">🕒 Riwayat Pesanan Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 font-semibold text-gray-700">User</th>
                        <th class="px-4 py-2 font-semibold text-gray-700">Total</th>
                        <th class="px-4 py-2 font-semibold text-gray-700">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $order->user->name ?? '-' }}</td>
                            <td class="px-4 py-2">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-center text-gray-500">Tidak ada pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ordersChart = new Chart(document.getElementById('ordersChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($ordersPerMonth)) !!},
            datasets: [{
                label: 'Pesanan',
                data: {!! json_encode(array_values($ordersPerMonth)) !!},
                backgroundColor: 'rgba(99, 102, 241, 0.7)',
                borderColor: '#4f46e5',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const revenueChart = new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($revenuePerMonth)) !!},
            datasets: [{
                label: 'Pendapatan',
                data: {!! json_encode(array_values($revenuePerMonth)) !!},
                borderColor: '#14b8a6',
                backgroundColor: 'rgba(20, 184, 166, 0.2)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: '#14b8a6'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
