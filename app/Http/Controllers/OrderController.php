<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmed;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function checkout(Request $request)
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
        $coupon = null;
        $discount = 0.0;
        $total = $subtotal;
        if ($request->filled('coupon_code')) {
            $coupon = Coupon::where('code', strtoupper(trim($request->coupon_code)))->first();
            if ($coupon && $coupon->isValid($subtotal)) {
                $discount = $coupon->discountFor($subtotal);
                $total = max(0, $subtotal - $discount);
            }
        }

        return view('checkout', compact('cartItems', 'subtotal', 'coupon', 'discount', 'total'));
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
            'coupon_code' => 'nullable|string|max:50',
        ]);

        // Validate stock again
        foreach ($cartItems as $item) {
            if ($item->product->quantity < $item->quantity) {
                return redirect()->route('cart.index')->with('error', "Not enough stock for: {$item->product->name}. Available: {$item->product->quantity}");
            }
        }

        $shippingAddress = $user->formatShippingAddress();
        $phone = $user->phone;
        $subtotal = $cartItems->sum(fn ($i) => $i->product->price * $i->quantity);
        $coupon = null;
        $discount = 0.0;
        if ($request->filled('coupon_code')) {
            $coupon = Coupon::where('code', strtoupper(trim($request->coupon_code)))->first();
            if ($coupon && $coupon->isValid($subtotal)) {
                $discount = $coupon->discountFor($subtotal);
            }
        }
        $total = max(0, $subtotal - $discount);

        $order = null;
        DB::transaction(function () use ($user, $cartItems, $shippingAddress, $phone, $request, $coupon, $discount, $total, &$order) {
            $orderSubtotal = 0;
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'total' => $total,
                'shipping_address' => $shippingAddress,
                'phone' => $phone,
                'notes' => $request->notes,
                'coupon_id' => $coupon?->id,
                'discount' => $discount,
            ]);

            foreach ($cartItems as $item) {
                $itemSubtotal = $item->product->price * $item->quantity;
                $orderSubtotal += $itemSubtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $itemSubtotal,
                ]);

                $item->product->decrement('quantity', $item->quantity);
            }

            if ($coupon) {
                $coupon->increment('used_count');
            }

            $user->cartItems()->delete();
        });

        // Queue email so the request returns immediately. Prevents 502 on Railway.
        // On Railway: set QUEUE_CONNECTION=database and run a worker (see RAILWAY_DEPLOY.md).
        // If QUEUE_CONNECTION=sync, this still runs in-request and can timeout.
        try {
            Mail::to($user->email)->queue(new OrderConfirmed($order->fresh(['items'])));
        } catch (\Throwable $e) {
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
