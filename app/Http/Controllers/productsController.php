<?php

namespace App\Http\Controllers;

use App\Models\products;
use Illuminate\Http\Request;
use App\Models\category;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class productsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = products::with('images', 'category', 'offer')->get();
        return view("product_index", compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = category::all();
        return view('product_add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $data = $request->all();
        $data['total'] = $request->input('price') * ($request->input('quantity') ?? 1);
        if (isset($data['category_id'])) {
            $data['Category_id'] = $data['category_id'];
            unset($data['category_id']);
        }
        $product = products::create($data);

        // Handle image uploads (files)
        $imageCount = 0;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid() && $imageCount < 6) {
                    $filename = uniqid('prodimg_').'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $filename);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'upload/'.$filename,
                    ]);
                    $imageCount++;
                }
            }
        }

        if ($imageCount < 1) {
            // Rollback product if no images provided
            $product->delete();
            return back()->withErrors(['images' => 'At least one valid image is required.'])->withInput();
        }

        return redirect()->route('product.index')->with('success', 'Product added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(products $product)
    {
        $product->load('images', 'category', 'offer');
        return view('product_show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
            public function edit(products $product)
    {
        // Laravel's Route Model Binding automatically fetches the product by ID
        $categories = category::all();
        return view('product_update', compact('product', 'categories'));
    }

    public function update(Request $request, products $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:255|string',
            'description' => 'nullable|string',
            'price'=> 'required|numeric|min:0',
            'quantity'=> 'required|integer|min:0',
            'category_id'=> 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'remove_images' => 'nullable|array',
        ]);

        // Map form's category_id to DB column name used in migration/model
        if (isset($validatedData['category_id'])) {
            $validatedData['Category_id'] = $validatedData['category_id'];
            unset($validatedData['category_id']);
        }
        $product->update($validatedData);

        // Remove selected images
        if ($request->filled('remove_images')) {
            $removeIds = $request->input('remove_images');
            foreach ($product->images()->whereIn('id', $removeIds)->get() as $img) {
                // Remove file if local
                if (!filter_var($img->image_path, FILTER_VALIDATE_URL) && file_exists(public_path($img->image_path))) {
                    @unlink(public_path($img->image_path));
                }
                $img->delete();
            }
        }

        // Count current images after removal
        $currentImageCount = $product->images()->count();

        // Add new images (files)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if ($file && $file->isValid() && $currentImageCount < 6) {
                    $filename = uniqid('prodimg_').'.'.$file->getClientOriginalExtension();
                    $file->move(public_path('upload'), $filename);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'upload/'.$filename,
                    ]);
                    $currentImageCount++;
                }
            }
        }

        // Ensure at least 1 image remains
        if ($product->images()->count() < 1) {
            return back()->withErrors(['images' => 'At least one image is required.']);
        }

        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = products::find($id);
        if (!$product) {
            return redirect()->route('product.index')->with('error', 'Product not found.');
        }
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    }

    /**
     * Display the storefront (home page) with all products
     */
    public function storefront(Request $request)
    {
        $q = $request->query('q');
        $categoryId = $request->query('category');
        $categories = category::all();

        $qb = products::query();

        if ($q) {
            $qb->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhereHas('category', function($q2) use ($q) {
                        $q2->where('name', 'like', "%{$q}%");
                    });
            });
        }

        if ($categoryId) {
            $qb->where('Category_id', $categoryId);
        }

        $products = $qb->with('images', 'category', 'offer')->paginate(12)->withQueryString();

        $cartProductIds = Auth::check() ? Auth::user()->cartItems()->pluck('product_id')->flip()->toArray() : [];
        $favoriteProductIds = Auth::check() ? Auth::user()->favorites()->pluck('product_id')->flip()->toArray() : [];
        $cartQuantities = Auth::check() ? Auth::user()->cartItems()->pluck('quantity', 'product_id')->toArray() : [];
        $cartCount = Auth::check() ? Auth::user()->cartItems()->sum('quantity') : 0;

        return view('ks-tech', compact('products', 'categories', 'q', 'categoryId', 'cartProductIds', 'favoriteProductIds', 'cartQuantities', 'cartCount'));
    }
}
