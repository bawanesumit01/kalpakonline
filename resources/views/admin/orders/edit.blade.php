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
                            <h4 class="mdc-typography--headline4 pt-2">Edit Order</h4>
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
                                <a href="{{ route('admin.orders.show', $order->id) }}">
                                    <button class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded">
                                        <i class="fa-solid fa-eye pe-1"></i>View
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

                    <!-- Main Content -->
                    <div class="row p-4">
                        <!-- Left Column (2/3) -->
                        <div class="col-lg-8">
                            <!-- Error Messages -->
                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                                <strong>Validation Errors:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Order Status Section -->
                                <div class="mdc-card mb-3 p-4">
                                    <h5 class="mdc-typography--title mb-3">Update Order Status</h5>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Order Status</label>
                                                <select id="status" name="status" class="form-control">
                                                    @foreach($statuses as $status)
                                                    <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                                        {{ ucfirst($status) }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="payment_status" class="form-label">Payment Status</label>
                                                <select id="payment_status" name="payment_status" class="form-control">
                                                    @foreach($paymentStatuses as $paymentStatus)
                                                    <option value="{{ $paymentStatus }}" {{ $order->payment_status == $paymentStatus ? 'selected' : '' }}>
                                                        {{ ucfirst($paymentStatus) }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Notes Section -->
                                <div class="mdc-card mb-3 p-4">
                                    <h5 class="mdc-typography--title mb-3">Order Notes</h5>
                                    
                                    <div class="mb-3">
                                        <label for="order_notes" class="form-label">Additional Notes</label>
                                        <textarea id="order_notes" name="order_notes" rows="4" class="form-control" placeholder="Add any notes about this order...">{{ $order->order_notes }}</textarea>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="mdc-card p-4">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-save pe-2"></i>Save Changes
                                        </button>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-secondary">
                                            <i class="fa-solid fa-times pe-2"></i>Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Right Column (1/3) - Sidebar -->
                        <div class="col-lg-4">
                            <!-- Current Status -->
                            <div class="mdc-card mb-3 p-4">
                                <h5 class="mdc-typography--title mb-3">Current Status</h5>
                                
                                <div class="mb-3 pb-3 border-bottom">
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

                                <div>
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

                            <!-- Order Items -->
                            <div class="mdc-card p-4">
                                <h5 class="mdc-typography--title mb-3">Order Items</h5>
                                
                                <div style="max-height: 300px; overflow-y: auto;">
                                    @foreach($order->items as $item)
                                    <div class="mb-3 pb-3 border-bottom">
                                        <p class="fw-semibold mb-1">{{ $item->product_name }}</p>
                                        <p class="text-muted small mb-1">Qty: {{ $item->quantity }} {{ $item->unit ?? '' }}</p>
                                        <p class="text-muted small mb-0">₹{{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                                        <p class="fw-semibold text-primary">₹{{ number_format($item->subtotal, 2) }}</p>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="mt-3 pt-3 border-top">
                                    <div class="row mb-2">
                                        <div class="col-7"><span class="text-muted">Subtotal</span></div>
                                        <div class="col-5 text-end"><span class="fw-semibold">₹{{ number_format($order->subtotal, 2) }}</span></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-7"><span class="text-muted">Shipping</span></div>
                                        <div class="col-5 text-end"><span class="fw-semibold">₹{{ number_format($order->shipping, 2) }}</span></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-7"><span class="text-muted">Tax (5%)</span></div>
                                        <div class="col-5 text-end"><span class="fw-semibold">₹{{ number_format($order->tax, 2) }}</span></div>
                                    </div>
                                    <div class="row pt-2 border-top">
                                        <div class="col-7"><span class="fw-bold">Total</span></div>
                                        <div class="col-5 text-end"><span class="fw-bold">₹{{ number_format($order->total, 2) }}</span></div>
                                    </div>
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
