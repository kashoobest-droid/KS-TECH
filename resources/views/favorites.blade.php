<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <title>Favorites - KS Tech Store</title>
    <style>
        body { background-color: #f5f5f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto; }
        .navbar-custom { background-color: #1a1a1a; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .navbar-custom .navbar-brand { color: #ff9900 !important; font-size: 1.8rem; font-weight: bold; }
        .navbar-custom .nav-link { color: #ffffff !important; margin: 0 10px; transition: color 0.3s; }
        .navbar-custom .nav-link:hover { color: #ff9900 !important; }
        .navbar-custom .btn-link.nav-link { color: #ffffff !important; }
        .navbar-custom .btn-link.nav-link:hover { color: #ff9900 !important; }
        .fav-card { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; transition: transform 0.2s; }
        .fav-card:hover { transform: translateY(-3px); }
        .fav-img { height: 180px; object-fit: cover; }
        .btn-add-cart { background: #ff9900; color: white; border: none; }
        .btn-add-cart:hover { background: #e68a00; color: white; }
        .btn-remove-fav { color: #dc3545; }
        .btn-remove-fav:hover { color: #c82333; }
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
        <h2 class="mb-4"><i class="fas fa-heart text-danger"></i> Your Favorites</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($favorites->isEmpty())
            <div class="bg-white rounded shadow-sm p-5 text-center">
                <i class="fas fa-heart fa-4x text-muted mb-3"></i>
                <h4>No favorites yet</h4>
                <p class="text-muted">Save products you love by clicking the heart icon!</p>
                <a href="/" class="btn btn-warning mt-3"><i class="fas fa-shopping-bag"></i> Browse Products</a>
            </div>
        @else
            <div class="row g-4">
                @foreach($favorites as $fav)
                    <div class="col-md-4 col-lg-3">
                        <div class="fav-card h-100">
                            <a href="{{ route('product.show', $fav->product) }}" class="text-decoration-none text-dark">
                                @if($fav->product->images->first())
                                    <img src="{{ filter_var($fav->product->images->first()->image_path, FILTER_VALIDATE_URL) ? $fav->product->images->first()->image_path : asset($fav->product->images->first()->image_path) }}" class="fav-img w-100" alt="{{ $fav->product->name }}">
                                @else
                                    <img src="https://via.placeholder.com/300x180?text=No+Image" class="fav-img w-100" alt="">
                                @endif
                                <div class="p-3">
                                    <span class="badge bg-light text-dark">{{ optional($fav->product->category)->name }}</span>
                                    <h6 class="mt-2">{{ $fav->product->name }}</h6>
                                    <p class="text-warning fw-bold mb-2">${{ number_format($fav->product->price, 2) }}</p>
                                </div>
                            </a>
                            <div class="p-3 pt-0 d-flex gap-2">
                                <form action="{{ route('cart.add', $fav->product) }}" method="POST" class="flex-grow-1">
                                    @csrf
                                    <button type="submit" class="btn btn-add-cart w-100 btn-sm"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                                </form>
                                <form action="{{ route('favorites.remove', $fav->product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Remove from favorites"><i class="fas fa-heart-broken"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
