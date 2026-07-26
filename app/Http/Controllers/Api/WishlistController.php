<?php



namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class WishlistController extends Controller
{
    /**
     * GET /api/v1/wishlist
     */
    public function index(Request $request): JsonResponse
    {
        $wishlist = Wishlist::with('product')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'wishlist' => $wishlist,
        ]);
    }

    /**
     * POST /api/v1/wishlist
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $exists = Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($exists) {
            return response()->json([
                'message' => 'Product already exists in wishlist.',
            ], 409);
        }

        $wishlist = Wishlist::create([
            'user_id' => $request->user()->id,
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist.',
            'data' => $wishlist,
        ], 201);
    }

    /**
     * DELETE /api/v1/wishlist/{id}
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $wishlist = Wishlist::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$wishlist) {
            return response()->json([
                'message' => 'Wishlist item not found.',
            ], 404);
        }

        $wishlist->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist.',
        ]);
    }
}