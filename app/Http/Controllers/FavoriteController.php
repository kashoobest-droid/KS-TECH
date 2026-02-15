<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('product.images', 'product.category')->get();
        $cartCount = Auth::user()->cartItems()->sum('quantity');
        return view('favorites', compact('favorites', 'cartCount'));
    }

    public function add(products $product)
    {
        Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Added to favorites!']);
        }

        return back()->with('success', 'Added to favorites!');
    }

    public function remove(products $product)
    {
        Favorite::where('user_id', Auth::id())->where('product_id', $product->id)->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Removed from favorites.']);
        }

        return back()->with('success', 'Removed from favorites.');
    }

    public function toggle(products $product)
    {
        $fav = Favorite::where('user_id', Auth::id())->where('product_id', $product->id)->first();

        if ($fav) {
            $fav->delete();
            $message = 'Removed from favorites!';
            $added = false;
        } else {
            Favorite::create(['user_id' => Auth::id(), 'product_id' => $product->id]);
            $message = 'Added to favorites!';
            $added = true;
        }

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'added' => $added, 'message' => $message]);
        }

        return back()->with('success', $message);
    }
}
