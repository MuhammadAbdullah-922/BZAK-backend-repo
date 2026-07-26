<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales     = Order::where('status', '!=', 'cancelled')->sum('total');
        $totalOrders    = Order::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalProducts  = Product::count();
        $pendingOrders  = Order::where('status', 'pending')->count();
        $pendingReviews = Review::where('is_approved', false)->count();

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $monthlySales = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->whereYear('created_at', date('Y'))
            ->where('status', '!=', 'cancelled')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'success' => true,
            'stats'   => [
                'total_sales'      => $totalSales,
                'total_orders'     => $totalOrders,
                'total_customers'  => $totalCustomers,
                'total_products'   => $totalProducts,
                'pending_orders'   => $pendingOrders,
                'pending_reviews'  => $pendingReviews,
            ],
            'recent_orders' => $recentOrders,
            'monthly_sales' => $monthlySales,
            'top_products'  => $topProducts,
        ]);
    }
}