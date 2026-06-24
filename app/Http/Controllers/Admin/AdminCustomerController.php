<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminCustomerController extends Controller
{
    /**
     * Display list of all customers
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'client')
                     ->withCount('orders')
                     ->withSum('orders', 'total');

        // Search by name, email, or phone
        if ($request->search) {
            $search = '%' . $request->search . '%';
            $query->where('name', 'like', $search)
                  ->orWhere('email', 'like', $search)
                  ->orWhere('mobile', 'like', $search);
        }

        // Sort options
        $sortBy = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        
        if (in_array($sortBy, ['created_at', 'name', 'mobile', 'orders_count'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $customers = $query->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show customer profile and details
     */
    public function show($customerId)
    {
        $customer = User::with('orders.items', 'addresses')
                       ->where('role', 'client')
                       ->findOrFail($customerId);

        $totalOrders = $customer->orders()->count();
        $totalSpent = $customer->orders()->sum('total');
        $recentOrders = $customer->orders()
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
        $savedAddresses = $customer->addresses()
                                  ->orderBy('is_default', 'desc')
                                  ->orderBy('created_at', 'desc')
                                  ->get();

        return view('admin.customers.show', compact(
            'customer',
            'totalOrders',
            'totalSpent',
            'recentOrders',
            'savedAddresses'
        ));
    }

    /**
     * Show customer create form
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store new customer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|digits:10|unique:users,mobile',
        ]);

        // Create user with default password (customer can reset)
        $customer = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'role' => 'client',
            'email_verified_at' => now(), // Auto-verify for admin-created customers
        ]);

        \Log::info("Admin created new customer {$customer->id} ({$customer->name})");

        return redirect()->route('admin.customers.show', $customer->id)
                        ->with('success', 'Customer created successfully!');
    }

    /**
     * Show customer edit form
     */
    public function edit($customerId)
    {
        $customer = User::where('role', 'client')->findOrFail($customerId);
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update customer information
     */
    public function update(Request $request, $customerId)
    {
        $customer = User::where('role', 'client')->findOrFail($customerId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'mobile' => 'required|digits:10|unique:users,mobile,' . $customer->id,
        ]);

        $customer->update($validated);

        \Log::info("Admin updated customer {$customer->id} ({$customer->name})");

        return redirect()->route('admin.customers.show', $customer->id)
                        ->with('success', 'Customer information updated successfully!');
    }

    /**
     * Show customer addresses
     */
    public function addresses($customerId)
    {
        $customer = User::where('role', 'client')->findOrFail($customerId);
        $addresses = $customer->addresses()
                            ->orderBy('is_default', 'desc')
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('admin.customers.addresses', compact('customer', 'addresses'));
    }

    /**
     * Delete customer address
     */
    public function deleteAddress($customerId, $addressId)
    {
        $customer = User::where('role', 'client')->findOrFail($customerId);
        $address = UserAddress::where('user_id', $customer->id)
                             ->findOrFail($addressId);

        $address->delete();

        \Log::info("Admin deleted address {$addressId} for customer {$customer->id}");

        return redirect()->route('admin.customers.addresses', $customer->id)
                        ->with('success', 'Address deleted successfully!');
    }

    /**
     * Get customer orders
     */
    public function orders($customerId)
    {
        $customer = User::where('role', 'client')->findOrFail($customerId);
        
        // Get paginated orders for display
        $orders = $customer->orders()
                          ->with('items')
                          ->orderBy('created_at', 'desc');
        
        // Apply filters
        if (request('search')) {
            $search = '%' . request('search') . '%';
            $orders->where('order_number', 'like', $search);
        }
        
        if (request('status')) {
            $orders->where('status', request('status'));
        }
        
        $orders = $orders->paginate(15);
        
        // Get all orders for statistics
        $allOrders = $customer->orders()->get();

        return view('admin.customers.orders', compact('customer', 'orders', 'allOrders'));
    }

    /**
     * Delete customer (with all related data)
     */
    public function destroy(Request $request, $customerId)
    {
        $customer = User::where('role', 'client')->findOrFail($customerId);

        $customerName = $customer->name;
        $customerId = $customer->id;

        // Delete addresses
        $customer->addresses()->delete();

        // Delete customer
        $customer->delete();

        \Log::info("Admin deleted customer {$customerId} ({$customerName})");

        return redirect()->route('admin.customers.index')
                        ->with('success', "Customer '{$customerName}' deleted successfully!");
    }

    /**
     * Get customer statistics and insights
     */
    public function statistics()
    {
        $totalCustomers = User::where('role', 'client')->count();
        
        $newCustomersThisMonth = User::where('role', 'client')
                                    ->whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->count();

        $customers = User::where('role', 'client')
                        ->withCount('orders')
                        ->withSum('orders', 'total')
                        ->orderBy('orders_sum_total', 'desc')
                        ->limit(10)
                        ->get();

        $topSpenders = $customers;

        $avgOrderValue = Order::where('payment_status', 'paid')
                             ->avg('total');

        return view('admin.customers.statistics', compact(
            'totalCustomers',
            'newCustomersThisMonth',
            'topSpenders',
            'avgOrderValue'
        ));
    }

    /**
     * Export customers to CSV
     */
    public function export()
    {
        $customers = User::where('role', 'client')
                        ->with('orders')
                        ->get();

        $filename = "customers_" . date('Y-m-d_H-i-s') . ".csv";
        $handle = fopen('php://output', 'w');

        header('Content-Type: text/csv');
        header("Content-Disposition: attachment; filename=\"$filename\"");

        // CSV Header
        fputcsv($handle, [
            'Name',
            'Email',
            'Mobile',
            'Total Orders',
            'Total Spent',
            'Joined Date',
        ]);

        // CSV Rows
        foreach ($customers as $customer) {
            $totalOrders = $customer->orders()->count();
            $totalSpent = $customer->orders()->sum('total');
            
            fputcsv($handle, [
                $customer->name,
                $customer->email,
                $customer->mobile,
                $totalOrders,
                '₹' . number_format($totalSpent, 2),
                $customer->created_at->format('Y-m-d'),
            ]);
        }

        fclose($handle);
        exit;
    }

    /**
     * Send message/notification to customer
     */
    public function sendNotification(Request $request, $customerId)
    {
        $customer = User::where('role', 'client')->findOrFail($customerId);

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Here you would integrate with email/SMS service
        // For now, we'll just log it
        \Log::info("Notification sent to customer {$customer->id}: {$validated['subject']}");

        return redirect()->route('admin.customers.show', $customer->id)
                        ->with('success', 'Notification sent to customer!');
    }

    /**
     * Bulk actions on customers
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'customer_ids' => 'required|array',
            'customer_ids.*' => 'integer|exists:users,id',
            'action' => 'required|in:delete,export',
        ]);

        if ($request->action === 'delete') {
            User::whereIn('id', $validated['customer_ids'])
               ->where('role', 'client')
               ->delete();

            \Log::info("Bulk deleted " . count($validated['customer_ids']) . " customers");

            return redirect()->route('admin.customers.index')
                            ->with('success', count($validated['customer_ids']) . ' customers deleted!');
        }

        if ($request->action === 'export') {
            $customers = User::whereIn('id', $validated['customer_ids'])
                            ->where('role', 'client')
                            ->get();

            $filename = "customers_export_" . date('Y-m-d_H-i-s') . ".csv";
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv');
            header("Content-Disposition: attachment; filename=\"$filename\"");

            fputcsv($handle, ['Name', 'Email', 'Mobile', 'Joined Date']);

            foreach ($customers as $customer) {
                fputcsv($handle, [
                    $customer->name,
                    $customer->email,
                    $customer->mobile,
                    $customer->created_at->format('Y-m-d'),
                ]);
            }

            fclose($handle);
            exit;
        }

        return redirect()->back();
    }
}
