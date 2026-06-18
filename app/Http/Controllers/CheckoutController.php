<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $identifier = auth()->check()
            ? ['user_id' => auth()->id(), 'session_id' => null]
            : ['user_id' => null, 'session_id' => session()->getId()];

        $cartItems = Cart::where($identifier)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(fn ($item) => $item->product->final_price * $item->quantity);
        $categories = Category::all();

        return view('home.checkout', compact('cartItems', 'total', 'categories'));
    }
}
