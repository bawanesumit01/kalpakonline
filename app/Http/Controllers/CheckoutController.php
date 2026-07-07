<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\DeliveryAssignment;
use App\Services\CartCalculationService;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(private CartCalculationService $cartCalculationService) {}

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

        // Calculate totals using service
        $totals = $this->cartCalculationService->calculateTotals($cartItems);

        // Pre-fill saved default address for logged-in users
        $savedAddress = null;
        if (auth()->check()) {
            $savedAddress = UserAddress::where('user_id', auth()->id())
                ->where('is_default', true)
                ->first();
            // Fall back to the most recent address if no default
            if (!$savedAddress) {
                $savedAddress = UserAddress::where('user_id', auth()->id())
                    ->latest()
                    ->first();
            }
        }

        $categories = Category::all();

        return view('home.checkout', compact('cartItems', 'totals', 'categories', 'savedAddress'));
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
                'payment_method' => 'required|in:cod',
                'order_notes' => 'nullable|string|max:1000',
                'promo_code' => 'nullable|string|max:50',
            ]);

            $identifier = $this->cartIdentifier();
            $cartItems = Cart::where($identifier)->with('product')->get();

            // Check if cart is empty
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.view')->with('error', 'Your cart is empty');
            }

            // ── Stock availability check before charging ──
            foreach ($cartItems as $item) {
                if (!$item->product) {
                    return back()->withErrors(['stock' => 'One or more products are no longer available.'])->withInput();
                }
                if ($item->product->stock_quantity < $item->quantity) {
                    return back()->withErrors([
                        'stock' => "Sorry, only {$item->product->stock_quantity} unit(s) of \"{$item->product->product_name}\" available."
                    ])->withInput();
                }
            }

            // Calculate totals using service
            $totals = $this->cartCalculationService->calculateTotals($cartItems);

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
                'subtotal' => $totals->subtotal,
                'shipping' => $totals->shipping,
                'tax' => $totals->tax,
                'total' => $totals->total,
                'status' => 'pending',
            ]);

            // Create order items and decrement stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->product_name ?? $item->product->name,
                    'quantity' => $item->quantity,
                    'unit' => $item->product->unit,
                    'price' => $item->product->final_price,
                    'subtotal' => $item->product->final_price * $item->quantity,
                ]);

                // ── Decrement stock ──
                $item->product->decrement('stock_quantity', $item->quantity);
                if ($item->product->fresh()->stock_quantity <= 0) {
                    $item->product->update(['stock_status' => 'out_of_stock']);
                }
            }

            // ── Create Delivery Assignment ──
            DeliveryAssignment::create([
                'order_id' => $order->id,
                'delivery_boy_id' => null, // Not assigned yet
                'status' => 'pending',
                'delivery_address' => $validated['address'],
                'delivery_latitude' => null, // Can be added later via admin
                'delivery_longitude' => null, // Can be added later via admin
                'assigned_at' => null,
            ]);

            // Clear cart
            Cart::where($identifier)->delete();

            DB::commit();

            // ── Send order confirmation email ──
            try {
                if (!empty($order->email)) {
                    \Mail::to($order->email)->send(new \App\Mail\OrderConfirmationMail($order));
                }
            } catch (\Exception $mailEx) {
                \Log::warning('Order confirmation email failed: ' . $mailEx->getMessage());
            }

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

