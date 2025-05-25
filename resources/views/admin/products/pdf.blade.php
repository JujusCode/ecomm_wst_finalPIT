<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Report</title>
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
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        
        .summary-item {
            text-align: center;
        }
        
        .summary-item h3 {
            margin: 0;
            color: #333;
            font-size: 18px;
        }
        
        .summary-item p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 10px;
        }
        
        .search-info {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 20px;
            color: #856404;
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
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .stock-low {
            color: #dc3545;
            font-weight: bold;
        }
        
        .stock-medium {
            color: #ffc107;
            font-weight: bold;
        }
        
        .stock-high {
            color: #28a745;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 10px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .no-products {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 40px;
        }
        
        .price {
            font-weight: bold;
            color: #28a745;
        }
        
        .category-badge {
            background-color: #e9ecef;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            color: #495057;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Products Report</h1>
        <p>Generated on {{ now()->format('F j, Y \a\t g:i A') }}</p>
    </div>

    @if($products->count() > 0)
        @if($search)
            <div class="search-info">
                <strong>Search Results:</strong> Showing products matching "{{ $search }}"
            </div>
        @endif

        <div class="summary">
            <div class="summary-grid">
                <div class="summary-item">
                    <h3>{{ $products->count() }}</h3>
                    <p>Total Products</p>
                </div>
                <div class="summary-item">
                    <h3>${{ number_format($totalValue, 2) }}</h3>
                    <p>Total Inventory Value</p>
                </div>
                <div class="summary-item">
                    <h3>{{ $products->sum('stock') }}</h3>
                    <p>Total Stock Units</p>
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="8%">ID</th>
                    <th width="30%">Product Name</th>
                    <th width="12%">Price</th>
                    <th width="10%">Stock</th>
                    <th width="15%">Category</th>
                    <th width="15%">Stock Value</th>
                    <th width="10%">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="text-center">{{ $product->id }}</td>
                        <td>
                            <strong>{{ $product->name }}</strong>
                            @if($product->description)
                                <br><small style="color: #666;">{{ Str::limit($product->description, 60) }}</small>
                            @endif
                        </td>
                        <td class="text-right price">${{ number_format($product->price, 2) }}</td>
                        <td class="text-center 
                            @if($product->stock <= 10) stock-low
                            @elseif($product->stock <= 50) stock-medium  
                            @else stock-high
                            @endif">
                            {{ $product->stock }}
                        </td>
                        <td>
                            <span class="category-badge">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>
                        <td class="text-right">${{ number_format($product->price * $product->stock, 2) }}</td>
                        <td class="text-center">
                            @if($product->stock <= 10)
                                <span style="color: #dc3545;">Low Stock</span>
                            @elseif($product->stock <= 50)
                                <span style="color: #ffc107;">Medium</span>
                            @else
                                <span style="color: #28a745;">In Stock</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary" style="margin-top: 20px;">
            <h3 style="margin-top: 0;">Stock Status Summary</h3>
            <div class="summary-grid">
                <div class="summary-item">
                    <h3 style="color: #dc3545;">{{ $products->where('stock', '<=', 10)->count() }}</h3>
                    <p>Low Stock Products (≤10)</p>
                </div>
                <div class="summary-item">
                    <h3 style="color: #ffc107;">{{ $products->whereBetween('stock', [11, 50])->count() }}</h3>
                    <p>Medium Stock Products (11-50)</p>
                </div>
                <div class="summary-item">
                    <h3 style="color: #28a745;">{{ $products->where('stock', '>', 50)->count() }}</h3>
                    <p>High Stock Products (>50)</p>
                </div>
            </div>
        </div>
    @else
        <div class="no-products">
            <h3>No Products Found</h3>
            @if($search)
                <p>No products were found matching your search criteria: "{{ $search }}"</p>
            @else
                <p>There are currently no products in the system.</p>
            @endif
        </div>
    @endif

    <div class="footer">
        <p>This report was generated automatically by the E-Commerce Admin System</p>
        <p>© {{ date('Y') }} Your Company Name. All rights reserved.</p>
    </div>
</body>
</html>