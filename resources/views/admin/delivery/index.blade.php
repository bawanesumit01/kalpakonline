@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3 fw-bold">Live Deliveries</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.delivery.dashboard') }}" class="btn btn-primary">
                <i class="fa fa-chart-line"></i> Dashboard
            </a>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search order or delivery boy..." value="{{ $search }}">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-control">
                        <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="picked_up" {{ $status === 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                        <option value="on_way" {{ $status === 'on_way' ? 'selected' : '' }}>On Way</option>
                        <option value="delivered" {{ $status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fa fa-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Deliveries Table --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Delivery Boy</th>
                        <th>Status</th>
                        <th>Customer</th>
                        <th>Address</th>
                        <th>Assigned</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deliveries as $delivery)
                        <tr>
                            <td>
                                <strong>#{{ $delivery->order_id }}</strong>
                            </td>
                            <td>
                                @if($delivery->deliveryBoy)
                                    <div>
                                        <p class="mb-0 fw-bold">{{ $delivery->deliveryBoy->name }}</p>
                                        <small class="text-muted">{{ $delivery->deliveryBoy->vehicle_number }}</small>
                                    </div>
                                @else
                                    <span class="badge bg-warning">Not Assigned</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $delivery->status === 'delivered' ? 'success' : ($delivery->status === 'failed' ? 'danger' : 'info') }}">
                                    {{ ucfirst(str_replace('_', ' ', $delivery->status)) }}
                                </span>
                            </td>
                            <td>
                                <p class="mb-0">{{ $delivery->order->customer_name ?? 'N/A' }}</p>
                                <small class="text-muted">{{ $delivery->order->customer_phone ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <small>{{ Str::limit($delivery->delivery_address, 40) }}</small>
                            </td>
                            <td>
                                <small>{{ $delivery->assigned_at ? $delivery->assigned_at->format('d M Y, h:i A') : '-' }}</small>
                            </td>
                            <td>
                                <a href="{{ route('admin.delivery.show', $delivery->id) }}" class="btn btn-sm btn-info" title="View Details">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                No deliveries found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="card-footer bg-white">
            {{ $deliveries->links() }}
        </div>
    </div>
</div>
@endsection
