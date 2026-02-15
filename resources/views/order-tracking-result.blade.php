<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Order #{{ $order->id }} - KS Tech Store</title>
    <style>
        body { background: #f5f5f5; }
        .navbar-custom { background: #1a1a1a; }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link { color: #ff9900 !important; }
    </style>
</head>
<body>
    <nav class="navbar navbar-custom navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fas fa-microchip"></i> KS TECH</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link" href="{{ route('order.track.show') }}">Track Another Order</a>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        <h2 class="mb-4">Order #{{ $order->id }}</h2>
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <p class="mb-0"><strong>Status:</strong> <span class="badge bg-{{ $order->status_badge_class }}">{{ ucfirst($order->status) }}</span></p>
                <p class="mb-0 mt-2"><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
                @if($order->discount > 0)
                    <p class="mb-0 small text-success">Discount applied: -${{ number_format($order->discount, 2) }}</p>
                @endif
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-header">Items</div>
            <ul class="list-group list-group-flush">
                @foreach($order->items as $item)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                        <span>${{ number_format($item->subtotal, 2) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <a href="{{ route('order.track.show') }}" class="btn btn-outline-secondary mt-3"><i class="fas fa-arrow-left"></i> Track Another Order</a>
    </div>
</body>
</html>
