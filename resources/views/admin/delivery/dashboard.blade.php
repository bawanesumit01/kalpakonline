@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3 fw-bold">Delivery Dashboard</h1>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Deliveries</p>
                            <h3 class="fw-bold mb-0">{{ $totalDeliveries }}</h3>
                        </div>
                        <div class="fs-1 text-primary">
                            <i class="fa fa-box"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Today's Deliveries</p>
                            <h3 class="fw-bold mb-0">{{ $todayDeliveries }}</h3>
                        </div>
                        <div class="fs-1 text-info">
                            <i class="fa fa-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Completed Today</p>
                            <h3 class="fw-bold text-success mb-0">{{ $completedToday }}</h3>
                        </div>
                        <div class="fs-1 text-success">
                            <i class="fa fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Active Deliveries</p>
                            <h3 class="fw-bold text-warning mb-0">{{ $activeDeliveries }}</h3>
                        </div>
                        <div class="fs-1 text-warning">
                            <i class="fa fa-motorcycle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delivery Boys Statistics --}}
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Delivery Boys</p>
                            <h3 class="fw-bold mb-0">{{ $totalBoys }}</h3>
                        </div>
                        <div class="fs-1 text-primary">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Available Boys</p>
                            <h3 class="fw-bold text-success mb-0">{{ $availableBoys }}</h3>
                        </div>
                        <div class="fs-1 text-success">
                            <i class="fa fa-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Quick Actions</h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.delivery.index') }}" class="btn btn-primary">
                            <i class="fa fa-list"></i> View All Deliveries
                        </a>
                        <a href="{{ route('admin.delivery.boys') }}" class="btn btn-info">
                            <i class="fa fa-users"></i> Manage Delivery Boys
                        </a>
                        <a href="{{ route('admin.delivery.boy.create') }}" class="btn btn-success">
                            <i class="fa fa-plus"></i> Add Delivery Boy
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Deliveries --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header">
                    <h5 class="mb-0">Recent Deliveries</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Delivery Boy</th>
                                <th>Status</th>
                                <th>Customer</th>
                                <th>Assigned</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentDeliveries as $delivery)
                                <tr>
                                    <td><strong>#{{ $delivery->order_id }}</strong></td>
                                    <td>
                                        @if($delivery->deliveryBoy)
                                            {{ $delivery->deliveryBoy->name }}
                                        @else
                                            <span class="badge bg-warning">Not Assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $delivery->status === 'delivered' ? 'success' : ($delivery->status === 'failed' ? 'danger' : 'info') }}">
                                            {{ ucfirst(str_replace('_', ' ', $delivery->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $delivery->order->customer_name ?? 'N/A' }}</td>
                                    <td>{{ $delivery->assigned_at ? $delivery->assigned_at->format('d M h:i A') : '-' }}</td>
                                    <td>
                                        <a href="{{ route('admin.delivery.show', $delivery->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-3 text-muted">No recent deliveries</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
