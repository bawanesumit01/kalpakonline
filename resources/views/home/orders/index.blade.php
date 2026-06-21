@extends('home.app')

@section('content')
<section class="orders-section py-5">
    <div class="container-lg">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Orders</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4">My Orders</h2>
            <a href="{{ route('home.index') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-arrow-left"></i>
                Continue Shopping
            </a>
        </div>

        @if($orders->count() > 0)
            <!-- Orders List as Accordion -->
            <div class="accordion" id="ordersAccordion">
                @foreach($orders as $order)
                    <div class="accordion-item order-card">
                        <h2 class="accordion-header" id="heading{{ $order->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $order->id }}" aria-expanded="false" aria-controls="collapse{{ $order->id }}">
                                <div class="accordion-title-content w-100">
                                    <div class="row align-items-center w-100">
                                        <div class="col-md-4">
                                            <strong>Order #{{ $order->order_number }}</strong><br>
                                            <small class="text-muted">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</small>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Status:</strong>
                                            <span class="badge 
                                                @if($order->status == 'pending') bg-warning
                                                @elseif($order->status == 'confirmed') bg-info
                                                @elseif($order->status == 'shipped') bg-primary
                                                @elseif($order->status == 'delivered') bg-success
                                                @elseif($order->status == 'cancelled') bg-danger
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <strong>Total: ₹{{ number_format($order->total, 2) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="collapse{{ $order->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $order->id }}" data-bs-parent="#ordersAccordion">
                            <div class="accordion-body">
                            <!-- Order Items -->
                            <h6 class="mb-3">Items</h6>
                            <table class="table table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                @if($item->product)
                                                    <a href="{{ route('product.details', $item->product->id) }}">
                                                        {{ $item->product->name }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">(Product deleted)</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>₹{{ number_format($item->price, 2) }}</td>
                                            <td>₹{{ number_format($item->subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Pricing Breakdown -->
                            <div class="row mt-3">
                                <div class="col-md-6 offset-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <td>Subtotal</td>
                                            <td class="text-end">₹{{ number_format($order->subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping</td>
                                            <td class="text-end">
                                                @if($order->shipping == 0)
                                                    <span class="text-success">FREE</span>
                                                @else
                                                    ₹{{ number_format($order->shipping, 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tax (GST)</td>
                                            <td class="text-end">₹{{ number_format($order->tax, 2) }}</td>
                                        </tr>
                                        @if($order->discount > 0)
                                            <tr>
                                                <td>Discount</td>
                                                <td class="text-end text-success">-₹{{ number_format($order->discount, 2) }}</td>
                                            </tr>
                                        @endif
                                        <tr class="table-active fw-bold">
                                            <td>Total</td>
                                            <td class="text-end">₹{{ number_format($order->total, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Shipping Address -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h6>Shipping Address</h6>
                                    <p class="mb-0">
                                        <strong>{{ $order->name }}</strong><br>
                                        {{ $order->address }}
                                        @if($order->address_line2)
                                            <br>{{ $order->address_line2 }}
                                        @endif
                                        <br>{{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}
                                        <br>{{ $order->country }}<br>
                                        <br>
                                        <strong>Phone:</strong> {{ $order->phone }}<br>
                                        <strong>Email:</strong> {{ $order->email }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Order Details</h6>
                                    <p class="mb-0">
                                        <strong>Payment Method:</strong> 
                                        @switch($order->payment_method)
                                            @case('cod')
                                                Cash on Delivery
                                                @break
                                            @case('online')
                                                Online Payment
                                                @break
                                            @case('wallet')
                                                Wallet
                                                @break
                                            @default
                                                {{ ucfirst($order->payment_method) }}
                                        @endswitch
                                        <br>
                                        <strong>Payment Status:</strong> 
                                        <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                        <br><br>
                                        @if($order->order_notes)
                                            <strong>Order Notes:</strong><br>
                                            {{ $order->order_notes }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @else
            <!-- No Orders Message -->
            <div class="alert alert-info text-center py-5">
                <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                <h5 class="mt-3">No Orders Yet</h5>
                <p class="mb-0">You haven't placed any orders. Start shopping now!</p>
                <a href="{{ route('home.index') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-shop"></i>
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</section>

<style>
.orders-section {
    min-height: 500px;
    background-color: #f8f9fa;
}

.accordion {
    border: none;
}

.accordion-item {
    border: 1px solid #dee2e6;
    border-bottom: none;
    border-left: 4px solid #3ca090;
}

.accordion-item:last-child {
    border-bottom: 1px solid #dee2e6;
}

.accordion-button {
    padding: 1rem;
    background-color: #f8f9fa;
    border: none;
    font-weight: 500;
}

.accordion-button:not(.collapsed) {
    background-color: #e8f4f1;
    color: #3ca090;
    box-shadow: none;
    border-color: #3ca090;
}

.accordion-button:focus {
    box-shadow: none;
    border-color: #3ca090;
}

.accordion-button::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%233ca090'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
}

.accordion-title-content {
    margin: 0;
    padding: 0;
}

.accordion-body {
    padding: 1.5rem;
    background-color: #fff;
    border-top: 1px solid #dee2e6;
}

.order-card {
    transition: all 0.3s ease;
    margin-bottom: 1rem;
}

.order-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.accordion-body .table {
    margin-bottom: 0;
}
</style>
@endsection
