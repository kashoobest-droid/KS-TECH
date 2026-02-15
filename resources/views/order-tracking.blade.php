<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Track Order - KS Tech Store</title>
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
                <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                <a class="nav-link" href="{{ route('faq') }}">FAQ</a>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        <h2 class="mb-4"><i class="fas fa-truck text-warning"></i> Track Your Order</h2>
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="card shadow-sm" style="max-width: 480px;">
            <div class="card-body p-4">
                <p class="text-muted small">Enter the order ID from your confirmation email and the email address you used when placing the order.</p>
                <form action="{{ route('order.track') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Order ID</label>
                        <input type="number" name="order_id" class="form-control" value="{{ old('order_id') }}" required placeholder="e.g. 123">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="your@email.com">
                    </div>
                    <button type="submit" class="btn btn-warning w-100"><i class="fas fa-search"></i> Track</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
