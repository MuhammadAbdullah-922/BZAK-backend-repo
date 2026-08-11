<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->where('is_active', true);

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Category ID Filter
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Category Slug Filter (fixed: match by slug, not name)
        if ($request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Price Filter
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Featured Filter
        if ($request->featured) {
            $query->where('is_featured', true);
        }

        // New Arrivals
        if ($request->new_arrivals) {
            $query->where('is_new', true);
        }

        // Sort
        if ($request->sort == 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'price_high') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate($request->per_page ?? 12);

        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'reviews.user', 'inventory'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return response()->json([
            'success'  => true,
            'product'  => $product,
            'related'  => $related,
        ]);
    }

    public function featured()
    {
        $products = Product::with('category')
            ->where('is_featured', true)
            ->where('is_active', true)
            ->take(8)
            ->get();

        return response()->json([
            'success'  => true,
            'products' => $products,
        ]);
    }

    public function newArrivals()
    {
        $products = Product::with('category')
            ->where('is_new', true)
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        return response()->json([
            'success'  => true,
            'products' => $products,
        ]);
    }

    // NEW: Popular = products with the highest total quantity sold
    // (sum of `quantity` across all their order_items rows).
    // Products with no orders yet just get total_sold = 0 and sort last.
    public function popular()
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->withSum('orderItems as total_sold', 'quantity')
            ->orderByDesc('total_sold')
            ->take(8)
            ->get();

        return response()->json([
            'success'  => true,
            'products' => $products,
        ]);
    }
}