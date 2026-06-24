@extends('layouts.app')

@section('content')
<div class="page-wrapper mdc-toolbar-fixed-adjust">
    <main class="content-wrapper">
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card p-0">
                    <!-- Breadcrumbs & Header -->
                    <div class="row mx-4">
                        <div class="col-5 align-self-center">
                            <h4 class="mdc-typography--headline4 pt-2">Customer Details</h4>
                            <div class="d-flex align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('admin.customers.index') }}" class="text-decoration-none">Customers</a>
                                        </li>
                                        <li class="breadcrumb-item mdc-typography--subtitle1 active" aria-current="page">
                                            {{ $customer->name }}
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="col-7 align-self-center">
                            <div class="d-flex no-block justify-content-end align-items-center gap-2">
                                <a href="{{ route('admin.customers.edit', $customer->id) }}">
                                    <button class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded">
                                        <i class="fa-solid fa-pen pe-1"></i>Edit
                                    </button>
                                </a>
                                <a href="{{ route('admin.customers.addresses', $customer->id) }}">
                                    <button class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded">
                                        <i class="fa-solid fa-map-pin pe-1"></i>Addresses
                                    </button>
                                </a>
                                <a href="{{ route('admin.customers.orders', $customer->id) }}">
                                    <button class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded">
                                        <i class="fa-solid fa-box pe-1"></i>Orders
                                    </button>
                                </a>
                                <a href="{{ route('admin.customers.index') }}">
                                    <button class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded">
                                        <i class="fa-solid fa-arrow-left pe-1"></i>Back
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Grid -->
                    <div class="row p-4">
                        <!-- Left Column (2/3) -->
                        <div class="col-lg-8">
                            <!-- Customer Information -->
                            <div class="mdc-card mb-3 p-4">
                                <h5 class="mdc-typography--title mb-3">Customer Information</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-muted small mb-1">Name</p>
                                        <p class="fw-semibold mb-3">{{ $customer->name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-muted small mb-1">Email</p>
                                        <p class="fw-semibold mb-3">{{ $customer->email }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-muted small mb-1">Mobile</p>
                                        <p class="fw-semibold mb-3">{{ $customer->mobile }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-muted small mb-1">Joined Date</p>
                                        <p class="fw-semibold mb-3">{{ $customer->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Orders -->
                            <div class="mdc-card mb-3 p-4">
                                <h5 class="mdc-typography--title mb-3">Recent Orders (Last 5)</h5>
                                <div class="space-y-3">
                                    @forelse($recentOrders as $order)
                                    <div class="border rounded p-3" style="border-color: #e0e0e0;">
                                        <div class="row align-items-center">
                                            <div class="col-md-5">
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="fw-semibold text-primary text-decoration-none">
                                                    {{ $order->order_number }}
                                                </a>
                                            </div>
                                            <div class="col-md-4">
                                                <span class="badge
                                                    {{ $order->status == 'pending' ? 'bg-warning' : '' }}
                                                    {{ $order->status == 'confirmed' ? 'bg-info' : '' }}
                                                    {{ $order->status == 'processing' ? 'bg-secondary' : '' }}
                                                    {{ $order->status == 'shipped' ? 'bg-primary' : '' }}
                                                    {{ $order->status == 'delivered' ? 'bg-success' : '' }}
                                                    {{ $order->status == 'cancelled' ? 'bg-danger' : '' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                            <div class="col-md-3 text-end">
                                                <span class="fw-semibold">₹{{ number_format($order->total, 2) }}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <span class="text-muted small">{{ $order->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <p class="text-muted">No orders yet</p>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Saved Addresses -->
                            <div class="mdc-card p-4">
                                <h5 class="mdc-typography--title mb-3">Saved Addresses</h5>
                                <div class="space-y-3">
                                    @forelse($savedAddresses as $address)
                                    <div class="border rounded p-3" style="border-color: #e0e0e0; background-color: #fafafa;">
                                        @if($address->is_default)
                                        <span class="badge bg-primary mb-2">
                                            Default
                                        </span>
                                        @endif
                                        <p class="fw-semibold text-dark mb-1">{{ $address->name }}</p>
                                        <p class="text-secondary small mb-1">{{ $address->address }}</p>
                                        @if($address->address_line2)
                                        <p class="text-secondary small mb-1">{{ $address->address_line2 }}</p>
                                        @endif
                                        <p class="text-secondary small mb-2">{{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}</p>
                                        <p class="text-muted" style="font-size: 0.85rem;">{{ $address->phone }}</p>
                                    </div>
                                    @empty
                                    <p class="text-muted">No saved addresses</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Right Column (1/3) - Sidebar -->
                        <div class="col-lg-4">
                            <!-- Statistics Card -->
                            <div class="mdc-card mb-3 p-4">
                                <h5 class="mdc-typography--title mb-3">Statistics</h5>
                                
                                <div class="text-center mb-3 pb-3 border-bottom">
                                    <p class="mb-1" style="font-size: 2rem; font-weight: bold; color: #1976d2;">{{ $totalOrders }}</p>
                                    <p class="text-muted small">Total Orders</p>
                                </div>

                                <div class="text-center mb-3 pb-3 border-bottom">
                                    <p class="mb-1" style="font-size: 2rem; font-weight: bold; color: #388e3c;">₹{{ number_format($totalSpent, 2) }}</p>
                                    <p class="text-muted small">Total Spent</p>
                                </div>

                                @if($totalOrders > 0)
                                <div class="text-center">
                                    <p class="mb-1" style="font-size: 1.8rem; font-weight: bold; color: #7b1fa2;">₹{{ number_format($totalSpent / $totalOrders, 2) }}</p>
                                    <p class="text-muted small">Avg Order Value</p>
                                </div>
                                @endif
                            </div>

                            <!-- Quick Actions -->
                            <div class="mdc-card mb-3 p-4">
                                <h5 class="mdc-typography--title mb-3">Actions</h5>
                                
                                <div class="btn-group-vertical w-100" role="group">
                                    <a href="{{ route('admin.customers.orders', $customer->id) }}" class="btn btn-outline-primary text-start" style="border-radius: 4px; margin-bottom: 8px;">
                                        <i class="fa-solid fa-box pe-2"></i>View All Orders
                                    </a>
                                    <a href="{{ route('admin.customers.addresses', $customer->id) }}" class="btn btn-outline-secondary text-start" style="border-radius: 4px; margin-bottom: 8px;">
                                        <i class="fa-solid fa-map-pin pe-2"></i>Manage Addresses
                                    </a>
                                    <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-outline-warning text-start" style="border-radius: 4px;">
                                        <i class="fa-solid fa-pen pe-2"></i>Edit Information
                                    </a>
                                </div>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="mt-3" onsubmit="return confirm('Are you sure? This will delete all customer data.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="fa-solid fa-trash pe-2"></i>Delete Customer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
