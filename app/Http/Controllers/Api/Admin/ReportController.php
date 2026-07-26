<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $period = $request->period ?? 'monthly';

        if ($period == 'daily') {
            $sales = Order::selectRaw('DATE(created_at) as date, SUM(total) as total, COUNT(*) as orders')
                ->where('status', '!=', 'cancelled')
                ->whereMonth('created_at', date('m'))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        } else {
            $sales = Order::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total) as total, COUNT(*) as orders')
                ->where('status', '!=', 'cancelled')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month', 'year')
                ->orderBy('month')
                ->get();
        }

        return response()->json([
            'success' => true,
            'sales'   => $sales,
        ]);
    }

    public function topProducts()
    {
        $products = Product::withCount('orderItems')
            ->withSum('orderItems', 'total')
            ->orderBy('order_items_count', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'success'  => true,
            'products' => $products,
        ]);
    }

    public function summary()
    {
        return response()->json([
            'success' => true,
            'summary' => [
                'total_revenue'    => Order::where('status', '!=', 'cancelled')->sum('total'),
                'total_orders'     => Order::count(),
                'total_customers'  => User::where('role', 'customer')->count(),
                'total_products'   => Product::count(),
                'today_sales'      => Order::whereDate('created_at', today())->sum('total'),
                'today_orders'     => Order::whereDate('created_at', today())->count(),
                'monthly_revenue'  => Order::whereMonth('created_at', date('m'))->sum('total'),
                'monthly_orders'   => Order::whereMonth('created_at', date('m'))->count(),
            ],
        ]);
    }
}