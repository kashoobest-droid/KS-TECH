<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Admin Dashboard - KS Tech</title>
    <style>
        body { background-color: #f5f5f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto; }
        .navbar-custom { background-color: #1a1a1a; }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link { color: #ff9900 !important; }
        .stat-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .stat-card h3 { font-size: 1.8rem; font-weight: bold; color: #ff9900; margin-bottom: 4px; }
        .stat-card p { margin: 0; color: #666; font-size: 0.9rem; }
        .table-card { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
    </style>
</head>
<body>
    <nav class="navbar navbar-custom navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}"><i class="fas fa-microchip"></i> KS TECH Admin</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a>
                <a class="nav-link" href="{{ route('product.index') }}">Products</a>
                <a class="nav-link" href="{{ route('category.index') }}">Categories</a>
                <a class="nav-link" href="{{ route('users.index') }}">Users</a>
                <a class="nav-link" href="/">View Store</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h2 class="mb-4"><i class="fas fa-chart-line text-warning"></i> Dashboard</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <h3>{{ $totalOrders }}</h3>
                    <p><i class="fas fa-box"></i> Total Orders</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h3>${{ number_format($totalRevenue, 0) }}</h3>
                    <p><i class="fas fa-dollar-sign"></i> Revenue</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h3>{{ $productsCount }}</h3>
                    <p><i class="fas fa-cubes"></i> Products</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h3>{{ $usersCount }}</h3>
                    <p><i class="fas fa-users"></i> Customers</p>
                </div>
            </div>
        </div>

        @if($outOfStockCount > 0 || $lowStockProducts->isNotEmpty())
            <div class="alert alert-warning mb-4">
                <strong><i class="fas fa-exclamation-triangle"></i> Stock Alerts:</strong>
                {{ $outOfStockCount }} product(s) out of stock,
                {{ $lowStockProducts->count() }} product(s) low on stock (&lt;5)
            </div>
        @endif

        <div class="table-card">
            <div class="p-3 border-bottom">
                <h5 class="mb-0">Recent Orders</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td><span class="badge bg-{{ $order->status_badge_class }}">{{ ucfirst($order->status) }}</span></td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td><a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">View</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">No orders yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($totalOrders > 10)
                <div class="p-2 text-center">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-warning">View All Orders</a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
