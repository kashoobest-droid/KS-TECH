<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Product Index</title>
</head>
<body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">
                    <i class="fas fa-microchip"></i> KS TECH
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" href="/"><i class="fas fa-home"></i> Home</a>
                        </li>
                        @php use Illuminate\Support\Facades\Auth; @endphp
                        @if(Auth::check())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> Profile</a></li>
                                    @if(Auth::user()->is_admin)
                                        <li><hr class="dropdown-divider"></li>
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

        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Products</h1>
                <a href="{{ route('product.create') }}" class="btn btn-warning">Add Product</a>
            </div>
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            @if($product->images->count())
                                <div id="carouselProduct{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach($product->images as $img)
                                            <div class="carousel-item @if($loop->first) active @endif">
                                                <img src="{{ filter_var($img->image_path, FILTER_VALIDATE_URL) ? $img->image_path : asset($img->image_path) }}" class="d-block w-100" alt="Product Image" style="height: 220px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($product->images->count() > 1)
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselProduct{{ $product->id }}" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselProduct{{ $product->id }}" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    @endif
                                </div>
                            @else
                                <img src="https://via.placeholder.com/350x220?text=No+Image" class="card-img-top" alt="No Image" style="height: 220px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->description }}</p>
                                <p class="card-text"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                                <p class="card-text"><strong>Category:</strong> {{ optional($product->category)->name ?? 'Unrecognized' }}</p>
                            </div>
                            <div class="card-footer bg-white border-0 d-flex justify-content-between">
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('product.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('product.destroy', $product->id) }}" class="btn btn-sm btn-danger" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this product?')) { this.closest('form').submit(); }">Delete</a>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
</body>
</html>