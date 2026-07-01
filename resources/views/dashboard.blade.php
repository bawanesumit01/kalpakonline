@extends('layouts.app')

@section('content')
<style>
    .dashboard-header {
        padding: 30px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        margin-bottom: 30px;
        border-radius: 8px;
    }

    .dashboard-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .dashboard-subtitle {
        font-size: 16px;
        opacity: 0.9;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 4px solid #667eea;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .stat-card.success { border-left-color: #10B981; }
    .stat-card.danger { border-left-color: #EF4444; }
    .stat-card.info { border-left-color: #3B82F6; }
    .stat-card.warning { border-left-color: #F59E0B; }

    .stat-icon {
        font-size: 32px;
        margin-bottom: 10px;
        color: #667eea;
    }

    .stat-card.success .stat-icon { color: #10B981; }
    .stat-card.danger .stat-icon { color: #EF4444; }
    .stat-card.info .stat-icon { color: #3B82F6; }
    .stat-card.warning .stat-icon { color: #F59E0B; }

    .stat-label {
        font-size: 14px;
        color: #666;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #333;
    }

    .stat-change {
        font-size: 12px;
        margin-top: 8px;
        color: #666;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #333;
        margin: 30px 0 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #667eea;
    }

    .recent-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .recent-table thead {
        background: #f3f4f6;
        font-weight: 600;
        color: #333;
    }

    .recent-table th {
        padding: 15px;
        text-align: left;
        border-bottom: 2px solid #e5e7eb;
    }

    .recent-table td {
        padding: 15px;
        border-bottom: 1px solid #e5e7eb;
    }

    .recent-table tbody tr:hover {
        background: #f9fafb;
    }

    .badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-pending { background: #FEF3C7; color: #92400E; }
    .badge-confirmed { background: #DBEAFE; color: #1E40AF; }
    .badge-shipped { background: #D1FAE5; color: #065F46; }
    .badge-delivered { background: #CCFBF1; color: #134E4A; }
    .badge-cancelled { background: #FEE2E2; color: #7F1D1D; }

    .grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .grid-4 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    @media (max-width: 768px) {
        .grid-2, .grid-4 {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-wrapper mdc-toolbar-fixed-adjust">
    <main class="content-wrapper">
        <div class="container-lg" style="max-width: 1400px; padding: 20px;">

            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <div class="dashboard-title"><i class="fas fa-chart-line"></i> Dashboard</div>
                <div class="dashboard-subtitle">Welcome back, {{ auth()->user()->name }}! Here's your business overview.</div>
            </div>

            <!-- Revenue Overview -->
            <h2 class="section-title"><i class="fas fa-dollar-sign"></i> Revenue Overview</h2>
            <div class="grid-4">
                <div class="stat-card success">
                    <div class="stat-icon"><i class="fas fa-wallet"></i></div>
                    <div class="stat-label">Today's Revenue</div>
                    <div class="stat-value">₹{{ number_format($todayRevenue, 2) }}</div>
                </div>
                <div class="stat-card info">
                    <div class="stat-icon"><i class="fas fa-arrow-trend-up"></i></div>
                    <div class="stat-label">This Month</div>
                    <div class="stat-value">₹{{ number_format($monthRevenue, 2) }}</div>
                </div>
                <div class="stat-card warning">
                    <div class="stat-icon"><i class="fas fa-trophy"></i></div>
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-value">₹{{ number_format($totalRevenue, 2) }}</div>
                </div>
                <div class="stat-card danger">
                    <div class="stat-icon"><i class="fas fa-chart-bar"></i></div>
                    <div class="stat-label">Total Orders</div>
                    <div class="stat-value">{{ $totalOrders }}</div>
                </div>
            </div>

            <!-- Orders Status -->
            <h2 class="section-title"><i class="fas fa-boxes"></i> Order Status Breakdown</h2>
            <div class="grid-4">
                <div class="stat-card warning">
                    <div class="stat-icon"><i class="fas fa-hourglass-start"></i></div>
                    <div class="stat-label">Pending Orders</div>
                    <div class="stat-value">{{ $pendingOrders }}</div>
                </div>
                <div class="stat-card info">
                    <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-label">Confirmed</div>
                    <div class="stat-value">{{ $confirmedOrders }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-truck"></i></div>
                    <div class="stat-label">Shipped</div>
                    <div class="stat-value">{{ $shippedOrders }}</div>
                </div>
                <div class="stat-card success">
                    <div class="stat-icon"><i class="fas fa-map-pin"></i></div>
                    <div class="stat-label">Delivered</div>
                    <div class="stat-value">{{ $deliveredOrders }}</div>
                </div>
            </div>

            <!-- Inventory & Catalog -->
            <h2 class="section-title"><i class="fas fa-book"></i> Inventory & Catalog</h2>
            <div class="grid-4">
                <div class="stat-card success">
                    <div class="stat-icon"><i class="fas fa-check"></i></div>
                    <div class="stat-label">Products (Active)</div>
                    <div class="stat-value">{{ $totalProducts }}</div>
                </div>
                <div class="stat-card info">
                    <div class="stat-icon"><i class="fas fa-cube"></i></div>
                    <div class="stat-label">In Stock</div>
                    <div class="stat-value">{{ $inStockProducts }}</div>
                </div>
                <div class="stat-card warning">
                    <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="stat-label">Low Stock</div>
                    <div class="stat-value">{{ $lowStockProducts }}</div>
                </div>
                <div class="stat-card danger">
                    <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
                    <div class="stat-label">Out of Stock</div>
                    <div class="stat-value">{{ $outOfStockProducts }}</div>
                </div>
            </div>

            <!-- System Overview -->
            <h2 class="section-title"><i class="fas fa-cogs"></i> System Overview</h2>
            <div class="grid-4">
                <div class="stat-card info">
                    <div class="stat-icon"><i class="fas fa-folder"></i></div>
                    <div class="stat-label">Categories</div>
                    <div class="stat-value">{{ $totalCategories }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-store"></i></div>
                    <div class="stat-label">Vendors</div>
                    <div class="stat-value">{{ $totalVendors }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-label">Customers</div>
                    <div class="stat-value">{{ $totalCustomers }}</div>
                </div>
                <div class="stat-card warning">
                    <div class="stat-icon"><i class="fas fa-comments"></i></div>
                    <div class="stat-label">Enquiries</div>
                    <div class="stat-value">{{ $totalEnquiries }}</div>
                </div>
            </div>

            <!-- Delivery Status -->
            <h2 class="section-title"><i class="fas fa-motorcycle"></i> Delivery Status</h2>
            <div class="grid-4">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-box"></i></div>
                    <div class="stat-label">Total Deliveries</div>
                    <div class="stat-value">{{ $totalDeliveries }}</div>
                </div>
                <div class="stat-card warning">
                    <div class="stat-icon"><i class="fas fa-spinner"></i></div>
                    <div class="stat-label">Pending</div>
                    <div class="stat-value">{{ $pendingDeliveries }}</div>
                </div>
                <div class="stat-card info">
                    <div class="stat-icon"><i class="fas fa-bicycle"></i></div>
                    <div class="stat-label">Active</div>
                    <div class="stat-value">{{ $activeDeliveries }}</div>
                </div>
                <div class="stat-card success">
                    <div class="stat-icon"><i class="fas fa-check-double"></i></div>
                    <div class="stat-label">Completed</div>
                    <div class="stat-value">{{ $completedDeliveries }}</div>
                </div>
            </div>

            <!-- Recent Orders -->
            <h2 class="section-title"><i class="fas fa-list"></i> Recent Orders</h2>
            <table class="recent-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-receipt"></i> Order #</th>
                        <th><i class="fas fa-user"></i> Customer</th>
                        <th><i class="fas fa-money-bill"></i> Amount</th>
                        <th><i class="fas fa-info-circle"></i> Status</th>
                        <th><i class="fas fa-calendar"></i> Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td><strong>#{{ $order->order_number }}</strong></td>
                            <td>{{ $order->name ?? 'N/A' }}</td>
                            <td><strong>₹{{ number_format($order->total, 2) }}</strong></td>
                            <td>
                                <span class="badge badge-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: #999;">No recent orders</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Top Selling Products -->
            <h2 class="section-title"><i class="fas fa-star"></i> Top Selling Products</h2>
            <table class="recent-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-product-hunt"></i> Product Name</th>
                        <th><i class="fas fa-tag"></i> Category</th>
                        <th><i class="fas fa-price-tag"></i> Price</th>
                        <th><i class="fas fa-inventory"></i> Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topProducts as $product)
                        <tr>
                            <td><strong>{{ $product->product_name }}</strong></td>
                            <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                            <td>₹{{ number_format($product->final_price, 2) }}</td>
                            <td>
                                <span class="badge" style="background: #D1FAE5; color: #065F46;">
                                    {{ $product->stock_quantity }} units
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #999;">No products sold yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Category Performance -->
            <h2 class="section-title"><i class="fas fa-chart-pie"></i> Category Performance</h2>
            <table class="recent-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-folder-open"></i> Category</th>
                        <th><i class="fas fa-chart-line"></i> Total Sold</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categoryStats as $category)
                        <tr>
                            <td><strong>{{ $category->category_name }}</strong></td>
                            <td>
                                <span class="badge" style="background: #DBEAFE; color: #1E40AF;">
                                    {{ $category->total_sold ?? 0 }} items
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="text-align: center; color: #999;">No category data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pending Enquiries -->
            @if($pendingEnquiries->count() > 0)
                <h2 class="section-title"><i class="fas fa-question-circle"></i> Pending Enquiries</h2>
                <table class="recent-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user-circle"></i> Name</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-heading"></i> Subject</th>
                            <th><i class="fas fa-clock"></i> Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingEnquiries as $enquiry)
                            <tr>
                                <td><strong>{{ $enquiry->name }}</strong></td>
                                <td>{{ $enquiry->email }}</td>
                                <td>{{ $enquiry->subject }}</td>
                                <td>{{ $enquiry->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </main>
</div>
@endsection
