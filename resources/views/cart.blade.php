<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <title>Cart - KS Tech Store</title>
    <style>
        body { background-color: #f5f5f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto; }
        .navbar-custom { background-color: #1a1a1a; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .navbar-custom .navbar-brand { color: #ff9900 !important; font-size: 1.8rem; font-weight: bold; }
        .navbar-custom .nav-link { color: #ffffff !important; margin: 0 10px; transition: color 0.3s; }
        .navbar-custom .nav-link:hover { color: #ff9900 !important; }
        .navbar-custom .btn-link.nav-link { color: #ffffff !important; }
        .navbar-custom .btn-link.nav-link:hover { color: #ff9900 !important; }
        .cart-card { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
        .cart-item-img { width: 100px; height: 100px; object-fit: cover; border-radius: 8px; }
        .cart-total { font-size: 1.4rem; font-weight: bold; color: #ff9900; }
        .btn-remove { color: #dc3545; }
        .btn-remove:hover { color: #c82333; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fas fa-microchip"></i> KS TECH</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/"><i class="fas fa-home"></i> Home</a>
                <a class="nav-link" href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart"></i> Cart</a>
                <a class="nav-link" href="{{ route('favorites.index') }}"><i class="fas fa-heart"></i> Favorites</a>
                <a class="nav-link" href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> Profile</a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link" style="text-decoration:none;"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h2 class="mb-4"><i class="fas fa-shopping-cart text-warning"></i> Your Cart</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($cartItems->isEmpty())
            <div class="cart-card p-5 text-center">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                <h4>Your cart is empty</h4>
                <p class="text-muted">Add some tech products to get started!</p>
                <a href="/" class="btn btn-warning mt-3"><i class="fas fa-shopping-bag"></i> Continue Shopping</a>
            </div>
        @else
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-card">
                        @foreach($cartItems as $item)
                            <div class="p-4 border-bottom d-flex align-items-center gap-3">
                                <div class="flex-shrink-0">
                                    @if($item->product->images->first())
                                        <img src="{{ filter_var($item->product->images->first()->image_path, FILTER_VALIDATE_URL) ? $item->product->images->first()->image_path : asset($item->product->images->first()->image_path) }}" alt="" class="cart-item-img">
                                    @else
                                        <img src="https://via.placeholder.com/100?text=No+Image" alt="" class="cart-item-img">
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $item->product->name }}</h6>
                                    <small class="text-muted">{{ optional($item->product->category)->name }}</small>
                                    <p class="mb-0 mt-1 text-warning fw-bold">${{ number_format($item->product->price, 2) }}</p>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->quantity }}" class="form-control form-control-sm" style="width:70px;">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="fas fa-sync-alt"></i></button>
                                    </form>
                                    <form action="{{ route('cart.remove', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-remove"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                                <div class="text-end" style="min-width:80px;">
                                    ${{ number_format($item->product->price * $item->quantity, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart-card p-4">
                        <h5 class="mb-3">Order Summary</h5>
                        @php $subtotal = $cartItems->sum(fn($i) => $i->product->price * $i->quantity); @endphp
                        <p class="d-flex justify-content-between mb-2"><span>Subtotal ({{ $cartItems->sum('quantity') }} items)</span><span class="cart-total">${{ number_format($subtotal, 2) }}</span></p>
                        <hr>
                        <a href="{{ route('checkout') }}" class="btn btn-warning w-100 mb-2"><i class="fas fa-lock"></i> Proceed to Checkout</a>
                        <a href="/" class="btn btn-outline-secondary w-100"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</body>
</html>
