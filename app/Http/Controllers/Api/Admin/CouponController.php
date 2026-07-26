<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(15);

        return response()->json([
            'success' => true,
            'coupons' => $coupons,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'          => 'required|unique:coupons|string|max:50',
            'type'          => 'required|in:percentage,fixed',
            'value'         => 'required|numeric|min:0',
            'minimum_order' => 'nullable|numeric|min:0',
            'usage_limit'   => 'nullable|integer|min:1',
            'expires_at'    => 'nullable|date',
        ]);

        $coupon = Coupon::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Coupon created successfully',
            'coupon'  => $coupon,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code'  => 'required|unique:coupons,code,' . $id,
            'type'  => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
        ]);

        $coupon->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Coupon updated successfully',
            'coupon'  => $coupon,
        ]);
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return response()->json([
            'success' => true,
            'message' => 'Coupon deleted successfully',
        ]);
    }
}