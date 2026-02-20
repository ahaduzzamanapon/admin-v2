<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $today = today();
        $weekStart = today()->startOfWeek();
        $monthStart = today()->startOfMonth();

        // Orders count
        $ordersToday = Order::whereDate('created_at', $today)->count();
        $ordersWeek = Order::whereBetween('created_at', [$weekStart, now()])->count();
        $ordersMonth = Order::whereBetween('created_at', [$monthStart, now()])->count();

        // Revenue (delivered only)
        $revenueToday = Order::where('status', 'delivered')->whereDate('created_at', $today)->sum('total');
        $revenueWeek = Order::where('status', 'delivered')->whereBetween('created_at', [$weekStart, now()])->sum('total');
        $revenueMonth = Order::where('status', 'delivered')->whereBetween('created_at', [$monthStart, now()])->sum('total');

        // Top selling products (by qty in delivered orders)
        $topProducts = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.status', 'delivered')
            ->select('products.id', 'products.name', DB::raw('SUM(order_items.qty) as total_sold'), DB::raw('SUM(order_items.line_total) as total_revenue'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        // Low stock
        $lowStock = Product::active()
            ->whereRaw('stock_quantity <= COALESCE(low_stock_threshold, 5)')
            ->orderBy('stock_quantity')
            ->limit(10)
            ->get();

        // Cancelled orders
        $cancelledMonth = Order::where('status', 'cancelled')
            ->whereBetween('created_at', [$monthStart, now()])
            ->count();

        $totalCustomers = User::count();

        return view('admin.reports.index', compact(
            'ordersToday',
            'ordersWeek',
            'ordersMonth',
            'revenueToday',
            'revenueWeek',
            'revenueMonth',
            'topProducts',
            'lowStock',
            'cancelledMonth',
            'totalCustomers'
        ));
    }
}
