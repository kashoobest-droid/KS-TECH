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
        .offer-card-modern { margin-top: 12px; border-radius: 12px; overflow: hidden; background: linear-gradient(135deg, #fff8f0 0%, #fff0e6 50%, #ffe8d9 100%); border: 1px solid rgba(255, 153, 0, 0.25); box-shadow: 0 2px 12px rgba(255, 153, 0, 0.08); }
        .offer-card-modern__inner { display: flex; gap: 14px; align-items: center; padding: 14px 16px; }
        .offer-card-modern__media { position: relative; flex-shrink: 0; width: 88px; height: 88px; border-radius: 10px; overflow: hidden; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .offer-card-modern__img { width: 100%; height: 100%; object-fit: cover; }
        .offer-card-modern__badge { position: absolute; bottom: 0; left: 0; right: 0; text-align: center; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; background: rgba(255, 153, 0, 0.95); color: #fff; padding: 3px 4px; }
        .offer-card-modern__body { flex: 1; min-width: 0; }
        .offer-card-modern__label { display: inline-block; font-size: 0.75rem; font-weight: 600; color: #c2410c; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .offer-card-modern__title { font-size: 1.05rem; font-weight: 700; color: #1a1a1a; margin: 0 0 6px 0; line-height: 1.25; }
        .offer-card-modern__desc { font-size: 0.85rem; color: #666; margin: 0 0 8px 0; line-height: 1.35; }
        .offer-card-modern__countdown { font-size: 0.8rem; color: #555; }
        .offer-card-modern__countdown-value { font-weight: 700; color: #c2410c; font-variant-numeric: tabular-nums; }
        .offer-card-modern__meta { font-size: 0.8rem; color: #666; }
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
                    @if($product->hasVisibleOffer())
                        @include('partials.offer_card', ['offer' => $product->offer])
                    @endif
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
    <script>
        (function(){
            document.querySelectorAll('.offer-card-modern__countdown-value[data-ends-at]').forEach(function(el){
                var end = new Date(el.getAttribute('data-ends-at')).getTime();
                function upd(){
                    var now = Date.now();
                    if(end <= now){ el.textContent = 'Expired'; return; }
                    var d = Math.floor((end - now) / 86400000), h = Math.floor(((end - now) % 86400000) / 3600000), m = Math.floor(((end - now) % 3600000) / 60000), s = Math.floor(((end - now) % 60000) / 1000);
                    el.textContent = (d > 0 ? d + 'd ' : '') + String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
                }
                upd();
                if(!el._offerTimer) el._offerTimer = setInterval(upd, 1000);
            });
        })();
    </script>
</body>
</html>
