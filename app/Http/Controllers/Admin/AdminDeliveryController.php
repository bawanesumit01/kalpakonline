<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryBoy;
use App\Models\DeliveryAssignment;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDeliveryController extends Controller
{
    /**
     * Show all deliveries
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search', '');

        $query = DeliveryAssignment::with(['order', 'deliveryBoy']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->whereHas('order', function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('phone', 'like', "%$search%");
            })->orWhereHas('deliveryBoy', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
            });
        }

        $deliveries = $query->latest()->paginate(15);

        return view('admin.delivery.index', [
            'deliveries' => $deliveries,
            'status' => $status,
            'search' => $search,
        ]);
    }

    /**
     * Show delivery details with live tracking
     */
    public function show($id)
    {
        $delivery = DeliveryAssignment::with(['order', 'deliveryBoy', 'locations'])
                                      ->findOrFail($id);

        $locations = $delivery->locations()
                              ->orderBy('location_timestamp', 'asc')
                              ->get();

        return view('admin.delivery.show', [
            'delivery' => $delivery,
            'locations' => $locations,
            'google_maps_key' => env('GOOGLE_MAPS_API_KEY', ''),
        ]);
    }

    /**
     * Assign delivery boy to an order
     */
    public function assignDelivery(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'delivery_boy_id' => 'required|exists:delivery_boys,id',
        ]);

        try {
            $order = Order::findOrFail($validated['order_id']);

            // Check if already assigned
            $existing = DeliveryAssignment::where('order_id', $order->id)
                                          ->whereIn('status', ['pending', 'picked_up', 'on_way'])
                                          ->first();

            if ($existing) {
                return redirect()->back()->with('error', 'Order already assigned to a delivery boy');
            }

            // Create assignment
            $assignment = DeliveryAssignment::create([
                'order_id' => $order->id,
                'delivery_boy_id' => $validated['delivery_boy_id'],
                'status' => 'pending',
                'delivery_address' => $order->delivery_address,
                'delivery_latitude' => $order->customer_address->latitude ?? null,
                'delivery_longitude' => $order->customer_address->longitude ?? null,
                'assigned_at' => now(),
            ]);

            // Update order status
            $order->update(['status' => 'assigned']);

            return redirect()->back()->with('success', 'Delivery assigned successfully');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error assigning delivery: ' . $e->getMessage());
        }
    }

    /**
     * Manage delivery boys
     */
    public function boys(Request $request)
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search', '');

        $query = DeliveryBoy::query();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('vehicle_number', 'like', "%$search%");
        }

        $boys = $query->latest()->paginate(15);

        return view('admin.delivery.boys', [
            'boys' => $boys,
            'status' => $status,
            'search' => $search,
        ]);
    }

    /**
     * Create new delivery boy
     */
    public function createBoy()
    {
        return view('admin.delivery.create-boy');
    }

    /**
     * Store new delivery boy
     */
    public function storeBoy(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10|unique:delivery_boys',
            'email' => 'required|email|unique:delivery_boys',
            'vehicle_type' => 'required|in:bike,car,cycle',
            'vehicle_number' => 'nullable|string|max:50',
        ]);

        try {
            DeliveryBoy::create($validated);
            return redirect()->route('admin.delivery.boys')->with('success', 'Delivery boy added successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Edit delivery boy
     */
    public function editBoy($id)
    {
        $boy = DeliveryBoy::findOrFail($id);
        return view('admin.delivery.edit-boy', ['boy' => $boy]);
    }

    /**
     * Update delivery boy
     */
    public function updateBoy(Request $request, $id)
    {
        $boy = DeliveryBoy::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10|unique:delivery_boys,phone,' . $id,
            'email' => 'required|email|unique:delivery_boys,email,' . $id,
            'vehicle_type' => 'required|in:bike,car,cycle',
            'vehicle_number' => 'nullable|string|max:50',
            'status' => 'required|in:available,busy,offline',
        ]);

        try {
            $boy->update($validated);
            return redirect()->route('admin.delivery.boys')->with('success', 'Delivery boy updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Delete delivery boy
     */
    public function deleteBoy($id)
    {
        try {
            $boy = DeliveryBoy::findOrFail($id);
            $boy->delete();
            return redirect()->back()->with('success', 'Delivery boy deleted');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Dashboard with statistics
     */
    public function dashboard()
    {
        $totalDeliveries = DeliveryAssignment::count();
        $todayDeliveries = DeliveryAssignment::whereDate('created_at', today())->count();
        $completedToday = DeliveryAssignment::where('status', 'delivered')
                                            ->whereDate('delivered_at', today())
                                            ->count();
        $activeDeliveries = DeliveryAssignment::whereIn('status', ['picked_up', 'on_way'])->count();
        $totalBoys = DeliveryBoy::count();
        $availableBoys = DeliveryBoy::where('status', 'available')->count();

        $recentDeliveries = DeliveryAssignment::with(['order', 'deliveryBoy'])
                                              ->latest()
                                              ->limit(10)
                                              ->get();

        return view('admin.delivery.dashboard', [
            'totalDeliveries' => $totalDeliveries,
            'todayDeliveries' => $todayDeliveries,
            'completedToday' => $completedToday,
            'activeDeliveries' => $activeDeliveries,
            'totalBoys' => $totalBoys,
            'availableBoys' => $availableBoys,
            'recentDeliveries' => $recentDeliveries,
        ]);
    }
}
