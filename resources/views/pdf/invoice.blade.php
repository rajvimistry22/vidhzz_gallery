<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1c1917; font-size: 11px; line-height: 1.5; }
        .header-table { width: 100%; margin-bottom: 25px; border-bottom: 2px solid #b97a16; padding-bottom: 15px; }
        .heading { font-size: 24px; font-weight: bold; font-family: DejaVu Serif, Georgia, serif; color: #1c1917; }
        .subheading { font-size: 10px; text-transform: uppercase; tracking: 0.15em; color: #78716c; }
        .meta-table { width: 100%; margin-bottom: 20px; }
        .meta-cell { width: 50%; vertical-align: top; }
        .box { border: 1px solid #e7e5e4; padding: 14px; border-radius: 12px; background-color: #fafaf9; margin-bottom: 20px; }
        .address-title { font-weight: bold; font-size: 9px; text-transform: uppercase; color: #78716c; margin-bottom: 5px; border-bottom: 1px solid #e7e5e4; padding-bottom: 3px; }
        table.items-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table.items-table th { padding: 10px; background-color: #fafaf9; border-bottom: 2px solid #e7e5e4; font-weight: bold; font-size: 10px; text-transform: uppercase; color: #78716c; }
        table.items-table td { padding: 10px; border-bottom: 1px solid #e7e5e4; }
        .summary-wrapper { width: 100%; margin-top: 20px; }
        .summary-table { width: 280px; float: right; border-collapse: collapse; }
        .summary-table td { padding: 6px 0; border: none; }
        .summary-table .total-row td { border-top: 1px solid #d6d3d1; font-weight: bold; font-size: 13px; padding-top: 10px; color: #7b4716; }
    </style>
</head>
<body>
    {{-- Invoice Brand Header --}}
    <table class="header-table" style="border: none;">
        <tr style="border: none;">
            <td style="border: none; padding: 0;">
                <div class="heading">VIDHZZ GALLERY</div>
                <div class="subheading">Handmade Festive Collections</div>
            </td>
            <td style="border: none; padding: 0; text-align: right; vertical-align: bottom;">
                <span style="font-size: 12px; font-weight: bold; color: #78716c;">INVOICE</span>
            </td>
        </tr>
    </table>

    {{-- Order metadata --}}
    <div class="box">
        <table class="meta-table" style="border: none; margin-bottom: 0;">
            <tr style="border: none;">
                <td style="border: none; padding: 0; width: 50%;">
                    <strong>Order Number:</strong> {{ $order->order_number }}<br>
                    <strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}<br>
                    <strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}
                </td>
                <td style="border: none; padding: 0; width: 50%; text-align: right;">
                    <strong>Customer:</strong> {{ $order->user->name }}<br>
                    <strong>Email:</strong> {{ $order->user->email }}<br>
                    <strong>Phone:</strong> {{ $order->user->phone ?? $order->shipping_phone }}
                </td>
            </tr>
        </table>
    </div>

    {{-- Shipping/Billing Address (single) --}}
    <table style="width: 100%; border: none; margin-bottom: 20px;">
        <tr style="border: none;">
            <td style="width: 100%; border: none; padding: 0; vertical-align: top;">
                <div class="address-title">Address</div>
                <strong>{{ $order->shipping_name }}</strong><br>
                {{ $order->shipping_address }}<br>
                {{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_pincode }}<br>
                Phone: {{ $order->shipping_phone }}
            </td>
        </tr>
    </table>


    {{-- Items List --}}
    <table class="items-table">
        <thead>
            <tr>
                <th style="text-align: left;">Product Info</th>
                <th style="text-align: center; width: 50px;">Qty</th>
                <th style="text-align: right; width: 100px;">Unit Price</th>
                <th style="text-align: right; width: 120px;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td style="text-align: left;">
                        <strong style="font-size: 11px;">{{ $item->product_name }}</strong>
                        @if ($item->variant_info)
                            <div style="font-size: 9px; color: #78716c; margin-top: 3px;">{{ $item->variant_info }}</div>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">Rs. {{ number_format($item->price, 0) }}</td>
                    <td style="text-align: right;">Rs. {{ number_format($item->subtotal, 0) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Order Summary totals --}}
    <div class="summary-wrapper">
        <table class="summary-table">
            <tr>
                <td>Subtotal</td>
                <td style="text-align: right;">Rs. {{ number_format($order->subtotal, 0) }}</td>
            </tr>
            @if ($order->discount > 0)
                <tr style="color: #b91c1c;">
                    <td>Discount ({{ $order->coupon_code }})</td>
                    <td style="text-align: right;">- Rs. {{ number_format($order->discount, 0) }}</td>
                </tr>
            @endif
            <tr>
                <td>Shipping</td>
                <td style="text-align: right;">
                    @if ($order->shipping_charge > 0)
                        Rs. {{ number_format($order->shipping_charge, 0) }}
                    @else
                        Free
                    @endif
                </td>
            </tr>
            <tr>
                <td>Tax (3%)</td>
                <td style="text-align: right;">Rs. {{ number_format($order->tax, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>Grand Total</td>
                <td style="text-align: right;">Rs. {{ number_format($order->total, 2) }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
