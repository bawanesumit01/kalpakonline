@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3 fw-bold">Delivery Boys</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.delivery.boy.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add New Delivery Boy
            </a>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search name, phone, or vehicle..." value="{{ $search }}">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-control">
                        <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="available" {{ $status === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="busy" {{ $status === 'busy' ? 'selected' : '' }}>Busy</option>
                        <option value="offline" {{ $status === 'offline' ? 'selected' : '' }}>Offline</option>
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

    {{-- Delivery Boys Table --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Vehicle</th>
                        <th>Status</th>
                        <th>Rating</th>
                        <th>Deliveries</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($boys as $boy)
                        <tr>
                            <td>
                                <strong>{{ $boy->name }}</strong>
                            </td>
                            <td>
                                {{ $boy->phone }}
                            </td>
                            <td>
                                <small>{{ $boy->email }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ ucfirst($boy->vehicle_type) }}
                                    @if($boy->vehicle_number)
                                        <br><small>{{ $boy->vehicle_number }}</small>
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $boy->status === 'available' ? 'success' : ($boy->status === 'busy' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($boy->status) }}
                                </span>
                            </td>
                            <td>
                                <i class="fa fa-star text-warning"></i> {{ number_format($boy->rating, 1) }}
                            </td>
                            <td>
                                <strong>{{ $boy->total_deliveries }}</strong>
                            </td>
                            <td>
                                <a href="{{ route('admin.delivery.boy.edit', $boy->id) }}" class="btn btn-sm btn-info" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.delivery.boy.delete', $boy->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this delivery boy?')" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                No delivery boys found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="card-footer bg-white">
            {{ $boys->links() }}
        </div>
    </div>
</div>
@endsection
