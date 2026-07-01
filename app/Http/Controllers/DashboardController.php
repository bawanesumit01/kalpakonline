<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Vendor;
use App\Models\User;
use App\Models\DeliveryAssignment;
use App\Models\Enquiry;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Overall Statistics
        $totalOrders = Order::count();
        $totalProducts = Product::where('status', 'active')->count();
        $totalCategories = Category::count();
        $totalVendors = Vendor::count();
        $totalCustomers = User::where('role', 'client')->count();
        $totalEnquiries = Enquiry::count();

        // Revenue Statistics
        $todayRevenue = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', today())
            ->sum('total');

        $monthRevenue = Order::where('status', '!=', 'cancelled')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total');

        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');

        // Order Statistics
        $pendingOrders = Order::where('status', 'pending')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        // Delivery Statistics
        $totalDeliveries = DeliveryAssignment::count();
        $pendingDeliveries = DeliveryAssignment::where('status', 'pending')->count();
        $activeDeliveries = DeliveryAssignment::whereIn('status', ['picked_up', 'on_way'])->count();
        $completedDeliveries = DeliveryAssignment::where('status', 'delivered')->count();

        // Product Statistics
        $inStockProducts = Product::where('stock_status', 'in_stock')->count();
        $outOfStockProducts = Product::where('stock_status', 'out_of_stock')->count();
        $lowStockProducts = Product::where('stock_quantity', '<=', 10)
            ->where('stock_quantity', '>', 0)
            ->count();

        // Recent Orders
        $recentOrders = Order::with(['user'])
            ->latest()
            ->limit(10)
            ->get();

        // Top Selling Products with category
        $topProducts = Product::selectRaw('products.id, products.product_name, products.final_price, products.stock_quantity, products.category_id, COUNT(order_items.id) as total_sold')
            ->with('category')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id', 'products.product_name', 'products.final_price', 'products.stock_quantity', 'products.category_id')
            ->orderByRaw('COUNT(order_items.id) DESC')
            ->limit(5)
            ->get();

        // Pending Enquiries
        $pendingEnquiries = Enquiry::where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        // Revenue by Month (Last 6 months)
        $revenueByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $revenue = Order::where('status', '!=', 'cancelled')
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total');
            $revenueByMonth[$month->format('M Y')] = $revenue;
        }

        // Category Performance
        $categoryStats = Category::select('categories.category_id', 'categories.category_name')
            ->selectRaw('COUNT(order_items.id) as total_sold')
            ->leftJoin('products', 'categories.category_id', '=', 'products.category_id')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('categories.category_id', 'categories.category_name')
            ->orderByRaw('COUNT(order_items.id) DESC')
            ->limit(6)
            ->get();

        return view('dashboard', [
            'user' => $user,
            // Overall Stats
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalVendors' => $totalVendors,
            'totalCustomers' => $totalCustomers,
            'totalEnquiries' => $totalEnquiries,
            // Revenue
            'todayRevenue' => $todayRevenue,
            'monthRevenue' => $monthRevenue,
            'totalRevenue' => $totalRevenue,
            // Orders
            'pendingOrders' => $pendingOrders,
            'confirmedOrders' => $confirmedOrders,
            'shippedOrders' => $shippedOrders,
            'deliveredOrders' => $deliveredOrders,
            'cancelledOrders' => $cancelledOrders,
            // Deliveries
            'totalDeliveries' => $totalDeliveries,
            'pendingDeliveries' => $pendingDeliveries,
            'activeDeliveries' => $activeDeliveries,
            'completedDeliveries' => $completedDeliveries,
            // Products
            'inStockProducts' => $inStockProducts,
            'outOfStockProducts' => $outOfStockProducts,
            'lowStockProducts' => $lowStockProducts,
            // Recent Data
            'recentOrders' => $recentOrders,
            'topProducts' => $topProducts,
            'pendingEnquiries' => $pendingEnquiries,
            'revenueByMonth' => $revenueByMonth,
            'categoryStats' => $categoryStats,
        ]);
    }
}
