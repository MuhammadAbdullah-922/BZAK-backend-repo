<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // FIX: eager-load 'payment' so the admin table/modal can show
        // transaction_id, sender_number, bank_reference etc. without an
        // extra request per order.
        $query = Order::with(['user', 'items', 'payment']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->search) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }

        $orders = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'orders'  => $orders,
        ]);
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product', 'payment'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'order'   => $order,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'order'   => $order,
        ]);
    }

    /**
     * NEW: lets an admin mark a prepaid order (JazzCash / EasyPaisa / Bank)
     * as verified/paid or as failed after checking the transaction ID /
     * sender number against their own bank/wallet records. This did not
     * exist before -- payment_status could never be changed from the UI.
     */
 public function updatePaymentStatus(Request $request, Order $order)
{
    $request->validate([
        'payment_status' => 'required|in:pending,paid,failed,refunded',
    ]);

    // Update payment table
    if ($order->payment) {
        $order->payment->update([
            'status' => $request->payment_status,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);
    }

    // Update orders table
    $order->update([
        'payment_status' => $request->payment_status,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Payment status updated successfully.',
        'order' => $order->fresh()->load('payment'),
    ]);
}
}