<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Cart;

class CartComposer
{
    public function compose(View $view)
    {
        if (auth()->check()) {
            $identifier = ['user_id' => auth()->id()];
        } else {
            $identifier = ['session_id' => session()->getId()];
        }

        $cartItems = Cart::where($identifier)->with('product')->get();
        
        // Remove items with deleted/null products
        $cartItems = $cartItems->filter(fn($item) => $item->product !== null);
        
        $cartCount = $cartItems->sum('quantity');
        $cartTotal = $cartItems->sum(fn($item) => $item->product->final_price * $item->quantity);

        $view->with([
            'cartCount' => $cartCount,
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
        ]);
    }
}