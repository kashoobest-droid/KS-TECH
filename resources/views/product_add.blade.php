<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>Product add</title>
</head>
<body>
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height:100vh; padding:40px 0;">
        <div class="container">
            <div class="card mx-auto" style="max-width:900px; border-radius:12px; overflow:hidden;">
                <div class="row g-0">
                    <div class="col-md-4" style="background:#1a1a1a; color:white; display:flex; align-items:center; justify-content:center; padding:30px;">
                        <div style="text-align:center;">
                            <i class="fas fa-microchip" style="font-size:48px; color:#ff9900;"></i>
                            <h3 style="margin-top:12px;">KS Tech</h3>
                            <p style="opacity:0.9;">Add a new product</p>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="p-4">
    
    @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Validation Errors!</h4>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Validation Errors!</h4>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">  
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" required value="{{ old('price') }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" required value="{{ old('quantity') }}">
                @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Product Images (1-6)</label>
                <div id="dropZone" class="border border-primary rounded p-3 mb-2 text-center bg-light @error('images') border-danger @enderror" style="cursor:pointer;">
                    <span id="dropZoneText">Drag & drop images here or click to select (max 6)</span>
                    <input type="file" class="form-control d-none" name="images[]" accept="image/*" multiple id="imageInput">
                </div>
                <small class="form-text text-muted">You can select up to 6 images. Hold Ctrl (Windows/Linux) or Cmd (Mac) to select multiple files.</small>
                <div id="imagePreviewCarousel" class="carousel slide mt-3" data-bs-ride="carousel" style="display:none;max-width:350px;">
                    <div class="carousel-inner" id="carouselInner"></div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#imagePreviewCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#imagePreviewCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                @error('images')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image_urls" class="form-label">Image URLs (Alternative to files, one per line)</label>
                <textarea class="form-control @error('image_urls') is-invalid @enderror" id="image_urls" name="image_urls" rows="3" placeholder="https://example.com/image1.jpg&#10;https://example.com/image2.jpg">{{ old('image_urls') }}</textarea>
                <small class="form-text text-muted">You can paste image URLs here instead of uploading files. One URL per line.</small>
                @error('image_urls')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-warning">Add Product</button>
                        <a href="{{ route('product.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
            </div>
        </div>
    </div>

<script>
// Drag & drop and image preview carousel logic
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('imageInput');
    const dropZone = document.getElementById('dropZone');
    const dropZoneText = document.getElementById('dropZoneText');
    const carousel = document.getElementById('imagePreviewCarousel');
    const carouselInner = document.getElementById('carouselInner');

    function updatePreview(inputElement) {
        const files = Array.from(inputElement.files).slice(0, 6);
        carouselInner.innerHTML = '';
        
        if (files.length > 0) {
            files.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    const div = document.createElement('div');
                    div.className = 'carousel-item' + (idx === 0 ? ' active' : '');
                    div.innerHTML = `<img src="${ev.target.result}" class="d-block w-100" style="height:220px;object-fit:cover;" alt="Preview Image ${idx + 1}">`;
                    carouselInner.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
            carousel.style.display = 'block';
            dropZoneText.textContent = `Selected ${files.length} image${files.length > 1 ? 's' : ''}`;
        } else {
            carousel.style.display = 'none';
            dropZoneText.textContent = 'Drag & drop images here or click to select (max 6)';
        }
    }

    dropZone.addEventListener('click', () => imageInput.click());

    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropZone.classList.add('border-info', 'bg-info', 'bg-opacity-10');
        dropZoneText.textContent = 'Drop images here';
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropZone.classList.remove('border-info', 'bg-info', 'bg-opacity-10');
        if (imageInput.files.length === 0) {
            dropZoneText.textContent = 'Drag & drop images here or click to select (max 6)';
        }
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        dropZone.classList.remove('border-info', 'bg-info', 'bg-opacity-10');
        
        const droppedFiles = e.dataTransfer.files;
        if (droppedFiles.length > 0) {
            imageInput.files = droppedFiles;
            updatePreview(imageInput);
        }
    });

    imageInput.addEventListener('change', function(e) {
        updatePreview(imageInput);
    });
});
</script>
</body>
</html>