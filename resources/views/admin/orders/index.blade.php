<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Manage Orders - KS Tech Admin</title>
    <style>
        body { background-color: #f5f5f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto; }
        .navbar-custom { background-color: #1a1a1a; }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link { color: #ff9900 !important; }
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
        <h2 class="mb-4"><i class="fas fa-box text-warning"></i> Manage Orders</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    {{ $order->user->name }}<br>
                                    <small class="text-muted">{{ $order->user->email }}</small>
                                </td>
                                <td>{{ $order->items->count() }} item(s)</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>
                                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-select form-select-sm" style="width:auto;" onchange="this.form.submit()">
                                            @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                                                <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                <td><a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">View</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">No orders yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</body>
</html>
