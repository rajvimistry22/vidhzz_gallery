<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Order - Vidhzz Gallery</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f7f5f0;
            color: #1c1917;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px border #e7e5e4;
        }
        .header {
            background-color: #0c0a09;
            color: #f5f5f4;
            padding: 32px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 0.15em;
            font-weight: 600;
        }
        .header p {
            margin: 8px 0 0 0;
            font-size: 11px;
            letter-spacing: 0.25em;
            color: #a8a29e;
            text-transform: uppercase;
        }
        .content {
            padding: 32px;
        }
        .intro {
            margin-bottom: 24px;
        }
        .intro h2 {
            font-size: 20px;
            color: #1c1917;
            margin-top: 0;
        }
        .order-meta {
            background-color: #fafaf9;
            border: 1px solid #e7e5e4;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
            font-size: 14px;
        }
        .meta-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .meta-row:last-child {
            margin-bottom: 0;
        }
        .meta-label {
            color: #78716c;
            font-weight: 500;
        }
        .meta-value {
            font-weight: 600;
            color: #1c1917;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .table th {
            text-align: left;
            padding: 12px 8px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #78716c;
            border-bottom: 2px solid #e7e5e4;
        }
        .table td {
            padding: 16px 8px;
            border-bottom: 1px solid #f5f5f4;
            font-size: 14px;
        }
        .product-info {
            display: flex;
            align-items: center;
        }
        .product-details {
            margin-left: 8px;
        }
        .product-name {
            font-weight: 600;
            color: #1c1917;
        }
        .product-variant {
            font-size: 12px;
            color: #78716c;
            margin-top: 4px;
        }
        .totals-section {
            width: 250px;
            margin-left: auto;
            margin-bottom: 32px;
            font-size: 14px;
        }
        .totals-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .totals-row.grand-total {
            border-top: 2px solid #e7e5e4;
            padding-top: 12px;
            margin-top: 12px;
            font-size: 16px;
            font-weight: 700;
            color: #1c1917;
        }
        .address-grid {
            display: table;
            width: 100%;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #e7e5e4;
        }
        .address-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .address-title {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #78716c;
            margin-bottom: 8px;
        }
        .address-text {
            font-size: 13px;
            line-height: 1.6;
            color: #44403c;
        }
        .footer {
            background-color: #fafaf9;
            padding: 24px;
            text-align: center;
            font-size: 12px;
            color: #78716c;
            border-top: 1px solid #e7e5e4;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>VIDHZZ GALLERY</h1>
            <p>Handmade Festive Collections</p>
        </div>
        <div class="content">
            <div class="intro">
                <h2>New Order Received!</h2>
                <p>Hello,</p>
                <p>A new order has been successfully placed on Vidhzz Gallery. Here are the order details:</p>
            </div>
            
            <div class="order-meta">
                <div class="meta-row">
                    <span class="meta-label">Order Number:</span>
                    <span class="meta-value">{{ $order->order_number }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Date & Time:</span>
                    <span class="meta-value">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Payment Status:</span>
                    <span class="meta-value" style="color: {{ $order->payment_status === 'paid' ? '#15803d' : '#b45309' }}">
                        {{ strtoupper($order->payment_status) }}
                    </span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Payment Method:</span>
                    <span class="meta-value">{{ strtoupper($order->payment_method) }}</span>
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>
                                <div class="product-info">
                                    <div class="product-details">
                                        <div class="product-name">{{ $item->product_name }}</div>
                                        @if ($item->variant_info)
                                            <div class="product-variant">{{ $item->variant_info }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: center; font-weight: 600;">{{ $item->quantity }}</td>
                            <td style="text-align: right; font-weight: 600;">Rs. {{ number_format($item->price, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="totals-section">
                <div class="totals-row">
                    <span style="color: #78716c;">Subtotal</span>
                    <span style="font-weight: 600;">Rs. {{ number_format($order->subtotal, 0) }}</span>
                </div>
                @if ($order->discount > 0)
                    <div class="totals-row" style="color: #b91c1c;">
                        <span>Discount</span>
                        <span>- Rs. {{ number_format($order->discount, 0) }}</span>
                    </div>
                @endif
                <div class="totals-row">
                    <span style="color: #78716c;">Shipping</span>
                    <span style="font-weight: 600;">Rs. {{ number_format($order->shipping_charge, 0) }}</span>
                </div>
                @if ($order->tax > 0)
                    <div class="totals-row">
                        <span style="color: #78716c;">Tax (3% GST)</span>
                        <span style="font-weight: 600;">Rs. {{ number_format($order->tax, 0) }}</span>
                    </div>
                @endif
                <div class="totals-row grand-total">
                    <span>Total Amount</span>
                    <span>Rs. {{ number_format($order->total, 0) }}</span>
                </div>
            </div>

            <div class="address-grid">
                <div class="address-col" style="width: 100%;">
                    <div class="address-title">Address</div>
                    <div class="address-text">
                        <strong>{{ $order->shipping_name }}</strong><br>
                        Phone: {{ $order->shipping_phone }}<br>
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_pincode }}<br>
                        {{ $order->shipping_country }}
                    </div>
                </div>
            </div>

            
            @if ($order->notes)
                <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid #e7e5e4;">
                    <div class="address-title">Customer Notes</div>
                    <p style="font-size: 13px; color: #44403c; line-height: 1.5; margin: 4px 0 0 0;">{{ $order->notes }}</p>
                </div>
            @endif
        </div>
        <div class="footer">
            <p>Vidhzz Gallery &copy; {{ date('Y') }}. All rights reserved.</p>
            <p>This is an automated notification regarding order status.</p>
        </div>
    </div>
</body>
</html>
