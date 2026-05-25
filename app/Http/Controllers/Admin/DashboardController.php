<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'orders' => Order::count(),
            'customers' => User::where('role', 'customer')->count(),
            'products' => Product::count(),
        ];

        $recentOrders = Order::with('user')->recent()->take(8)->get();
        $lowStockProducts = Product::where('stock', '<=', 10)->orderBy('stock')->take(8)->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
            'categories' => Category::ordered()->get(),
            'products' => Product::with('category')->latest()->paginate(12),
            'customers' => User::where('role', 'customer')->latest()->paginate(12),
            'coupons' => Coupon::latest()->paginate(12),
            'banners' => Banner::latest()->paginate(12),
            'orders' => Order::with('user')->recent()->paginate(12),
        ]);
    }
}
