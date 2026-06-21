<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use PDF;

class AdminOrderController extends Controller
{
    /**
     * Display list of all orders
     */
    public function index(Request $request)
    {
        $query = Order::with('user', 'items.product')
                      ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order number or phone
        if ($request->search) {
            $search = '%' . $request->search . '%';
            $query->where('order_number', 'like', $search)
                  ->orWhere('phone', 'like', $search)
                  ->orWhere('email', 'like', $search);
        }

        $orders = $query->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show order details
     */
    public function show($orderId)
    {
        $order = Order::with('user', 'items.product')->findOrFail($orderId);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show order edit form
     */
    public function edit($orderId)
    {
        $order = Order::with('user', 'items.product')->findOrFail($orderId);
        $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'failed', 'cancelled'];
        
        return view('admin.orders.edit', compact('order', 'statuses', 'paymentStatuses'));
    }

    /**
     * Update order
     */
    public function update(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,cancelled',
            'order_notes' => 'nullable|string|max:1000',
        ]);

        // Track status changes for notifications
        $statusChanged = $order->status !== $validated['status'];

        $order->update($validated);

        // Log the update
        \Log::info("Order {$order->order_number} updated - Status: {$validated['status']}, Payment: {$validated['payment_status']}");

        return redirect()->route('admin.orders.show', $order->id)
                        ->with('success', 'Order updated successfully!');
    }

    /**
     * Show order invoice/receipt
     */
    public function invoice($orderId)
    {
        $order = Order::with('user', 'items.product')->findOrFail($orderId);
        
        // Check if PDF library exists, otherwise return view
        if (function_exists('pdf')) {
            return PDF::loadView('admin.orders.invoice', compact('order'))->download("Invoice-{$order->order_number}.pdf");
        }
        
        return view('admin.orders.invoice', compact('order'));
    }

    /**
     * Delete order (with confirmation)
     */
    public function destroy(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        $orderNumber = $order->order_number;
        $order->items()->delete();
        $order->delete();

        \Log::info("Order {$orderNumber} deleted by admin");

        return redirect()->route('admin.orders.index')
                        ->with('success', "Order {$orderNumber} deleted successfully!");
    }

    /**
     * Bulk update order statuses
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'integer|exists:orders,id',
            'status' => 'nullable|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'payment_status' => 'nullable|in:pending,paid,failed,cancelled',
        ]);

        $updates = [];
        if ($request->status) {
            $updates['status'] = $request->status;
        }
        if ($request->payment_status) {
            $updates['payment_status'] = $request->payment_status;
        }

        Order::whereIn('id', $validated['order_ids'])->update($updates);

        \Log::info("Bulk updated " . count($validated['order_ids']) . " orders");

        return redirect()->route('admin.orders.index')
                        ->with('success', count($validated['order_ids']) . ' orders updated successfully!');
    }

    /**
     * Export orders to CSV
     */
    public function export(Request $request)
    {
        $query = Order::with('user', 'items');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $orders = $query->get();

        $filename = "orders_" . date('Y-m-d_H-i-s') . ".csv";
        $handle = fopen('php://output', 'w');

        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=\"$filename\"");

        // CSV Header
        fputcsv($handle, [
            'Order Number',
            'Customer Name',
            'Phone',
            'Email',
            'Total Amount',
            'Payment Method',
            'Payment Status',
            'Order Status',
            'Order Date',
        ]);

        // CSV Rows
        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->order_number,
                $order->name,
                $order->phone,
                $order->email,
                '₹' . number_format($order->total, 2),
                ucfirst($order->payment_method),
                ucfirst($order->payment_status),
                ucfirst($order->status),
                $order->created_at->format('Y-m-d H:i:s'),
            ]);
        }

        fclose($handle);
        exit;
    }

    /**
     * Get order statistics
     */
    public function statistics()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();

        $recentOrders = Order::with('user')
                             ->orderBy('created_at', 'desc')
                             ->limit(10)
                             ->get();

        $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
                               ->groupBy('status')
                               ->get();

        $ordersByPaymentStatus = Order::selectRaw('payment_status, COUNT(*) as count')
                                      ->groupBy('payment_status')
                                      ->get();

        return view('admin.orders.statistics', compact(
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'deliveredOrders',
            'recentOrders',
            'ordersByStatus',
            'ordersByPaymentStatus'
        ));
    }
}
