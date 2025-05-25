<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Report</title>
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
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 10px;
        }
        
        .status-item {
            text-align: center;
            padding: 10px;
            border-radius: 4px;
            color: white;
        }
        
        .status-admin { background-color: #28a745; }
        .status-user { background-color: #007bff; }
        
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
        
        .text-center {
            text-align: center;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 10px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .no-users {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Users Report</h1>
        <p>Generated on {{ now()->format('F j, Y \a\t g:i A') }}</p>
    </div>

    @if($users->count() > 0)
        @if($request->search)
            <div class="filter-info">
                <strong>Applied Filters:</strong>
                Search: "{{ $request->search }}"
            </div>
        @endif

        <div class="summary">
            <h3 style="margin-top: 0; color: #333;">Users Summary</h3>
            <p>Total Users: {{ $users->count() }}</p>
        </div>

        <div class="status-summary">
            <h3 style="margin-top: 0; color: #333;">Role Breakdown</h3>
            <div class="status-grid">
                <div class="status-item status-admin">
                    <strong>{{ $roleCounts['admin'] }}</strong><br>
                    <small>Admins</small>
                </div>
                <div class="status-item status-user">
                    <strong>{{ $roleCounts['user'] }}</strong><br>
                    <small>Users</small>
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="30%">Name</th>
                    <th width="30%">Email</th>
                    <th width="20%">Role</th>
                    <th width="20%">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">
                            <span style="padding: 2px 6px; border-radius: 3px; font-size: 9px; font-weight: bold; text-transform: uppercase;
                                {{ $user->role === 'admin' ? 'background-color: #d4edda; color: #155724;' : 'background-color: #cce5ff; color: #004085;' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Report generated by {{ auth()->user()->name ?? 'System Admin' }} on {{ now()->format('F j, Y \a\t g:i A') }}</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    @else
        <div class="no-users">
            <h3>No Users Found</h3>
            <p>There are no users matching your criteria.</p>
        </div>
    @endif
</body>
</html>