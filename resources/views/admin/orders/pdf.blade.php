<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Report</title>
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
        
        .summary {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }
        
        .summary-item {
            text-align: center;
        }
        
        .summary-item h3 {
            margin: 0;
            color: #333;
            font-size: 16px;
        }
        
        .summary-item p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 10px;
        }
        
        .filter-info {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 20px;
            color: #856404;
        }
        
        .status-summary {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .status-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-top: 10px;
        }
        
        .status-item {
            text-align: center;
            padding: 10px;
            border-radius: 4px;
            color: white;
        }
        
        .status-pending { background-color: #ffc107; color: #212529; }
        .status-processing { background-color: #007bff; }
        .status-completed { background-color: #28a745; }
        .status-cancelled { background-color: #dc3545; }
        
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
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
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
        
        .price {
            font-weight: bold;
            color: #28a745;
        }
        
        .order-items {
            font-size: 10px;
            color: #666;
            max-width: 200px;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 10px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .no-orders {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 40px;
        }
        
        .customer-info {
            max-width: 150px;
        }
        
        .customer-name {
            font-weight: bold;
            color: #333;
        }
        
        .customer-email {
            color: #666;
            font-size: 10px;
        }
        
        .order-date {
            font-size: 10px;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Orders Report</h1>
        <p>Generated on {{ now()->format('F j, Y \a\t g:i A') }}</p>
    </div>

    @if($orders->count() > 0)
        @if($request->search || $request->status)
            <div class="filter-info">
                <strong>Applied Filters:</strong>
                @if($request->search)
                    Search: "{{ $request->search }}"
                @endif
                @if($request->status)
                    @if($request->search) | @endif
                    Status: {{ ucfirst($request->status) }}
                @endif
            </div>
        @endif

        <div class="summary">
            <h3 style="margin-top: 0; color: #333;">Order Summary</h3>
            <div class="summary-grid">
                <div class="summary-item">
                    <h3>{{ $orders->count() }}</h3>
                    <p>Total Orders</p>
                </div>
                <div class="summary-item">
                    <h3>${{ number_format($totalRevenue, 2) }}</h3>
                    <p>Total Revenue</p>
                </div>
                <div class="summary-item">
                    <h3>{{ $totalItems }}</h3>
                    <p>Total Items Sold</p>
                </div>
                <div class="summary-item">
                    <h3>${{ $orders->count() > 0 ? number_format($totalRevenue / $orders->count(), 2) : '0.00' }}</h3>
                    <p>Average Order Value</p>
                </div>
            </div>
        </div>

        <div class="status-summary">
            <h3 style="margin-top: 0; color: #333;">Status Breakdown</h3>
            <div class="status-grid">
                <div class="status-item status-pending">
                    <strong>{{ $statusCounts['pending'] }}</strong><br>
                    <small>Pending</small>
                </div>
                <div class="status-item status-processing">
                    <strong>{{ $statusCounts['processing'] }}</strong><br>
                    <small>Processing</small>
                </div>
                <div class="status-item status-completed">
                    <strong>{{ $statusCounts['completed'] }}</strong><br>
                    <small>Completed</small>
                </div>
                <div class="status-item status-cancelled">
                    <strong>{{ $statusCounts['cancelled'] }}</strong><br>
                    <small>Cancelled</small>
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="8%">Order ID</th>
                    <th width="18%">Customer</th>
                    <th width="12%">Date</th>
                    <th width="10%">Total</th>
                    <th width="8%">Status</th>
                    <th width="8%">Items</th>
                    <th width="20%">Products</th>
                    <th width="16%">Shipping Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td class="text-center">#{{ $order->id }}</td>
                        <td class="customer-info">
                            <div class="customer-name">{{ $order->first_name }}</div>
                            <div class="customer-email">{{ $order->email }}</div>
                            @if($order->phone)
                                <div class="customer-email">{{ $order->phone }}</div>
                            @endif
                        </td>
                        <td class="order-date">
                            {{ $order->created_at->format('M d, Y') }}<br>
                            <span style="color: #666;">{{ $order->created_at->format('h:i A') }}</span>
                        </td>
                        <td class="text-right price">${{ number_format($order->total, 2) }}</td>
                        <td class="text-center">
                            <span class="status-badge badge-{{ $order->status }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="text-center">{{ $order->items->sum('quantity') }}</td>
                        <td class="order-items">
                            @foreach($order->items->take(3) as $item)
                                <div>{{ $item->quantity }}x {{ $item->product->name ?? 'N/A' }}</div>
                            @endforeach
                            @if($order->items->count() > 3)
                                <div style="color: #999; font-style: italic;">
                                    +{{ $order->items->count() - 3 }} more items
                                </div>
                            @endif
                        </td>
                        <td style="font-size: 10px;">
                            {{ $order->street_address }}
                            @if($order->apartment), {{ $order->apartment }}@endif<br>
                            {{ $order->town_city }}
                            @if($order->company_name)
                                <br><em>{{ $order->company_name }}</em>
                            @endif
                        </td>                    
                    </tr>
                        @endforeach
                    </tbody>
                </table>
        
                <div class="footer">
                    <p>Report generated by {{ auth()->user()->name ?? 'System Admin' }} on {{ now()->format('F j, Y \a\t g:i A') }}</p>
                    <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
            @else
                <div class="no-orders">
                    <h3>No Orders Found</h3>
                    <p>There are no orders matching your criteria.</p>
                </div>
            @endif
        </body>
        </html>