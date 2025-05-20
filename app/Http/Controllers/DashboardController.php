<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get current date and previous month for comparisons
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfPreviousMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfPreviousMonth = $now->copy()->subMonth()->endOfMonth();

        // Total stats with month-over-month change percentages
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $thisMonthRevenue = Order::where('status', 'completed')->whereDate('created_at', '>=', $startOfMonth)->sum('total');
        $lastMonthRevenue = Order::where('status', 'completed')
            ->whereDate('created_at', '>=', $startOfPreviousMonth)
            ->whereDate('created_at', '<=', $endOfPreviousMonth)
            ->sum('total');
        $revenueChange = $lastMonthRevenue > 0 ? round(($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue * 100, 1) : 0;

        $totalOrders = Order::count();
        $thisMonthOrders = Order::whereDate('created_at', '>=', $startOfMonth)->count();
        $lastMonthOrders = Order::whereDate('created_at', '>=', $startOfPreviousMonth)
            ->whereDate('created_at', '<=', $endOfPreviousMonth)
            ->count();
        $ordersChange = $lastMonthOrders > 0 ? round(($thisMonthOrders - $lastMonthOrders) / $lastMonthOrders * 100, 1) : 0;

        $totalProducts = Product::count();
        $thisMonthProducts = Product::whereDate('created_at', '>=', $startOfMonth)->count();
        $lastMonthProducts = Product::whereDate('created_at', '>=', $startOfPreviousMonth)
            ->whereDate('created_at', '<=', $endOfPreviousMonth)
            ->count();
        $productsChange = $lastMonthProducts > 0 ? round(($thisMonthProducts - $lastMonthProducts) / $lastMonthProducts * 100, 1) : 0;

        $totalUsers = User::count();
        $thisMonthUsers = User::whereDate('created_at', '>=', $startOfMonth)->count();
        $lastMonthUsers = User::whereDate('created_at', '>=', $startOfPreviousMonth)
            ->whereDate('created_at', '<=', $endOfPreviousMonth)
            ->count();
        $usersChange = $lastMonthUsers > 0 ? round(($thisMonthUsers - $lastMonthUsers) / $lastMonthUsers * 100, 1) : 0;

        // Sales chart data for the past 6 months
        $salesChartData = $this->getSalesChartData();

        // Top products by sales
        $topProductsData = $this->getTopProductsData();

        // Orders by status
        $orderStatusData = $this->getOrderStatusData();

        // User registration trend
        $userRegistrationData = $this->getUserRegistrationData();

        // Low stock products
        $lowStockProducts = Product::where('stock', '<=', 10)->orderBy('stock', 'asc')->take(5)->get();

        // Recent orders
        $recentOrders = Order::with(['user'])->orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', compact(
            'totalRevenue',
            'revenueChange',
            'totalOrders',
            'ordersChange',
            'totalProducts',
            'productsChange',
            'totalUsers',
            'usersChange',
            'salesChartData',
            'topProductsData',
            'orderStatusData',
            'userRegistrationData',
            'lowStockProducts',
            'recentOrders'
        ));
    }

    private function getSalesChartData()
    {
        // Get sales data for the last 6 months
        $sixMonthsAgo = Carbon::now()->subMonths(6)->startOfMonth();

        // Get monthly revenue
        $monthlyRevenue = Order::where('status', 'completed')
            ->where('created_at', '>=', $sixMonthsAgo)
            ->select(
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as count'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $labels = [];
        $revenue = [];
        $orders = [];

        // Fill in the data for the past 6 months
        for ($i = 0; $i < 6; $i++) {
            $date = Carbon::now()->subMonths(5 - $i)->startOfMonth();
            $monthYear = $date->format('M Y');
            $labels[] = $monthYear;

            $monthData = $monthlyRevenue->first(function ($item) use ($date) {
                return $item->month == $date->month && $item->year == $date->year;
            });

            $revenue[] = $monthData ? floatval($monthData->revenue) : 0;
            $orders[] = $monthData ? intval($monthData->count) : 0;
        }

        return [
            'labels' => $labels,
            'revenue' => $revenue,
            'orders' => $orders
        ];
    }

    private function getTopProductsData()
    {
        // Get top 5 products by sales quantity
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->with('product')
            ->get();

        $labels = [];
        $values = [];

        foreach ($topProducts as $item) {
            if ($item->product) {
                $labels[] = $item->product->name;
                $values[] = $item->total_sold;
            }
        }

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }

    private function getOrderStatusData()
    {
        // Get count of orders by status
        $orderStatusCounts = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $statusLabels = ['Completed', 'Processing', 'Pending', 'Cancelled'];
        $statusValues = [0, 0, 0, 0];

        foreach ($orderStatusCounts as $statusCount) {
            switch (strtolower($statusCount->status)) {
                case 'completed':
                    $statusValues[0] = $statusCount->total;
                    break;
                case 'processing':
                    $statusValues[1] = $statusCount->total;
                    break;
                case 'pending':
                    $statusValues[2] = $statusCount->total;
                    break;
                case 'cancelled':
                    $statusValues[3] = $statusCount->total;
                    break;
            }
        }

        return [
            'labels' => $statusLabels,
            'values' => $statusValues
        ];
    }

    private function getUserRegistrationData()
    {
        // Get user registrations for the past 6 months
        $sixMonthsAgo = Carbon::now()->subMonths(6)->startOfMonth();

        $monthlyRegistrations = User::where('created_at', '>=', $sixMonthsAgo)
            ->select(
                DB::raw('COUNT(*) as count'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $labels = [];
        $values = [];

        // Fill in the data for the past 6 months
        for ($i = 0; $i < 6; $i++) {
            $date = Carbon::now()->subMonths(5 - $i)->startOfMonth();
            $monthYear = $date->format('M Y');
            $labels[] = $monthYear;

            $monthData = $monthlyRegistrations->first(function ($item) use ($date) {
                return $item->month == $date->month && $item->year == $date->year;
            });

            $values[] = $monthData ? intval($monthData->count) : 0;
        }

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }
}