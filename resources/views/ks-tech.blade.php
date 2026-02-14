<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>KS Tech Store - Your Tech Destination</title>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        /* Navbar Styling */
        .navbar-custom {
            background-color: #1a1a1a;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .navbar-custom .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: #ff9900 !important;
            letter-spacing: 1px;
        }

        .navbar-custom .nav-link {
            color: #ffffff !important;
            margin: 0 10px;
            transition: color 0.3s;
        }

        .navbar-custom .nav-link:hover {
            color: #ff9900 !important;
        }

        /* User avatar in navbar dropdown */
        .nav-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ff9900;
            margin-right: 8px;
            vertical-align: middle;
        }

        .nav-user-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 153, 0, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
            font-size: 1.1rem;
            color: #ff9900;
        }

        .search-container {
            flex: 1;
            margin: 0 20px;
        }

        .search-container input {
            border-radius: 5px;
            padding: 8px 15px;
            width: 100%;
            border: none;
        }

        /* Header Section */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .hero-section p {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        /* Category Filter Section */
        .category-section {
            background: white;
            padding: 20px 0;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
        }

        .category-btn {
            background: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 8px 20px;
            margin: 5px;
            transition: all 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        .category-btn:hover,
        .category-btn.active {
            background: #ff9900;
            color: white;
            border-color: #ff9900;
        }

        /* Product Card Styling */
        .product-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            transform: translateY(-5px);
        }

        .product-image-container {
            position: relative;
            overflow: hidden;
            background: #f9f9f9;
            height: 250px;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .product-card:hover .product-image-container img {
            transform: scale(1.05);
        }

        .carousel-control-prev, .carousel-control-next {
            background: rgba(0,0,0,0.3);
            border-radius: 50%;
            width: 35px;
            height: 35px;
            top: 50%;
            transform: translateY(-50%);
        }

        .product-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff9900;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.85rem;
            font-weight: bold;
        }

        .product-body {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-name {
            font-size: 1.05rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
            line-height: 1.3;
            min-height: 2.6em;
        }

        .product-description {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 10px;
            flex-grow: 1;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-info {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 8px;
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: bold;
            color: #ff9900;
            margin: 10px 0;
        }

        .category-badge {
            display: inline-block;
            background: #e8f4f8;
            color: #0066cc;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            margin-bottom: 10px;
        }

        .product-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .btn-add-cart {
            flex: 1;
            background: #ff9900;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-weight: 600;
            transition: background 0.3s;
            cursor: pointer;
        }

        .btn-add-cart:hover {
            background: #e68a00;
            color: white;
            text-decoration: none;
        }

        .btn-wishlist {
            padding: 10px 15px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-wishlist:hover {
            border-color: #ff9900;
            color: #ff9900;
        }

        .btn-wishlist.active {
            border-color: #ff9900;
            color: #ff9900;
        }

        .btn-wishlist.active i {
            color: #e74c3c;
        }

        .btn-in-cart {
            background: #28a745 !important;
        }

        .btn-in-cart:hover {
            background: #218838 !important;
            color: white !important;
        }

        .favorite-form { margin: 0; }

        /* No Products Message */
        .no-products {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .no-products i {
            font-size: 4rem;
            color: #ccc;
            margin-bottom: 20px;
        }

        /* Footer */
        .footer-custom {
            background: #1a1a1a;
            color: white;
            padding: 40px 0 20px;
            margin-top: 60px;
        }

        .footer-custom h6 {
            color: white;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .footer-custom p, .footer-custom li {
            color: rgba(255,255,255,0.85);
        }

        .footer-custom a {
            color: #ff9900;
            text-decoration: none;
        }

        .footer-custom a:hover {
            color: #ffb84d;
            text-decoration: underline;
        }

        /* Social media icons - styled as before */
        .footer-custom .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 153, 0, 0.2);
            color: #ff9900;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            text-decoration: none !important;
        }

        .footer-custom .social-links a:hover {
            background: #ff9900;
            color: #1a1a1a;
            transform: translateY(-3px);
            text-decoration: none !important;
        }

        .footer-custom .social-links a.me-3 {
            margin-right: 12px !important;
        }

        /* Offer card - modern */
        .offer-card-modern {
            margin-top: 12px;
            border-radius: 12px;
            overflow: hidden;
            background: linear-gradient(135deg, #fff8f0 0%, #fff0e6 50%, #ffe8d9 100%);
            border: 1px solid rgba(255, 153, 0, 0.25);
            box-shadow: 0 2px 12px rgba(255, 153, 0, 0.08);
        }
        .offer-card-modern__inner {
            display: flex;
            gap: 14px;
            align-items: center;
            padding: 12px 14px;
        }
        .offer-card-modern__media {
            position: relative;
            flex-shrink: 0;
            width: 72px;
            min-width: 72px;
            height: 72px;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .offer-card-modern__img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        .offer-card-modern__badge {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: rgba(255, 153, 0, 0.95);
            color: #fff;
            padding: 2px 4px;
        }
        .offer-card-modern__body { flex: 1; min-width: 0; }
        .offer-card-modern__label {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 600;
            color: #c2410c;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .offer-card-modern__title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 4px 0;
            line-height: 1.25;
        }
        .offer-card-modern__desc {
            font-size: 0.8rem;
            color: #666;
            margin: 0 0 6px 0;
            line-height: 1.35;
        }
        .offer-card-modern__countdown {
            font-size: 0.75rem;
            color: #555;
        }
        .offer-card-modern__countdown-label { margin-right: 4px; }
        .offer-card-modern__countdown-value {
            font-weight: 700;
            color: #c2410c;
            font-variant-numeric: tabular-nums;
        }
        .offer-card-modern__meta { font-size: 0.75rem; color: #666; }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 1.8rem;
            }

            .search-container {
                margin: 15px 0;
            }

            .product-card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="fas fa-microchip"></i> KS TECH
            </a>
            
            <div class="search-container d-none d-lg-block">
                <form action="{{ url('/') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search products, brands, and more..." value="{{ request('q') }}">
                        <button class="btn btn-warning" type="submit">Search</button>
                    </div>
                </form>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="fas fa-box"></i> Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ auth()->check() ? route('cart.index') : route('login') }}">
                            <i class="fas fa-shopping-cart"></i> Cart
                            @if(isset($cartCount) && $cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ auth()->check() ? route('favorites.index') : route('login') }}"><i class="fas fa-heart"></i> Favorites</a>
                    </li>
                    @php use Illuminate\Support\Facades\Auth; @endphp
                    @if(Auth::check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar" class="nav-user-avatar">
                                @else
                                    <span class="nav-user-icon"><i class="fas fa-user"></i></span>
                                @endif
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-box"></i> My Orders</a></li>
                                @if(Auth::user()->is_admin)
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}"><i class="fas fa-box"></i> Manage Orders</a></li>
                                    <li><a class="dropdown-item" href="{{ route('product.index') }}"><i class="fas fa-boxes"></i> Manage Products</a></li>
                                    <li><a class="dropdown-item" href="{{ route('category.index') }}"><i class="fas fa-list"></i> Manage Categories</a></li>
                                    <li><a class="dropdown-item" href="{{ route('users.index') }}"><i class="fas fa-users-cog"></i> Manage Users</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item" style="border: none; background: none; cursor: pointer;">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Sign In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Sign Up</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1>Welcome to KS Tech Store</h1>
            <p>Discover the Latest Tech Gadgets at Unbeatable Prices</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container my-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <!-- Category Filter -->
        <div class="category-section">
            <div class="d-flex justify-content-center flex-wrap">
                <a href="{{ url('/') }}" class="category-btn {{ request()->has('category') ? '' : 'active' }}">
                    <i class="fas fa-cube"></i> All Products
                </a>

                @foreach($categories as $category)
                    <a href="{{ url('/?category=' . $category->id) }}" class="category-btn {{ request('category') == $category->id ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Products Grid -->
        <div class="row" id="productsContainer">
            @if($products->isEmpty())
                <div class="col-12">
                    <div class="no-products">
                        <i class="fas fa-inbox"></i>
                        <h3>No Products Available</h3>
                        <p>Check back soon for amazing tech products!</p>
                    </div>
                </div>
            @else
                @foreach($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4 product-item" data-category="{{ $product->Category_id }}">
                        <div class="product-card">
                            <!-- Product Image -->
                            <div class="product-image-container position-relative">
                                @if($product->images->count())
                                    <div id="carouselProduct{{ $product->id }}" class="carousel slide h-100" data-bs-ride="carousel">
                                        <div class="carousel-inner h-100">
                                            @foreach($product->images as $img)
                                                <div class="carousel-item @if($loop->first) active @endif h-100">
                                                    <img src="{{ filter_var($img->image_path, FILTER_VALIDATE_URL) ? $img->image_path : asset($img->image_path) }}" class="d-block w-100" alt="{{ $product->name }}">
                                                </div>
                                            @endforeach
                                        </div>
                                        @if($product->images->count() > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselProduct{{ $product->id }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselProduct{{ $product->id }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon"></span>
                                            </button>
                                        @endif
                                    </div>
                                @else
                                    <img src="https://via.placeholder.com/300x250?text=No+Image" class="w-100 h-100" alt="No Image">
                                @endif
                                <div class="product-badge {{ $product->quantity < 1 ? 'bg-danger' : '' }}">
                                    {{ $product->quantity < 1 ? 'Out of Stock' : 'In Stock' }}
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="product-body">
                                <span class="category-badge">{{ optional($product->category)->name ?? 'Uncategorized' }}</span>
                                <h6 class="product-name"><a href="{{ route('product.show', $product) }}" class="text-dark text-decoration-none">{{ $product->name }}</a></h6>
                                <p class="product-description">{{ $product->description }}</p>

                                <div class="product-info">
                                    <i class="fas fa-box"></i> Stock: <strong>{{ $product->quantity }}</strong>
                                </div>

                                <div class="product-price">
                                    ${{ number_format($product->price, 2) }}
                                </div>

                                @if($product->hasVisibleOffer())
                                    @include('partials.offer_card', ['offer' => $product->offer])
                                @endif

                                <!-- Action Buttons -->
                                <div class="product-actions">
                                    @auth
                                        @if($product->quantity < 1)
                                            <button type="button" class="btn-add-cart w-100" disabled style="opacity: 0.6; cursor: not-allowed;">
                                                <i class="fas fa-times-circle"></i> Out of Stock
                                            </button>
                                        @else
                                        <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-grow-1">
                                            @csrf
                                            <button type="submit" class="btn-add-cart w-100 {{ isset($cartProductIds[$product->id]) ? 'btn-in-cart' : '' }}">
                                                @if(isset($cartProductIds[$product->id]))
                                                    <i class="fas fa-check"></i> In Cart ({{ $cartQuantities[$product->id] ?? 1 }})
                                                @else
                                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                                @endif
                                            </button>
                                        </form>
                                        @endif
                                        <form action="{{ route('favorites.toggle', $product) }}" method="POST" class="favorite-form">
                                            @csrf
                                            <button type="submit" class="btn-wishlist {{ isset($favoriteProductIds[$product->id]) ? 'active' : '' }}" title="{{ isset($favoriteProductIds[$product->id]) ? 'Remove from Favorites' : 'Add to Favorites' }}">
                                                <i class="{{ isset($favoriteProductIds[$product->id]) ? 'fas' : 'far' }} fa-heart"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="btn-add-cart text-decoration-none text-center d-flex align-items-center justify-content-center" style="flex: 1;">
                                            <i class="fas fa-sign-in-alt"></i> Sign in to Add to Cart
                                        </a>
                                        <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="btn-wishlist" title="Sign in to add to favorites">
                                            <i class="far fa-heart"></i>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        @if($products->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="footer-custom">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h6>About Us</h6>
                    <p>KS Tech Store is your premier destination for high-quality tech products at competitive prices.</p>
                </div>
                <div class="col-md-3 mb-4">
                    <h6>Quick Links</h6>
                    <ul style="list-style: none; padding: 0;">
                        <li><a href="/">Home</a></li>
                        <li><a href="/">Products</a></li>
                        <li><a href="/">Categories</a></li>
                        <li><a href="/">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h6>Customer Service</h6>
                    <ul style="list-style: none; padding: 0;">
                        <li><a href="/">Track Order</a></li>
                        <li><a href="/">Returns</a></li>
                        <li><a href="/">Shipping Info</a></li>
                        <li><a href="/">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h6>Follow Us</h6>
                    <div class="social-links">
                        <a href="https://www.facebook.com/profile.php?id=61587774225578" target="_blank" rel="noopener noreferrer" class="me-3" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://x.com/KashooTech" target="_blank" rel="noopener noreferrer" class="me-3" title="X (Twitter)"><i class="fab fa-x-twitter"></i></a>
                        <a href="https://www.instagram.com/kstech_no/" target="_blank" rel="noopener noreferrer" class="me-3" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/in/kashoo-tech-a806723b0/" target="_blank" rel="noopener noreferrer" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center">
                <p>&copy; 2026 KS Tech Store. All Rights Reserved. | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
            </div>
        </div>
    </footer>

    <script>
        (function(){
            function runOfferCountdowns(){
                document.querySelectorAll('.offer-card-modern__countdown-value[data-ends-at]').forEach(function(el){
                    var end = new Date(el.getAttribute('data-ends-at')).getTime();
                    function upd(){
                        var now = Date.now();
                        if(end <= now){ el.textContent = 'Expired'; return; }
                        var d = Math.floor((end - now) / 86400000);
                        var h = Math.floor(((end - now) % 86400000) / 3600000);
                        var m = Math.floor(((end - now) % 3600000) / 60000);
                        var s = Math.floor(((end - now) % 60000) / 1000);
                        el.textContent = (d > 0 ? d + 'd ' : '') + String(h).padStart(2,'0') + ':' + String(m).padStart(2,'0') + ':' + String(s).padStart(2,'0');
                    }
                    upd();
                    if(!el._offerTimer) el._offerTimer = setInterval(upd, 1000);
                });
            }
            if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', runOfferCountdowns);
            else runOfferCountdowns();
        })();
    </script>
</body>
</html>