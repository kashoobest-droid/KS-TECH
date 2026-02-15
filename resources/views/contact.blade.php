<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Contact Us - KS Tech Store</title>
    <style>
        body { background: #f5f5f5; }
        .navbar-custom { background: #1a1a1a; }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link { color: #ff9900 !important; }
        .contact-card { max-width: 600px; margin: 0 auto; }
    </style>
</head>
<body>
    <nav class="navbar navbar-custom navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fas fa-microchip"></i> KS TECH</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link" href="{{ route('faq') }}">FAQ</a>
                <a class="nav-link" href="{{ route('order.track.show') }}">Track Order</a>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        <h2 class="mb-4"><i class="fas fa-envelope text-warning"></i> Contact Us</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="card contact-card shadow-sm">
            <div class="card-body p-4">
                <p class="text-muted">Have a question or feedback? Send us a message and we'll get back to you soon.</p>
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message *</label>
                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5" required>{{ old('message') }}</textarea>
                        @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-paper-plane"></i> Send Message</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
