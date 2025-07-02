<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Data
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalRevenue = Transaction::where('status', 'success')->sum('total_price');

        // Menu Terlaris (menggabungkan menu_item dan variant)
        $bestSellingMenus = DB::table('order_items')
            ->select('menu_item', 'variant', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('menu_item', 'variant')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'menu_name' => "{$item->menu_item} - {$item->variant}",
                    'total_sold' => $item->total_sold,
                ];
            });

        // Ambil tanggal 6 bulan lalu
$startMonth = Carbon::now()->subMonths(5)->startOfMonth();

$ordersPerMonth = Order::where('created_at', '>=', $startMonth)
    ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
    ->groupBy('month')
    ->orderBy('month')
    ->get()
    ->pluck('count', 'month')
    ->toArray();

$revenuePerMonth = Transaction::where('status', 'success')
    ->where('created_at', '>=', $startMonth)
    ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total_price) as revenue")
    ->groupBy('month')
    ->orderBy('month')
    ->get()
    ->pluck('revenue', 'month')
    ->toArray();
        // Riwayat Pesanan Terbaru
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'bestSellingMenus' => $bestSellingMenus,
            'ordersPerMonth' => $ordersPerMonth,
            'revenuePerMonth' => $revenuePerMonth,
            'recentOrders' => $recentOrders,
        ]);
    }
}
