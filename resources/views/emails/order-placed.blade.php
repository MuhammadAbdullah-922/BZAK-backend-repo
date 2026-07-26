<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; color:#333; margin:0; padding:0; background:#f4f4f4;">
    <div style="max-width:600px; margin:20px auto; background:#fff; border-radius:8px; overflow:hidden;">

        <div style="background:#000; padding:20px; text-align:center;">
            <h1 style="color:#fff; margin:0; font-size:22px;">BZAK Store</h1>
        </div>

        <div style="padding:24px;">
            <h2 style="margin-top:0;">Thank you for your order!</h2>
            <p>Hi {{ $order->user->name }},</p>
            <p>Your order has been placed successfully. Here are your order details:</p>

            <table cellpadding="10" style="border-collapse: collapse; width: 100%; margin:16px 0;">
                <tr style="background:#f9f9f9;">
                    <td><strong>Order / Tracking ID</strong></td>
                    <td>{{ $order->order_number }}</td>
                </tr>
                <tr>
                    <td><strong>Total Amount</strong></td>
                    <td>Rs {{ number_format($order->total) }}</td>
                </tr>
                <tr style="background:#f9f9f9;">
                    <td><strong>Payment Method</strong></td>
                    <td>{{ ucfirst($order->payment_method) }}</td>
                </tr>
                <tr>
                    <td><strong>Payment Status</strong></td>
                    <td>{{ ucfirst($order->payment_status) }}</td>
                </tr>
                <tr style="background:#f9f9f9;">
                    <td><strong>Shipping Address</strong></td>
                    <td>{{ $order->shipping_address }}, {{ $order->shipping_city }}</td>
                </tr>
            </table>

            <p>You can track your order status anytime using your Order ID above from the "Track Order" page on our website.</p>

            <p style="margin-top:24px;">Thank you for shopping with us!<br>— BZAK Store Team</p>
        </div>

        <div style="background:#f4f4f4; padding:16px; text-align:center; font-size:12px; color:#888;">
            &copy; {{ date('Y') }} BZAK Store. All rights reserved.
        </div>

    </div>
</body>
</html>