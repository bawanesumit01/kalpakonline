<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\DeliveryAssignment;
use App\Models\Category;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    /**
     * Show live tracking page for an order
     */
    public function track($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            $categories = Category::all();
            
            // Get delivery assignment
            $assignment = DeliveryAssignment::where('order_id', $orderId)->first();

            if (!$assignment) {
                return view('order.tracking', [
                    'order' => $order,
                    'assignment' => null,
                    'tracking_available' => false,
                    'categories' => $categories,
                ]);
            }

            // Check if delivery is in progress
            $tracking_available = $assignment->isInProgress();

            return view('order.tracking', [
                'order' => $order,
                'assignment' => $assignment,
                'tracking_available' => $tracking_available,
                'categories' => $categories,
                'google_maps_key' => env('GOOGLE_MAPS_API_KEY', ''),
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Order not found');
        }
    }

    /**
     * Show customer's order history
     */
    public function history()
    {
        $categories = Category::all();
        $orders = auth()->user()->orders()->latest()->paginate(10);
        
        return view('order.history', [
            'orders' => $orders,
            'categories' => $categories,
        ]);
    }
}
