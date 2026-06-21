<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Show all orders for logged-in customer
     */
    public function index()
    {
        // Get orders for current logged-in user
        $orders = Order::where('user_id', Auth::id())
                       ->with('items')
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);

        $categories = Category::all();

        return view('home.orders.index', compact('orders', 'categories'));
    }
}
