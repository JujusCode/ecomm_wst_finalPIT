<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset(path: 'images/logo.png') }}" type="image/png">
    <title>Order Receipt #{{ $order->id }}</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            padding: 20px;
        }
        
        /* Layout */
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #4c1d95 0%, #6366f1 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        /* Content */
        .content {
            padding: 30px;
        }
        
        /* Order Info */
        .order-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .order-detail {
            margin-bottom: 20px;
            flex: 1;
            min-width: 200px;
        }
        
        .order-detail h3 {
            font-size: 14px;
            text-transform: uppercase;
            color: #777;
            margin-bottom: 5px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        
        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .items-table th {
            background: #f5f5f5;
            padding: 10px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            color: #555;
            border-bottom: 2px solid #ddd;
        }
        
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
            font-size: 14px;
        }
        
        /* Totals */
        .totals {
            margin-left: auto;
            width: 300px;
            border-top: 2px solid #eee;
            margin-bottom: 30px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 14px;
        }
        
        .total-row.grand {
            font-weight: bold;
            font-size: 16px;
            border-top: 2px solid #eee;
            padding-top: 15px;
            margin-top: 5px;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #999;
            background: #f9f9f9;
            border-top: 1px solid #eee;
        }
        
        /* Thank you message */
        .thank-you {
            text-align: center;
            font-size: 24px;
            margin: 40px 0;
            color: #4c1d95;
        }
        
        /* Utility classes */
        .text-right {
            text-align: right;
        }
        
        /* Address block */
        .address {
            margin-bottom: 5px;
            font-style: normal;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Receipt</h1>
            <p>Order #{{ $order->id }}</p>
        </div>
        
        <div class="content">
            <div class="order-info">
                <div class="order-detail">
                    <h3>Order Details</h3>
                    <p><strong>Order Number:</strong> {{ $order->id }}</p>
                    <p><strong>Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                    <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                </div>
                
                <div class="order-detail">
                    <h3>Shipping Address</h3>
                    <address class="address">
                        {{ $order->first_name }}<br>
                        @if($order->company_name)
                            {{ $order->company_name }}<br>
                        @endif
                        {{ $order->street_address }}<br>
                        @if($order->apartment)
                            {{ $order->apartment }}<br>
                        @endif
                        {{ $order->town_city }}<br>
                        {{ $order->phone }}<br>
                        {{ $order->email }}
                    </address>
                </div>
            </div>
            
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div><strong>{{ $item->product->name }}</strong></div>
                            </td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="totals">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span>${{ number_format($order->total, 2) }}</span>
                </div>
                <div class="total-row">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="total-row grand">
                    <span>Total</span>
                    <span>${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
            
            <div class="thank-you">
                Thank you for your purchase!
            </div>
        </div>
        
        <div class="footer">
            <p>ByteX &copy; {{ date('Y') }}. All rights reserved.</p>
            <p>If you have any questions about your order, please contact us at support@bytex.com</p>
        </div>
    </div>
</body>
</html>