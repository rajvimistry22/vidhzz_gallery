<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #292524; font-size: 12px; }
        .heading { font-size: 22px; font-weight: bold; margin-bottom: 12px; }
        .box { border: 1px solid #d6d3d1; padding: 16px; margin-bottom: 16px; border-radius: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #e7e5e4; text-align: left; }
    </style>
</head>
<body>
    <div class="heading">Vidhzz Gallery Invoice</div>
    <div class="box">
        <strong>Order:</strong> {{ $order->order_number }}<br>
        <strong>Customer:</strong> {{ $order->user->name }}<br>
        <strong>Total:</strong> {{ $order->formatted_total }}
    </div>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rs. {{ number_format($item->price, 0) }}</td>
                    <td>Rs. {{ number_format($item->subtotal, 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
