<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Completed</title>
</head>
<body style="font-family: Arial, sans-serif;">

    <h2 style="color:#28a745;">Order Completed 🎉</h2>

    <p>Hello <strong>{{ $order->user->first_name }}</strong>,</p>

    <p>Your order <strong>#{{ $order->order_id }}</strong> has been successfully completed.</p>

    <table cellpadding="6" cellspacing="0" border="1" width="100%">
        <tr>
            <td><strong>Order Date</strong></td>
            <td>{{ $order->created_at->format('d M Y') }}</td>
        </tr>
        <tr>
            <td><strong>Total Amount</strong></td>
            <td>₹{{ number_format($order->total_amount, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Status</strong></td>
            <td>{{ ucfirst($order->status) }}</td>
        </tr>
          <tr>
            <td><strong>Delivery Date</strong></td>
            <td>{{ ucfirst($order->deliver_date) }}</td>
        </tr>
    </table>

    <br>

    <p>Thank you for shopping with us.</p>

    <p>
        Regards,<br>
        <strong>{{ config('app.name') }}</strong>
    </p>

</body>
</html>
