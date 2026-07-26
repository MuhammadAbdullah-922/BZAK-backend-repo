<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Every authenticated user has exactly one cart — fetch it,
     * or create an empty one on first touch.
     */
    private function getOrCreateCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }

    /**
     * GET /api/cart
     */
    public function index(Request $request)
    {
        $cart = $this->getOrCreateCart()
            ->load('items.product:id,name,slug,images,price');

        return response()->json([
            'items' => $cart->items,
            'count' => $cart->count,
            'total' => $cart->total,
        ]);
    }

    /**
     * POST /api/cart/items
     * Add a product to the cart, or increment quantity if it's already there.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cart     = $this->getOrCreateCart();
        $product  = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->increment('quantity', $quantity);
        } else {
            $item = $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'price'      => $product->price,
            ]);
        }

        return response()->json($item->load('product:id,name,slug,images,price'), 201);
    }

    /**
     * PUT /api/cart/items/{item}
     */
    public function update(Request $request, \App\Models\CartItem $item)
    {
        if ($item->cart->user_id !== Auth::id()) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $item->update(['quantity' => $request->quantity]);

        return response()->json($item->load('product:id,name,slug,images,price'));
    }

    /**
     * DELETE /api/cart/items/{item}
     */
    public function destroy(\App\Models\CartItem $item)
    {
        if ($item->cart->user_id !== Auth::id()) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Item removed']);
    }

    /**
     * DELETE /api/cart
     * Clear the whole cart (used after checkout).
     */
    public function clear(Request $request)
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->delete();

        return response()->json(['message' => 'Cart cleared']);
    }
}