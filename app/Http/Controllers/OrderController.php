<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmed;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function checkout()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product.images', 'product.category')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Validate stock
        foreach ($cartItems as $item) {
            if ($item->product->quantity < $item->quantity) {
                return redirect()->route('cart.index')->with('error', "Not enough stock for: {$item->product->name}. Available: {$item->product->quantity}");
            }
        }

        $subtotal = $cartItems->sum(fn ($i) => $i->product->price * $i->quantity);

        return view('checkout', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        // Validate stock again
        foreach ($cartItems as $item) {
            if ($item->product->quantity < $item->quantity) {
                return redirect()->route('cart.index')->with('error', "Not enough stock for: {$item->product->name}. Available: {$item->product->quantity}");
            }
        }

        $shippingAddress = $user->formatShippingAddress();
        $phone = $user->phone;

        $order = null;
        DB::transaction(function () use ($user, $cartItems, $shippingAddress, $phone, $request, &$order) {
            $total = 0;
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'total' => 0,
                'shipping_address' => $shippingAddress,
                'phone' => $phone,
                'notes' => $request->notes,
            ]);

            foreach ($cartItems as $item) {
                $subtotal = $item->product->price * $item->quantity;
                $total += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $subtotal,
                ]);

                $item->product->decrement('quantity', $item->quantity);
            }

            $order->update(['total' => $total]);

            $user->cartItems()->delete();
        });

        // Use queue() so the request returns quickly. Do NOT use send() — it blocks and can cause 502 on Railway (request timeout).
        try {
            Mail::to($user->email)->queue(new OrderConfirmed($order->fresh(['items'])));
        } catch (\Exception $e) {
            report($e);
        }

        return redirect()->route('orders.index')->with('success', 'Order placed successfully! Confirmation email sent.');
    }

    public function index()
    {
        $orders = Auth::user()->orders()->with('items.product')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }

        $order->load('items.product.images');
        return view('orders.show', compact('order'));
    }

    public function adminIndex()
    {
        $orders = Order::with('user', 'items')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated.');
    }
}
