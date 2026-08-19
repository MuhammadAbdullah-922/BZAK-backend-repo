<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Inventory;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'items'               => 'required|array',
            'items.*.product_id'  => 'required|exists:products,id',
            'items.*.quantity'    => 'required|integer|min:1',
            'items.*.size'        => 'nullable|string',
            'items.*.color'       => 'nullable|string',
            'shipping_address'    => 'required|string',
            'shipping_city'       => 'required|string',
            'shipping_phone'      => 'required|string',
            // FIX: 'bank' was missing here, so Bank Transfer orders from the
            // checkout page were failing validation (422) before reaching
            // the order-creation logic at all.
            'payment_method'      => 'required|in:cod,online,jazzcash,easypaisa,bank',
            // FIX: these were being sent by the frontend but silently
            // dropped -- validate + persist them now.
            'transaction_id'      => 'nullable|string|max:100',
            'sender_number'       => 'nullable|string|max:30',
            'bank_reference'      => 'nullable|string|max:150',
        ]);

        $subtotal = 0;
        $orderItems = [];

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $price   = $product->sale_price ?? $product->price;
            $total   = $price * $item['quantity'];
            $subtotal += $total;

            $orderItems[] = [
                'product_id'   => $product->id,
                'product_name' => $product->name,
                'size'         => $item['size'] ?? null,
                'color'        => $item['color'] ?? null,
                'quantity'     => $item['quantity'],
                'price'        => $price,
                'total'        => $total,
            ];
        }

        // Coupon
        $discount = 0;
        if ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)
                ->where('is_active', true)
                ->first();

            if ($coupon && $subtotal >= $coupon->minimum_order) {
                if ($coupon->type == 'percentage') {
                    $discount = ($subtotal * $coupon->value) / 100;
                } else {
                    $discount = $coupon->value;
                }
                $coupon->increment('used_count');
            }
        }

        // Respect a delivery/shipping charge sent from the frontend
        // (Checkout.jsx already computes this from the selected delivery
        // method), falling back to the old flat-rate rule if not sent.
        $shipping = $request->has('shipping')
            ? (float) $request->shipping
            : ($subtotal > 2000 ? 0 : 150);

        $total = $subtotal - $discount + $shipping;

        // Cash on Delivery has nothing to verify, so it can go straight to
        // "pending" fulfilment. Prepaid methods stay "pending" until an
        // admin verifies the transaction / reference on their end.
        $paymentStatus = 'pending';

        // Create Order
        $order = Order::create([
            'user_id'          => $request->user()->id,
            'order_number'     => 'BZK-' . strtoupper(Str::random(8)),
            'status'           => 'pending',
            'subtotal'         => $subtotal,
            'discount'         => $discount,
            'shipping'         => $shipping,
            'total'            => $total,
            'payment_method'   => $request->payment_method,
            'payment_status'   => $paymentStatus,
            'coupon_code'      => $request->coupon_code,
            'shipping_address' => $request->shipping_address,
            'shipping_city'    => $request->shipping_city,
            'shipping_phone'   => $request->shipping_phone,
            'notes'            => $request->notes,
            'whatsapp_number'  => $request->whatsapp_number,
        ]);

        // Create Order Items
        foreach ($orderItems as $item) {
            $order->items()->create($item);

            // Update Inventory
            Inventory::where('product_id', $item['product_id'])
                ->where('size', $item['size'])
                ->decrement('quantity', $item['quantity']);
        }

        // Create Payment Record
        // FIX: transaction_id / sender_number / bank_reference now actually
        // get saved instead of being lost.
        Payment::create([
            'order_id'       => $order->id,
            'user_id'        => $request->user()->id,
            'amount'         => $total,
            'method'         => $request->payment_method,
            'status'         => $paymentStatus,
            'transaction_id' => $request->transaction_id,
            'sender_number'  => $request->sender_number,
            'bank_reference' => $request->bank_reference,
        ]);

        // Send order confirmation email with tracking ID.
        // Wrapped in try/catch so a mail server hiccup never blocks the
        // customer's order from completing successfully.
        try {
            if ($request->user()->email) {
                Mail::to($request->user()->email)->send(new OrderPlaced($order));
            }
        } catch (\Exception $e) {
            \Log::error('Order confirmation email failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully',
            'order'   => $order->load('items', 'payment'),
        ], 201);
    }

    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $orders = Order::where('user_id', $userId)
            ->with('items')
            ->latest()
            ->paginate(10);

        // Fetch every product_id this user has already reviewed, once,
        // instead of running a query per item (N+1 avoided).
        $reviewedProductIds = Review::where('user_id', $userId)
            ->pluck('product_id')
            ->all();

        // Stamp has_review onto each item so the frontend can show the
        // "Reviewed" badge correctly even after a page refresh.
        $orders->getCollection()->transform(function ($order) use ($reviewedProductIds) {
            $order->items->transform(function ($item) use ($reviewedProductIds) {
                $item->has_review = in_array($item->product_id, $reviewedProductIds);
                return $item;
            });
            return $order;
        });

        return response()->json([
            'success' => true,
            'orders'  => $orders,
        ]);
    }

    public function show(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', $request->user()->id)
            ->with(['items.product', 'payment'])
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'order'   => $order,
        ]);
    }


public function updatePaymentStatus(Request $request, Order $order)
{
    $request->validate([
        'payment_status' => 'required|in:pending,failed,completed',
    ]);

    // Update payment table
    if ($order->payment) {
        $order->payment->update([
            'status' => $request->payment_status,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);
    }

    // Orders table ki value database ke mutabiq save karo
    $status = $request->payment_status;

    // Agar orders.payment_status me "paid" use hota hai
    if ($status === 'completed') {
        $status = 'paid';
    }

    $order->update([
        'payment_status' => $status,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Payment status updated successfully.',
        'order'   => $order->fresh()->load('payment'),
    ]);
}


    public function track($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->select('order_number', 'status', 'payment_status', 'created_at', 'updated_at')
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'order'   => $order,
        ]);
    }

    /**
     * NEW: upload a payment screenshot for an already-placed order
     * (JazzCash / EasyPaisa / Bank Transfer). Called right after store()
     * succeeds on the checkout page, using the order_number it returned.
     *
     * Kept as a separate step (instead of bundling the file into the
     * order-creation request) so the existing JSON order payload doesn't
     * have to be rebuilt as multipart/form-data.
     */
    public function uploadPaymentProof(Request $request, $orderNumber)
    {
        $request->validate([
            // 4MB max, common screenshot formats only
            'proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', $request->user()->id)
            ->with('payment')
            ->firstOrFail();

        if (!$order->payment) {
            return response()->json([
                'success' => false,
                'message' => 'No payment record found for this order.',
            ], 404);
        }

        // public disk -> storage/app/public/payment-proofs, served via
        // the /storage symlink (php artisan storage:link)
        $path = $request->file('proof')->store('payment-proofs', 'public');

        $order->payment->update(['proof_image' => $path]);

        return response()->json([
            'success' => true,
            'message' => 'Payment proof uploaded successfully',
            'payment' => $order->payment->fresh(),
        ]);
    }
}