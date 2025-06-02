<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function dashboard()
    {
        // Mini dashboard - limited stats for staff
        $todayOrders = Order::whereDate('created_at', today())->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $lowStockProducts = Product::where('stock', '<=', 10)->count();

        $recentOrders = Order::with('user')->latest()->take(3)->get();
        $lowStockItems = Product::with('category')->where('stock', '<=', 10)->orderBy('stock', 'asc')->take(5)->get();
        return view('staff.dashboard', compact(
            'todayOrders',
            'pendingOrders',
            'processingOrders',
            'lowStockProducts',
            'recentOrders',
            'lowStockItems'
        ));
    }
}