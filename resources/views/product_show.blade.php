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
        .offer-card-modern__media { position: relative; flex-shrink: 0; width: 88px; min-width: 88px; height: 88px; border-radius: 10px; overflow: hidden; background: #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .offer-card-modern__img { display: block; width: 100%; height: 100%; object-fit: cover; object-position: center; }
        .offer-card-modern__badge { position: absolute; bottom: 0; left: 0; right: 0; text-align: center; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; background: rgba(255, 153, 0, 0.95); color: #fff; padding: 3px 4px; }
        .offer-card-modern__body { flex: 1; min-width: 0; }
        .offer-card-modern__label { display: inline-block; font-size: 0.75rem; font-weight: 600; color: #c2410c; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .offer-card-modern__title { font-size: 1.05rem; font-weight: 700; color: #1a1a1a; margin: 0 0 6px 0; line-height: 1.25; }
        .offer-card-modern__desc { font-size: 0.85rem; color: #666; margin: 0 0 8px 0; line-height: 1.35; }
        .offer-card-modern__countdown { font-size: 0.8rem; color: #555; }
        .offer-card-modern__countdown-value { font-weight: 700; color: #c2410c; font-variant-numeric: tabular-nums; }
        .offer-card-modern__meta { font-size: 0.8rem; color: #666; }
        
        /* Share buttons styling */
        .share-buttons { 
            display: flex; 
            gap: 8px; 
            flex-wrap: wrap; 
            align-items: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }
        .share-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            text-decoration: none !important;
        }
        .share-btn-twitter { background: #1DA1F2; color: white; }
        .share-btn-twitter:hover { background: #1a8cd8; transform: translateY(-2px); }
        .share-btn-facebook { background: #1877F2; color: white; }
        .share-btn-facebook:hover { background: #0a66c2; transform: translateY(-2px); }
        .share-btn-whatsapp { background: #25D366; color: white; }
        .share-btn-whatsapp:hover { background: #1fa856; transform: translateY(-2px); }
        
        /* Review card styling */
        .review-card {
            background: white;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }
        .review-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 10px;
        }
        .review-actions {
            display: flex;
            gap: 5px;
        }
        .review-actions .btn-sm {
            padding: 4px 8px;
            font-size: 0.75rem;
        }
        .review-reactions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #f0f0f0;
        }
        .reaction-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 20px;
            background: white;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #666;
        }
        .reaction-btn:hover {
            border-color: #ff9900;
            color: #ff9900;
        }
        .reaction-btn.active {
            background: #ff9900;
            color: white;
            border-color: #ff9900;
        }
        .btn-action-group {
            display: flex;
            gap: 8px;
        }
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
        @include('partials.breadcrumbs', [
            'items' => [
                ['label' => 'Home', 'url' => url('/')],
                ['label' => optional($product->category)->name ?? 'Products', 'url' => $product->category ? url('/?category=' . $product->category->id) : url('/')],
                ['label' => $product->name, 'url' => ''],
            ]
        ])
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
                            @if($product->quantity < 5)<span class="text-danger small">(Only {{ $product->quantity }} left!)</span>@endif
                        @endif
                    </p>
                    <h3 class="text-warning mb-4">${{ number_format($product->price, 2) }}</h3>
                    @if($product->hasVisibleOffer())
                        @include('partials.offer_card', ['offer' => $product->offer])
                    @endif
                    @auth
                        <div class="d-flex gap-2 mt-3">
                            @if($product->quantity < 1)
                                <button type="button" class="btn btn-secondary btn-lg flex-grow-1" disabled><i class="fas fa-times-circle"></i> Out of Stock</button>
                            @else
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-lg w-100"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                            </form>
                            @endif
                            <form action="{{ route('favorites.toggle', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-lg"><i class="far fa-heart"></i> <span class="d-none d-sm-inline ms-2">Favorites</span></button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-warning btn-lg mt-3 w-100"><i class="fas fa-sign-in-alt"></i> Sign in to Add to Cart</a>
                    @endauth
                    @if($product->quantity < 1)
                        <div id="notify-me" class="mt-3 p-3 rounded border border-success bg-success bg-opacity-10">
                            <p class="mb-2 fw-bold text-success"><i class="fas fa-bell"></i> Want this when it's back?</p>
                            <p class="small text-muted mb-2">Enter your email and we'll notify you as soon as it's in stock.</p>
                            <form action="{{ route('stock-notify.store', $product) }}" method="POST" class="d-flex gap-2 flex-wrap">
                                @csrf
                                <input type="email" name="email" class="form-control" style="max-width: 220px;" placeholder="Your email" required>
                                <button type="submit" class="btn btn-success"><i class="fas fa-bell"></i> Notify me</button>
                            </form>
                            @if(session('success'))<p class="small text-success mb-0 mt-2">{{ session('success') }}</p>@endif
                            @if(session('info'))<p class="small text-info mb-0 mt-2">{{ session('info') }}</p>@endif
                        </div>
                    @endif
                    
                    <!-- Rate this product (only for verified buyers) -->
                    <div id="rate-product" class="mt-4 p-3 rounded border bg-light">
                        <h5 class="mb-2"><i class="fas fa-star text-warning"></i> Rate this product</h5>
                        @php $avg = $product->averageRating(); @endphp
                        @if($product->reviews->count() > 0)
                            <p class="mb-3 small"><span class="text-warning">@for($i=1;$i<=5;$i++)<i class="{{ $i <= round($avg) ? 'fas' : 'far' }} fa-star"></i>@endfor</span> {{ number_format($avg, 1) }} ({{ $product->reviews->count() }} review{{ $product->reviews->count() !== 1 ? 's' : '' }})</p>
                        @endif
                        @auth
                            @if($product->hasPurchasedBy(auth()->user()))
                                <form action="{{ route('review.store', $product) }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                        <label class="form-label small">Your rating (click stars)</label>
                                        <div class="d-flex gap-1 align-items-center" id="rating-stars">
                                            @for($i=1;$i<=5;$i++)
                                                <label class="mb-0" style="cursor:pointer;" title="{{ $i }} star{{ $i !== 1 ? 's' : '' }}">
                                                    <input type="radio" name="rating" value="{{ $i }}" class="d-none" {{ old('rating') == $i ? 'checked' : '' }} required>
                                                    <i class="far fa-star text-warning fs-5 rating-star" data-value="{{ $i }}"></i>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">Your review (optional)</label>
                                        <textarea name="comment" class="form-control form-control-sm" rows="2" placeholder="Write a short review...">{{ old('comment') }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-paper-plane"></i> Submit review</button>
                                </form>
                                @if(session('review_success'))<p class="small text-success mt-2 mb-0"><i class="fas fa-check-circle"></i> {{ session('review_success') }}</p>@endif
                            @else
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle"></i> <strong>Only verified buyers can leave reviews.</strong> 
                                    <br><small class="mt-1 d-block">Purchase this product first to share your honest feedback and help other customers make informed decisions.</small>
                                </div>
                            @endif
                        @else
                            <p class="small mb-0"><a href="{{ route('login') }}">Sign in</a> to rate and review this product. (Only verified buyers can review)</p>
                        @endauth
                    </div>

                    <div class="share-buttons">
                        <span class="small text-muted fw-bold">Share:</span>
                        @php $productUrl = route('product.show', $product); $productName = $product->name; @endphp
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode($productUrl) }}&text={{ urlencode($productName) }}" target="_blank" rel="noopener" class="share-btn share-btn-twitter" title="Share on X/Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($productUrl) }}" target="_blank" rel="noopener" class="share-btn share-btn-facebook" title="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://wa.me/?text={{ urlencode($productName . ' ' . $productUrl) }}" target="_blank" rel="noopener" class="share-btn share-btn-whatsapp" title="Share on WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
        <div class="mt-5">
            <h4 class="mb-3">You might also like</h4>
            <div class="row g-3">
                @foreach($relatedProducts as $rel)
                <div class="col-6 col-md-3">
                    <a href="{{ route('product.show', $rel) }}" class="text-decoration-none text-dark">
                        <div class="card h-100">
                            @if($rel->images->first())
                                <img src="{{ filter_var($rel->images->first()->image_path, FILTER_VALIDATE_URL) ? $rel->images->first()->image_path : asset($rel->images->first()->image_path) }}" class="card-img-top" style="height:160px;object-fit:cover" alt="">
                            @else
                                <img src="https://via.placeholder.com/200x160?text=No+Image" class="card-img-top" style="height:160px;object-fit:cover" alt="">
                            @endif
                            <div class="card-body py-2">
                                <h6 class="card-title small">{{ Str::limit($rel->name, 40) }}</h6>
                                <p class="mb-0 text-warning fw-bold">${{ number_format($rel->price, 2) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="mt-5 bg-white rounded shadow-sm p-4">
            <h4 class="mb-4"><i class="fas fa-comments"></i> Customer reviews</h4>
            @php $avg = $product->averageRating(); @endphp
            @if($product->reviews->count() > 0)
                <div class="mb-4 p-3 bg-light rounded">
                    <div class="d-flex gap-2 align-items-center">
                        <span class="text-warning fs-5">@for($i=1;$i<=5;$i++)<i class="{{ $i <= round($avg) ? 'fas' : 'far' }} fa-star"></i>@endfor</span>
                        <span class="fw-bold">{{ number_format($avg, 1) }}/5.0</span>
                        <span class="text-muted small">({{ $product->reviews->count() }} review{{ $product->reviews->count() !== 1 ? 's' : '' }})</span>
                    </div>
                </div>
                @foreach($product->reviews as $review)
                    <div class="review-card">
                        <div class="review-header">
                            <div class="flex-grow-1">
                                <div class="d-flex gap-2 align-items-center mb-2">
                                    <strong>{{ $review->user->name ?? 'User' }}</strong>
                                    <span class="text-warning small">
                                        @for($i=1;$i<=5;$i++)<i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>@endfor
                                    </span>
                                    <span class="text-muted small">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                @if($review->comment)
                                    <p class="mb-0 text-muted">{{ $review->comment }}</p>
                                @endif
                            </div>
                            @if(auth()->check() && auth()->user()->id === $review->user_id)
                                <div class="review-actions">
                                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editReviewModal{{ $review->id }}" title="Edit review"><i class="fas fa-edit"></i></button>
                                    <form action="{{ route('review.destroy', $review) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete review"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Reactions -->
                        @auth
                            <div class="review-reactions">
                                <form action="{{ route('review.react', $review) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="reaction_type" value="helpful">
                                    <button type="submit" class="reaction-btn {{ $review->userReaction(auth()->user()) && $review->userReaction(auth()->user())->reaction_type === 'helpful' ? 'active' : '' }}" title="Mark as helpful">
                                        <i class="fas fa-thumbs-up"></i>
                                        <span>{{ $review->helpfulCount() }}</span>
                                    </button>
                                </form>
                                <form action="{{ route('review.react', $review) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="reaction_type" value="not_helpful">
                                    <button type="submit" class="reaction-btn {{ $review->userReaction(auth()->user()) && $review->userReaction(auth()->user())->reaction_type === 'not_helpful' ? 'active' : '' }}" title="Mark as not helpful">
                                        <i class="fas fa-thumbs-down"></i>
                                        <span>{{ $review->notHelpfulCount() }}</span>
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="review-reactions">
                                <span class="small text-muted"><a href="{{ route('login') }}">Sign in</a> to rate this review</span>
                            </div>
                        @endauth
                    </div>

                    <!-- Edit Review Modal -->
                    @if(auth()->check() && auth()->user()->id === $review->user_id)
                        <div class="modal fade" id="editReviewModal{{ $review->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Review</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('review.update', $review) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Rating</label>
                                                <div class="d-flex gap-1" id="editRatingStars{{ $review->id }}">
                                                    @for($i=1;$i<=5;$i++)
                                                        <label style="cursor:pointer; font-size: 1.5rem;">
                                                            <input type="radio" name="rating" value="{{ $i }}" {{ $review->rating == $i ? 'checked' : '' }} class="d-none">
                                                            <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star text-warning edit-rating-star" data-value="{{ $i }}" data-modal="{{ $review->id }}"></i>
                                                        </label>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Review (optional)</label>
                                                <textarea name="comment" class="form-control" rows="3">{{ $review->comment }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle"></i> No customer reviews yet. Be the first to share your feedback!
                </div>
            @endif
        </div>
    </div>
    <script>
        // Rating stars interactivity for main review form
        (function(){
            var container = document.getElementById('rating-stars');
            if (!container) return;
            var stars = container.querySelectorAll('.rating-star');
            var radios = container.querySelectorAll('input[name="rating"]');
            function updateStars(val) {
                var v = parseInt(val, 10);
                stars.forEach(function(s) {
                    var sv = parseInt(s.getAttribute('data-value'), 10);
                    s.className = 'text-warning fs-5 rating-star ' + (sv <= v ? 'fas' : 'far') + ' fa-star';
                });
            }
            stars.forEach(function(star) {
                star.addEventListener('click', function(e) {
                    e.preventDefault();
                    var v = parseInt(this.getAttribute('data-value'), 10);
                    radios.forEach(function(r) { r.checked = (parseInt(r.value, 10) === v); });
                    updateStars(v);
                });
            });
            var checked = container.querySelector('input[name="rating"]:checked');
            if (checked) updateStars(checked.value);
        })();

        // Rating stars interactivity for edit review modals
        document.querySelectorAll('.edit-rating-star').forEach(function(star) {
            star.addEventListener('click', function(e) {
                e.preventDefault();
                var v = parseInt(this.getAttribute('data-value'), 10);
                var modalId = this.getAttribute('data-modal');
                var modalContainer = document.querySelector('#editReviewModal' + modalId + ' .modal-body');
                var radios = modalContainer.querySelectorAll('input[name="rating"]');
                var stars = document.querySelectorAll('.edit-rating-star[data-modal="' + modalId + '"]');
                
                radios.forEach(function(r) { 
                    r.checked = (parseInt(r.value, 10) === v); 
                });
                stars.forEach(function(s) {
                    var sv = parseInt(s.getAttribute('data-value'), 10);
                    s.className = (sv <= v ? 'fas' : 'far') + ' fa-star text-warning edit-rating-star';
                });
            });
        });

        // Offer countdown timer
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
