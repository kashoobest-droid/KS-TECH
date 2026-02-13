<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('product.images', 'product.category')->get();
        $cartCount = $cartItems->sum('quantity');
        return view('cart', compact('cartItems', 'cartCount'));
    }

    public function add(products $product, Request $request)
    {
        $quantity = $request->input('quantity', 1);
        $quantity = max(1, min((int) $quantity, $product->quantity ?? 999));

        $item = CartItem::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        $item->quantity = $item->exists ? $item->quantity + $quantity : $quantity;
        $item->save();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Product added to cart!']);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }
        $cartItem->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Item removed from cart.');
    }

    public function updateQuantity(CartItem $cartItem, Request $request)
    {
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }

        $quantity = max(1, min((int) $request->input('quantity', 1), $cartItem->product->quantity ?? 999));
        $cartItem->update(['quantity' => $quantity]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'quantity' => $quantity]);
        }

        return back();
    }
}
