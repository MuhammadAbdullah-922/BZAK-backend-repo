<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'code'     => 'required|string',
            'subtotal' => 'required|numeric',
        ]);

        $coupon = Coupon::where('code', $request->code)
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code',
            ], 404);
        }

        if ($coupon->expires_at !== null && Carbon::parse($coupon->expires_at)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon has expired',
            ], 400);
        }

        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon usage limit reached',
            ], 400);
        }

        if ($request->subtotal < $coupon->minimum_order) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum order amount is Rs. ' . $coupon->minimum_order,
            ], 400);
        }

        $discount = $coupon->type == 'percentage'
            ? ($request->subtotal * $coupon->value) / 100
            : $coupon->value;

        return response()->json([
            'success'  => true,
            'message'  => 'Coupon applied successfully',
            'discount' => $discount,
            'coupon'   => $coupon,
        ]);
    }
}