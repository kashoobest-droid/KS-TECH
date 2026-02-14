<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <title>{{ $product->name }} - KS Tech Store</title>
    <style>
        body { background-color: #f5f5f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto; }
        .navbar-custom { background-color: #1a1a1a; }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link { color: #ff9900 !important; }
        .product-detail-img { max-height: 400px; object-fit: contain; }
    </style>
</head>
<body>
    <nav class="navbar navbar-custom navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fas fa-microchip"></i> KS TECH</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link" href="{{ auth()->check() ? route('cart.index') : route('login') }}">Cart</a>
                <a class="nav-link" href="{{ auth()->check() ? route('favorites.index') : route('login') }}">Favorites</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <a href="{{ url()->previous() }}" class="text-muted text-decoration-none mb-3 d-inline-block"><i class="fas fa-arrow-left"></i> Back</a>
        <div class="row">
            <div class="col-md-6">
                @if($product->images->count())
                    <div id="productCarousel" class="carousel slide bg-white rounded shadow-sm overflow-hidden">
                        <div class="carousel-inner">
                            @foreach($product->images as $img)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <img src="{{ filter_var($img->image_path, FILTER_VALIDATE_URL) ? $img->image_path : asset($img->image_path) }}" class="d-block w-100 product-detail-img" alt="{{ $product->name }}">
                                </div>
                            @endforeach
                        </div>
                        @if($product->images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        @endif
                    </div>
                @else
                    <img src="https://via.placeholder.com/500x400?text=No+Image" class="img-fluid rounded shadow-sm" alt="">
                @endif
            </div>
            <div class="col-md-6">
                <div class="bg-white rounded shadow-sm p-4">
                    <span class="badge bg-secondary">{{ optional($product->category)->name ?? 'Uncategorized' }}</span>
                    <h2 class="mt-2">{{ $product->name }}</h2>
                    <p class="text-muted">{{ $product->description }}</p>
                    <p class="mb-2"><strong>Stock:</strong>
                        @if($product->quantity < 1)
                            <span class="text-danger">Out of stock</span>
                        @else
                            {{ $product->quantity }}
                        @endif
                    </p>
                    <h3 class="text-warning mb-4">${{ number_format($product->price, 2) }}</h3>
                    @auth
                        <div class="d-flex gap-2">
                            @if($product->quantity < 1)
                                <button type="button" class="btn btn-secondary btn-lg" disabled><i class="fas fa-times-circle"></i> Out of Stock</button>
                            @else
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-lg"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                            </form>
                            @endif
                            <form action="{{ route('favorites.toggle', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-lg"><i class="far fa-heart"></i> Add to Favorites</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-warning btn-lg"><i class="fas fa-sign-in-alt"></i> Sign in to Add to Cart</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</body>
</html>
