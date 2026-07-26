<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($productId)
    {
        $reviews = Review::where('product_id', $productId)
            ->where('is_approved', true)
            ->with('user:id,name,avatar')
            ->latest()
            ->paginate(10);

        $avgRating = Review::where('product_id', $productId)
            ->where('is_approved', true)
            ->avg('rating');

        return response()->json([
            'success'    => true,
            'reviews'    => $reviews,
            'avg_rating' => round($avgRating, 1),
        ]);
    }

    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'title'   => 'nullable|string|max:255',
            'comment' => 'nullable|string',
        ]);

        $existing = Review::where('product_id', $productId)
            ->where('user_id', $request->user()->id)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this product',
            ], 400);
        }

        $review = Review::create([
            'product_id' => $productId,
            'user_id'    => $request->user()->id,
            'rating'     => $request->rating,
            'title'      => $request->title,
            'comment'    => $request->comment,
            'is_approved' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully — pending approval',
            'review'  => $review,
        ], 201);
    }
}