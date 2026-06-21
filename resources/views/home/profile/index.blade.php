@extends('home.app')

@section('content')
<section class="profile-section py-5">
    <div class="container-lg">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Profile</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4">My Profile</h2>
            <a href="{{ route('home.index') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>
        </div>

        <div class="row">
            <!-- Profile Card -->
            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="avatar-placeholder mb-3">
                                <i class="bi bi-person-circle" style="font-size: 4rem; color: #3ca090;"></i>
                            </div>
                        </div>
                        
                        <div class="profile-info">
                            <p class="mb-2">
                                <strong>Name:</strong><br>
                                {{ $user->name }}
                            </p>
                            <p class="mb-2">
                                <strong>Email:</strong><br>
                                {{ $user->email }}
                            </p>
                            <p class="mb-2">
                                <strong>Phone:</strong><br>
                                @if($user->mobile)
                                    +91 {{ $user->mobile }}
                                @else
                                    <span class="text-muted">Not provided</span>
                                @endif
                            </p>
                            <p class="mb-0">
                                <strong>Member Since:</strong><br>
                                {{ $user->created_at->format('M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Quick Links</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('client.orders') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-box-seam"></i>
                            My Orders
                        </a>
                        <a href="{{ route('client.profile') }}" class="list-group-item list-group-item-action active">
                            <i class="bi bi-person"></i>
                            Profile
                        </a>
                        <a href="{{ route('cart.view') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-cart"></i>
                            Shopping Cart
                        </a>
                        <form action="{{ route('customer.logout') }}" method="POST" class="d-contents">
                            @csrf
                            <button type="submit" class="list-group-item list-group-item-action text-danger">
                                <i class="bi bi-box-arrow-left"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Account Details -->
            <div class="col-lg-8">
                <!-- Account Overview -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="bi bi-box-seam" style="font-size: 2rem; color: #3ca090;"></i>
                                <h5 class="card-title mt-2">Total Orders</h5>
                                <p class="card-text h4">
                                    {{ \App\Models\Order::where('user_id', $user->id)->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="bi bi-cash-coin" style="font-size: 2rem; color: #27ae60;"></i>
                                <h5 class="card-title mt-2">Total Spent</h5>
                                <p class="card-text h4">
                                    ₹{{ number_format(\App\Models\Order::where('user_id', $user->id)->sum('total'), 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="bi bi-check-circle" style="font-size: 2rem; color: #3498db;"></i>
                                <h5 class="card-title mt-2">Delivered</h5>
                                <p class="card-text h4">
                                    {{ \App\Models\Order::where('user_id', $user->id)->where('status', 'delivered')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Saved Addresses -->
                <div class="card mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Saved Addresses</h5>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                            <i class="bi bi-plus"></i>
                            Add New
                        </button>
                    </div>
                    <div class="card-body">
                        @if($user->addresses()->count() > 0)
                            <div class="row">
                                @foreach($user->addresses as $address)
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100 address-card @if($address->is_default) border-primary @endif">
                                            <div class="card-body">
                                                @if($address->is_default)
                                                    <span class="badge bg-primary mb-2">Default</span>
                                                @endif
                                                <h6 class="card-title">{{ $address->name }}</h6>
                                                <p class="card-text mb-2">
                                                    {{ $address->address }}
                                                    @if($address->address_line2)
                                                        <br>{{ $address->address_line2 }}
                                                    @endif
                                                    <br>{{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}
                                                    <br>{{ $address->country }}
                                                </p>
                                                <p class="card-text">
                                                    <small class="text-muted">
                                                        <strong>Phone:</strong> {{ $address->phone }}<br>
                                                        <strong>Type:</strong> {{ ucfirst($address->address_type) }}
                                                    </small>
                                                </p>
                                            </div>
                                            <div class="card-footer bg-light">
                                                <button class="btn btn-sm btn-outline-secondary" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center py-4">
                                No saved addresses. Add one to make checkout faster!
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="card">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Orders</h5>
                        <a href="{{ route('client.orders') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        @php
                            $recentOrders = \App\Models\Order::where('user_id', $user->id)
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();
                        @endphp

                        @if($recentOrders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentOrders as $order)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('order.success', $order->id) }}" class="text-decoration-none">
                                                        {{ substr($order->order_number, 0, 15) }}...
                                                    </a>
                                                </td>
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                <td>₹{{ number_format($order->total, 2) }}</td>
                                                <td>
                                                    <span class="badge 
                                                        @if($order->status == 'pending') bg-warning
                                                        @elseif($order->status == 'confirmed') bg-info
                                                        @elseif($order->status == 'shipped') bg-primary
                                                        @elseif($order->status == 'delivered') bg-success
                                                        @elseif($order->status == 'cancelled') bg-danger
                                                        @endif">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center py-4">
                                No orders yet. <a href="{{ route('home.index') }}">Start shopping</a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Address management coming soon!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
.profile-section {
    min-height: 600px;
    background-color: #f8f9fa;
}

.avatar-placeholder {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background-color: #e8f4f1;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.address-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.address-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.profile-info p {
    font-size: 0.95rem;
    line-height: 1.6;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}
</style>
@endsection
