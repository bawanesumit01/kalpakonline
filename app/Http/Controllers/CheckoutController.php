<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Helper: get identifier for current user/guest
    private function cartIdentifier()
    {
        if (auth()->check()) {
            return ['user_id' => auth()->id(), 'session_id' => null];
        }
        return ['user_id' => null, 'session_id' => session()->getId()];
    }

    // Show checkout page
    public function index()
    {
        $identifier = $this->cartIdentifier();
        $cartItems = Cart::where($identifier)->with('product')->get();

        // Redirect to cart if empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty');
        }

        // Calculate totals
        $subtotal = $cartItems->sum(fn($item) => $item->product->final_price * $item->quantity);
        
        // Shipping: Free if subtotal >= 499, else 40
        $shipping = $subtotal >= 499 ? 0 : 40;
        
        // Tax: 5% of subtotal
        $tax = $subtotal * 0.05;
        
        // Total
        $total = $subtotal + $shipping + $tax;

        $categories = Category::all();

        return view('home.checkout', compact('cartItems', 'subtotal', 'shipping', 'tax', 'total', 'categories'));
    }

    // Process checkout (handle order placement)
    public function process(Request $request)
    {
        try {
            // Validate form data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20|regex:/^[0-9+\s\-()]*$/',
                'address' => 'required|string|max:500',
                'address_line2' => 'nullable|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'pincode' => 'required|string|size:6|regex:/^[0-9]{6}$/',
                'country' => 'nullable|string|max:100',
                'payment_method' => 'required|in:cod,online,wallet',
                'order_notes' => 'nullable|string|max:1000',
                'promo_code' => 'nullable|string|max:50',
            ]);

            $identifier = $this->cartIdentifier();
            $cartItems = Cart::where($identifier)->with('product')->get();

            // Check if cart is empty
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.view')->with('error', 'Your cart is empty');
            }

            // Calculate totals
            $subtotal = $cartItems->sum(fn($item) => $item->product->final_price * $item->quantity);
            $shipping = $subtotal >= 499 ? 0 : 40;
            $tax = $subtotal * 0.05;
            $total = $subtotal + $shipping + $tax;

            DB::beginTransaction();

            // Extract phone number (remove spaces, +, -)
            $phone = preg_replace('/[^0-9]/', '', $validated['phone']);

            $userId = null;
            $user = null;

            // Check if user is logged in
            if (auth()->check()) {
                $userId = auth()->id();
                $user = auth()->user();
            } else {
                // Check if phone number already exists
                $existingUser = User::where('mobile', $phone)->first();

                if ($existingUser) {
                    // Phone already exists - use existing user, DON'T CREATE NEW USER
                    $userId = $existingUser->id;
                    $user = $existingUser;
                } else {
                    // Phone doesn't exist - NO USER CREATED for guest checkout
                    // Guest checkout will have user_id = null
                    $userId = null;
                }
            }

            // Save address to user_addresses table (only if user exists)
            if ($userId) {
                UserAddress::create([
                    'user_id' => $userId,
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $phone,
                    'address' => $validated['address'],
                    'address_line2' => $validated['address_line2'],
                    'city' => $validated['city'],
                    'state' => $validated['state'],
                    'pincode' => $validated['pincode'],
                    'country' => $validated['country'] ?? 'India',
                    'is_default' => false,
                    'address_type' => 'home',
                ]);
            }

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $userId,
                'session_id' => !auth()->check() ? session()->getId() : null,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $phone,
                'address' => $validated['address'],
                'address_line2' => $validated['address_line2'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'pincode' => $validated['pincode'],
                'country' => $validated['country'] ?? 'India',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'order_notes' => $validated['order_notes'] ?? null,
                'promo_code' => $validated['promo_code'] ?? null,
                'discount' => 0,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'status' => 'pending',
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->product_name ?? $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->product->final_price,
                    'subtotal' => $item->product->final_price * $item->quantity,
                ]);
            }

            // Clear cart
            Cart::where($identifier)->delete();

            DB::commit();

            // Redirect to order success page with order details
            return redirect()->route('order.success', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Order creation failed: ' . $e->getMessage(), [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'An error occurred: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Show order success page
     */
    public function success($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);

        // Check if order belongs to current user/session
        if (auth()->check()) {
            if ($order->user_id !== auth()->id()) {
                abort(403);
            }
        } else {
            if ($order->session_id !== session()->getId()) {
                abort(403);
            }
        }

        $categories = Category::all();

        return view('home.order-success', compact('order', 'categories'));
    }
}

