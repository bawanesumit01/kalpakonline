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
                            <h4 class="mdc-typography--headline4 pt-2">Order Details</h4>
                            <div class="d-flex align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">Orders</a>
                                        </li>
                                        <li class="breadcrumb-item mdc-typography--subtitle1 active" aria-current="page">
                                            #{{ $order->order_number }}
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="col-7 align-self-center">
                            <div class="d-flex no-block justify-content-end align-items-center gap-2">
                                <a href="{{ route('admin.orders.edit', $order->id) }}">
                                    <button class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded">
                                        <i class="fa-solid fa-pen pe-1"></i>Edit
                                    </button>
                                </a>
                                <a href="{{ route('admin.orders.invoice', $order->id) }}">
                                    <button class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded">
                                        <i class="fa-solid fa-file-pdf pe-1"></i>Invoice
                                    </button>
                                </a>
                                <a href="{{ route('admin.orders.index') }}">
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
                            <!-- Order Status Section -->
                            <div class="mdc-card mb-3 p-4">
                                <h5 class="mdc-typography--title mb-3">Order Status</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-muted small mb-1">Order Status</p>
                                        <p class="mb-0">
                                            <span class="badge
                                                {{ $order->status == 'pending' ? 'bg-warning' : '' }}
                                                {{ $order->status == 'confirmed' ? 'bg-info' : '' }}
                                                {{ $order->status == 'processing' ? 'bg-secondary' : '' }}
                                                {{ $order->status == 'shipped' ? 'bg-primary' : '' }}
                                                {{ $order->status == 'delivered' ? 'bg-success' : '' }}
                                                {{ $order->status == 'cancelled' ? 'bg-danger' : '' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-muted small mb-1">Payment Status</p>
                                        <p class="mb-0">
                                            <span class="badge
                                                {{ $order->payment_status == 'pending' ? 'bg-warning' : '' }}
                                                {{ $order->payment_status == 'paid' ? 'bg-success' : '' }}
                                                {{ $order->payment_status == 'failed' ? 'bg-danger' : '' }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Information -->
                            <div class="mdc-card mb-3 p-4">
                                <h5 class="mdc-typography--title mb-3">Customer Information</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-muted small mb-1">Name</p>
                                        <p class="fw-semibold mb-3">{{ $order->name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-muted small mb-1">Phone</p>
                                        <p class="fw-semibold mb-3">{{ $order->phone }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-muted small mb-1">Email</p>
                                        <p class="fw-semibold mb-3">{{ $order->email }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-muted small mb-1">Customer Type</p>
                                        <p class="fw-semibold mb-3">
                                            @if($order->user_id)
                                                <span class="badge bg-primary">Registered</span>
                                            @else
                                                <span class="badge bg-secondary">Guest</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipping Address -->
                            <div class="mdc-card mb-3 p-4">
                                <h5 class="mdc-typography--title mb-3">Shipping Address</h5>
                                <div class="text-secondary">
                                    <p class="mb-1">{{ $order->address }}</p>
                                    @if($order->address_line2)
                                    <p class="mb-1">{{ $order->address_line2 }}</p>
                                    @endif
                                    @if($order->landmark)
                                    <p class="mb-1"><strong><i class="fa-solid fa-location-pin"></i> Landmark:</strong> {{ $order->landmark }}</p>
                                    @endif
                                    <p class="mb-1">{{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}</p>
                                    <p class="mb-0">{{ $order->country ?? 'India' }}</p>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="mdc-card mb-3 p-4">
                                <h5 class="mdc-typography--title mb-3">Order Items</h5>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-left">Product</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Unit</th>
                                                <th class="text-right">Price</th>
                                                <th class="text-right">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->items as $item)
                                            <tr>
                                                <td class="text-left">
                                                    <div>
                                                        <p class="fw-semibold mb-0">{{ $item->product_name }}</p>
                                                        <p class="text-muted small mb-0">ID: {{ $item->product_id }}</p>
                                                    </div>
                                                </td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-center">{{ $item->unit ?? '-' }}</td>
                                                <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                                                <td class="text-right fw-semibold">₹{{ number_format($item->subtotal, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Order Notes -->
                            @if($order->order_notes)
                            <div class="mdc-card p-4">
                                <h5 class="mdc-typography--title mb-3">Order Notes</h5>
                                <p class="text-secondary mb-0">{{ $order->order_notes }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Right Column (1/3) - Sidebar -->
                        <div class="col-lg-4">
                            <!-- Price Summary -->
                            <div class="mdc-card mb-3 p-4">
                                <h5 class="mdc-typography--title mb-3">Price Summary</h5>
                                
                                <div class="mb-3 pb-3 border-bottom">
                                    <div class="row mb-2">
                                        <div class="col-7">
                                            <span class="text-muted">Subtotal</span>
                                        </div>
                                        <div class="col-5 text-end">
                                            <span class="fw-semibold">₹{{ number_format($order->subtotal, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-7">
                                            <span class="text-muted">Shipping</span>
                                        </div>
                                        <div class="col-5 text-end">
                                            <span class="fw-semibold">₹{{ number_format($order->shipping, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-7">
                                            <span class="text-muted">Tax (5%)</span>
                                        </div>
                                        <div class="col-5 text-end">
                                            <span class="fw-semibold">₹{{ number_format($order->tax, 2) }}</span>
                                        </div>
                                    </div>
                                    @if($order->discount > 0)
                                    <div class="row">
                                        <div class="col-7">
                                            <span class="text-success">Discount</span>
                                        </div>
                                        <div class="col-5 text-end">
                                            <span class="fw-semibold text-success">-₹{{ number_format($order->discount, 2) }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <div class="row mb-3 pt-2">
                                    <div class="col-7">
                                        <span class="fw-bold">Total</span>
                                    </div>
                                    <div class="col-5 text-end">
                                        <span class="fw-bold" style="font-size: 1.1rem;">₹{{ number_format($order->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="mdc-card mb-3 p-4" style="background-color: #f5f5f5;">
                                <p class="text-muted small mb-1">Payment Method</p>
                                <p class="fw-semibold mb-0">
                                    @if($order->payment_method == 'cod')
                                        Cash on Delivery
                                    @elseif($order->payment_method == 'online')
                                        Online Payment
                                    @elseif($order->payment_method == 'wallet')
                                        Digital Wallet
                                    @else
                                        {{ ucfirst($order->payment_method) }}
                                    @endif
                                </p>
                            </div>

                            <!-- Order Timeline -->
                            <div class="mdc-card p-4" style="background-color: #f5f5f5;">
                                <p class="fw-semibold small mb-3">Order Timeline</p>
                                <div style="font-size: 0.9rem;">
                                    <div class="row mb-2">
                                        <div class="col-7">
                                            <span class="text-muted">Created</span>
                                        </div>
                                        <div class="col-5 text-end">
                                            <span>{{ $order->created_at->format('M d, Y H:i') }}</span>
                                        </div>
                                    </div>
                                    @if($order->confirmed_at)
                                    <div class="row mb-2">
                                        <div class="col-7">
                                            <span class="text-muted">Confirmed</span>
                                        </div>
                                        <div class="col-5 text-end">
                                            <span>{{ $order->confirmed_at->format('M d, Y H:i') }}</span>
                                        </div>
                                    </div>
                                    @endif
                                    @if($order->shipped_at)
                                    <div class="row mb-2">
                                        <div class="col-7">
                                            <span class="text-muted">Shipped</span>
                                        </div>
                                        <div class="col-5 text-end">
                                            <span>{{ $order->shipped_at->format('M d, Y H:i') }}</span>
                                        </div>
                                    </div>
                                    @endif
                                    @if($order->delivered_at)
                                    <div class="row">
                                        <div class="col-7">
                                            <span class="text-muted">Delivered</span>
                                        </div>
                                        <div class="col-5 text-end">
                                            <span>{{ $order->delivered_at->format('M d, Y H:i') }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
