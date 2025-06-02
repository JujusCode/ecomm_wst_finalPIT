<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #333;
            margin: 0;
            font-size: 24px;
        }
        
        .header p {
            color: #666;
            margin: 5px 0 0 0;
        }
        
        .details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .detail-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        
        .detail-box h3 {
            margin-top: 0;
            color: #333;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .total-row {
            font-weight: bold;
        }
        
        .price {
            font-weight: bold;
            color: #28a745;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 10px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .badge-pending { background-color: #fff3cd; color: #856404; }
        .badge-processing { background-color: #cce5ff; color: #004085; }
        .badge-completed { background-color: #d4edda; color: #155724; }
        .badge-cancelled { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Order Invoice #{{ $order->id }}</h1>
        <p>Issued on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
    </div>

    <div class="details">
        <div class="detail-box">
            <h3>Billing Details</h3>
            <p><strong>{{ $order->first_name }}</strong></p>
            @if($order->company_name)
                <p>{{ $order->company_name }}</p>
            @endif
            <p>{{ $order->street_address }}</p>
            @if($order->apartment)
                <p>{{ $order->apartment }}</p>
            @endif
            <p>{{ $order->town_city }}</p>
            <p>Phone: {{ $order->phone }}</p>
            <p>Email: {{ $order->email }}</p>
        </div>

        <div class="detail-box">
            <h3>Order Details</h3>
            <p><strong>Order ID:</strong> #{{ $order->id }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
            <p><strong>Payment Method:</strong> {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
            <p><strong>Order Status:</strong> 
                <span class="status-badge badge-{{ $order->status }}">
                    {{ $order->status }}
                </span>
            </p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th class="text-right">Price</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td class="text-right price">${{ number_format($item->price, 2) }}</td>
                <td class="text-right">{{ $item->quantity }}</td>
                <td class="text-right price">${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right">Subtotal</td>
                <td class="text-right price">${{ number_format($order->total, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-right">Shipping</td>
                <td class="text-right price">$0.00</td>
            </tr>
            <tr class="total-row">
                <td colspan="3" class="text-right">Total</td>
                <td class="text-right price">${{ number_format($order->total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    @if($order->notes)
    <div class="detail-box">
        <h3>Order Notes</h3>
        <p>{{ $order->notes }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Thank you for your order!</p>
        <p>If you have any questions, please contact us at support@yourstore.com</p>
        <p>© {{ date('Y') }} Your Store. All rights reserved.</p>
    </div>
</body>
</html>