@extends('layouts.app')

@section('content')
<div class="page-wrapper mdc-toolbar-fixed-adjust">
    <main class="content-wrapper">
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card p-0">
                    <!-- Breadcrumbs -->
                    <div class="row mx-4">
                        <div class="col-5 align-self-center">
                            <h4 class="mdc-typography--headline4 pt-2">Dashboard</h4>
                            <div class="d-flex align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="#" class="text-decoration-none">Home</a>
                                        </li>
                                        <li class="breadcrumb-item mdc-typography--subtitle1 active" aria-current="page">
                                            Orders
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="col-7 align-self-center">
                            <div class="d-flex no-block justify-content-end align-items-center gap-2">
                                <a href="{{ route('admin.orders.statistics') }}">
                                    <button class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded">
                                        <i class="fa-solid fa-chart-bar pe-1"></i>Statistics
                                    </button>
                                </a>
                                <a href="{{ route('admin.orders.export') }}">
                                    <button class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded">
                                        <i class="fa-solid fa-download pe-1"></i>Export CSV
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="p-4">
                        <form method="GET" class="row">
                            <div class="col-md-3">
                                <label class="form-label">Search Order/Phone/Email</label>
                                <input type="text" name="search" placeholder="Search..." 
                                       value="{{ request('search') }}" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Order Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Payment Status</label>
                                <select name="payment_status" class="form-control">
                                    <option value="">All Payment</option>
                                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="cancelled" {{ request('payment_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fa-solid fa-search pe-1"></i>Filter
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive shadow p-2">
                        <table id="all-table-common" class="table table-striped p-2">
                            <thead>
                                <tr>
                                    <th class="text-left">Order #</th>
                                    <th class="text-left">Customer Name</th>
                                    <th class="text-left">Phone</th>
                                    <th class="text-left">Amount</th>
                                    <th class="text-left">Status</th>
                                    <th class="text-left">Payment</th>
                                    <th class="text-left">Date</th>
                                    <th class="text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td class="text-left">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary">
                                            {{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td class="text-left">{{ $order->name }}</td>
                                    <td class="text-left">{{ $order->phone }}</td>
                                    <td class="text-left">₹{{ number_format($order->total, 2) }}</td>
                                    <td class="text-left">
                                        <span class="badge
                                            {{ $order->status == 'pending' ? 'bg-warning' : '' }}
                                            {{ $order->status == 'confirmed' ? 'bg-info' : '' }}
                                            {{ $order->status == 'processing' ? 'bg-secondary' : '' }}
                                            {{ $order->status == 'shipped' ? 'bg-primary' : '' }}
                                            {{ $order->status == 'delivered' ? 'bg-success' : '' }}
                                            {{ $order->status == 'cancelled' ? 'bg-danger' : '' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="text-left">
                                        <span class="badge
                                            {{ $order->payment_status == 'pending' ? 'bg-warning' : '' }}
                                            {{ $order->payment_status == 'paid' ? 'bg-success' : '' }}
                                            {{ $order->payment_status == 'failed' ? 'bg-danger' : '' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="text-left">{{ $order->created_at->format('M d, Y') }}</td>
                                    <td class="text-left">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">No orders found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($orders->hasPages())
                    <div class="p-4">
                        {{ $orders->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
