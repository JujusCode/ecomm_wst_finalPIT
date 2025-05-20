<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::count();
        $products = Product::count();
        $orders = Order::count();
        $categories = Category::count();

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $topProducts = Product::withCount('orderItems')->orderByDesc('order_items_count')->take(5)->get();

        return view('admin.dashboard', compact(
            'users',
            'products',
            'orders',
            'categories',
            'recentOrders',
            'topProducts'
        ));
    }
}