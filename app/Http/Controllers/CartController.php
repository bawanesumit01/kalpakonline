<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;

class CartController extends Controller
{
    // Helper: get identifier for current user/guest
    private function cartIdentifier()
    {
        if (auth()->check()) {
            return ['user_id' => auth()->id(), 'session_id' => null];
        }
        return ['user_id' => null, 'session_id' => session()->getId()];
    }

    // Add to cart (AJAX)
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $identifier = $this->cartIdentifier();

        $cartItem = Cart::where($identifier)
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            Cart::create(array_merge($identifier, [
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ]));
        }

        $cartCount = $this->getCartCount();

        return response()->json([
            'success'    => true,
            'message'    => 'Product added to cart!',
            'cart_count' => $cartCount,
        ]);
    }

    // View cart page
    public function viewCart()
    {
        $identifier = $this->cartIdentifier();
        $cartItems  = Cart::where($identifier)->with('product')->get();

        $total = $cartItems->sum(fn($item) => $item->product->final_price * $item->quantity);

        $categories = Category::all();
        return view('home.cart', compact('cartItems', 'total','categories'));
    }

    // Update quantity (AJAX)
    public function updateCart(Request $request)
    {
        $request->validate([
            'cart_id'  => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $identifier = $this->cartIdentifier();
        $cartItem   = Cart::where($identifier)->where('id', $request->cart_id)->firstOrFail();
        $cartItem->update(['quantity' => $request->quantity]);

        $subtotal   = $cartItem->product->final_price * $cartItem->quantity;
        $cartTotal  = Cart::where($identifier)->with('product')
                          ->get()
                          ->sum(fn($i) => $i->product->final_price * $i->quantity);

        return response()->json([
            'success'   => true,
            'subtotal'  => number_format($subtotal, 2),
            'cartTotal' => number_format($cartTotal, 2),
        ]);
    }

    // Remove item (AJAX)
    public function removeFromCart(Request $request)
    {
        $identifier = $this->cartIdentifier();
        Cart::where($identifier)->where('id', $request->cart_id)->delete();

        $cartCount = $this->getCartCount();
        $cartTotal = Cart::where($identifier)->with('product')
                         ->get()
                         ->sum(fn($i) => $i->product->final_price * $i->quantity);

        return response()->json([
            'success'    => true,
            'cart_count' => $cartCount,
            'cartTotal'  => number_format($cartTotal, 2),
        ]);
    }

    // Cart count helper
    public function getCartCount()
    {
        $identifier = $this->cartIdentifier();
        return Cart::where($identifier)->sum('quantity');
    }
    
    // Add this method to CartController.php
public function getCartItems()
{
    $identifier = $this->cartIdentifier();
    $cartItems  = Cart::where($identifier)->with('product')->get();
    $cartTotal  = $cartItems->sum(fn($i) => $i->product->final_price * $i->quantity);
    $cartCount  = $cartItems->sum('quantity');

    $html = '';
    foreach ($cartItems as $item) {
        $subtotal = number_format($item->product->final_price * $item->quantity, 2);
        $image    = asset('/' . $item->product->main_image);
        $name     = $item->product->product_name;
        $price    = $item->product->final_price;
        $qty      = $item->quantity;
        $id       = $item->id;

        $html .= "
        <div class='cart-item d-flex align-items-center gap-3 border-bottom py-3' id='offcanvas-item-{$id}'>
            <img src='{$image}' width='60' height='60' class='rounded' style='object-fit:cover' alt='{$name}'>
            <div class='flex-grow-1'>
                <h6 class='mb-1 fs-6'>{$name}</h6>
                <small class='text-muted'>&#8377; {$price} each</small>
                <div class='d-flex align-items-center gap-2 mt-2'>
                    <button class='btn btn-outline-secondary btn-sm px-2 py-0 offcanvas-qty-decrease' data-cart-id='{$id}'>−</button>
                    <span class='offcanvas-qty fw-semibold' data-cart-id='{$id}'>{$qty}</span>
                    <button class='btn btn-outline-secondary btn-sm px-2 py-0 offcanvas-qty-increase' data-cart-id='{$id}'>+</button>
                </div>
            </div>
            <div class='text-end'>
                <div class='fw-semibold offcanvas-subtotal' data-cart-id='{$id}'>&#8377; {$subtotal}</div>
                <button class='btn btn-link text-danger p-0 mt-1 offcanvas-remove' data-cart-id='{$id}'>
                    <small>Remove</small>
                </button>
            </div>
        </div>";
    }

    if (empty($html)) {
        $html = "
        <div class='text-center py-5'>
            <p class='mt-3 text-muted'>Your cart is empty</p>
            <a href='/' class='btn btn-primary btn-sm mt-2'>Start Shopping</a>
        </div>";
    }

    return response()->json([
        'success'    => true,
        'html'       => $html,
        'cartTotal'  => number_format($cartTotal, 2),
        'cart_count' => $cartCount,
    ]);
}
    
}