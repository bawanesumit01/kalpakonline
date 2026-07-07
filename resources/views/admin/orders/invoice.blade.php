@extends('layouts.app')

@section('content')
<div class="page-wrapper mdc-toolbar-fixed-adjust">
    <main class="content-wrapper">
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card p-0">
                    <!-- Header -->
                    <div class="row mx-4">
                        <div class="col-5 align-self-center">
                            <h4 class="mdc-typography--headline4 pt-2">Invoice</h4>
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
                                <button onclick="window.print()" class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded">
                                    <i class="fa-solid fa-print pe-1"></i>Print
                                </button>
                                <a href="{{ route('admin.orders.show', $order->id) }}">
                                    <button class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded">
                                        <i class="fa-solid fa-arrow-left pe-1"></i>Back
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Content -->
                    <div class="p-5">
                        <!-- Invoice Header -->
                        <div class="row mb-4 pb-4 border-bottom">
                            <div class="col-md-6">
                                <h2 class="fw-bold mb-2">INVOICE</h2>
                                <p class="text-muted mb-1">
                                    <strong>Order Number:</strong> {{ $order->order_number }}
                                </p>
                                <p class="text-muted mb-1">
                                    <strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}
                                </p>
                                <p class="text-muted">
                                    <strong>Status:</strong> 
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
                            <div class="col-md-6 text-end">
                                <h3 class="text-primary fw-bold" style="font-size: 2rem;">₹{{ number_format($order->total, 2) }}</h3>
                                <p class="text-muted">Total Amount</p>
                            </div>
                        </div>

                        <!-- Customer & Shipping Info -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="fw-bold mb-3">Bill To</h5>
                                <p class="mb-1"><strong>{{ $order->name }}</strong></p>
                                <p class="mb-1">{{ $order->email }}</p>
                                <p class="mb-1">{{ $order->phone }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="fw-bold mb-3">Ship To</h5>
                                <p class="mb-1"><strong>{{ $order->name }}</strong></p>
                                <p class="mb-1">{{ $order->address }}</p>
                                @if($order->address_line2)
                                <p class="mb-1">{{ $order->address_line2 }}</p>
                                @endif
                                <p class="mb-1">{{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}</p>
                                <p>{{ $order->country ?? 'India' }}</p>
                            </div>
                        </div>

                        <!-- Items Table -->
                        <div class="mb-4">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-end">Price</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->product_name }}</strong>
                                            <br>
                                            <small class="text-muted">ID: {{ $item->product_id }}</small>
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-center">{{ $item->unit ?? '-' }}</td>
                                        <td class="text-end">₹{{ number_format($item->price, 2) }}</td>
                                        <td class="text-end fw-semibold">₹{{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary -->
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-7"><strong>Subtotal:</strong></div>
                                            <div class="col-5 text-end">₹{{ number_format($order->subtotal, 2) }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-7"><strong>Shipping:</strong></div>
                                            <div class="col-5 text-end">₹{{ number_format($order->shipping, 2) }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-7"><strong>Tax (5%):</strong></div>
                                            <div class="col-5 text-end">₹{{ number_format($order->tax, 2) }}</div>
                                        </div>
                                        @if($order->discount > 0)
                                        <div class="row mb-3 text-success">
                                            <div class="col-7"><strong>Discount:</strong></div>
                                            <div class="col-5 text-end">-₹{{ number_format($order->discount, 2) }}</div>
                                        </div>
                                        @endif
                                        <div class="row pt-3 border-top">
                                            <div class="col-7"><h5 class="mb-0">Total:</h5></div>
                                            <div class="col-5 text-end"><h5 class="mb-0 text-primary">₹{{ number_format($order->total, 2) }}</h5></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Info -->
                        <div class="row mt-5 pt-5 border-top">
                            <div class="col-md-6">
                                <h5 class="fw-bold mb-3">Payment Information</h5>
                                <p class="mb-1">
                                    <strong>Payment Method:</strong> 
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
                                <p>
                                    <strong>Payment Status:</strong> 
                                    <span class="badge
                                        {{ $order->payment_status == 'pending' ? 'bg-warning' : '' }}
                                        {{ $order->payment_status == 'paid' ? 'bg-success' : '' }}
                                        {{ $order->payment_status == 'failed' ? 'bg-danger' : '' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6 text-end">
                                <p class="text-muted">
                                    <small>Invoice Generated on: {{ now()->format('M d, Y H:i:s') }}</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@push('styles')
<style>
    @media print {
        .mdc-card {
            box-shadow: none;
            border: 1px solid #e0e0e0;
        }
        .mdc-toolbar-fixed-adjust,
        .content-wrapper {
            padding: 0;
        }
    }
</style>
@endpush
@endsection
