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
        $orders = Order::where('user_id', Auth::id())
                       ->with('items')
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);

        $categories = Category::all();

        return view('home.orders.index', compact('orders', 'categories'));
    }

    /**
     * Show a single order detail
     */
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
                      ->with('items.product')
                      ->findOrFail($id);

        $categories = Category::all();

        return view('home.orders.show', compact('order', 'categories'));
    }

    /**
     * Cancel a pending order
     */
    public function cancel(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->withErrors(['cancel' => 'Only pending orders can be cancelled.']);
        }

        // Restore stock quantities
        foreach ($order->items()->with('product')->get() as $item) {
            if ($item->product) {
                $item->product->increment('stock_quantity', $item->quantity);
                // Re-mark as in_stock if it was out of stock
                if ($item->product->fresh()->stock_quantity > 0 && $item->product->stock_status === 'out_of_stock') {
                    $item->product->update(['stock_status' => 'in_stock']);
                }
            }
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('client.orders.show', $order->id)
                         ->with('success', 'Your order has been cancelled successfully.');
    }
}
