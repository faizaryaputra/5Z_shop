<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter tanggal dari request
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();

        // Ambil data pesanan yang selesai dalam rentang tanggal
        $orders = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        // Hitung total pendapatan dan jumlah pesanan
        $totalRevenue = $orders->sum('total_price');
        $totalOrders = $orders->count();

        return view('reports.sales', compact('orders', 'totalRevenue', 'totalOrders', 'startDate', 'endDate'));
    }
}
