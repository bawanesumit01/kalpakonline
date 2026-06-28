@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3 fw-bold">Edit Delivery Boy</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <form action="{{ route('admin.delivery.boy.update', $boy->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="Enter full name" value="{{ old('name', $boy->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone (10 digits) *</label>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   placeholder="Enter 10 digit phone" maxlength="10" value="{{ old('phone', $boy->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email *</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   placeholder="Enter email" value="{{ old('email', $boy->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Vehicle Type --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Vehicle Type *</label>
                            <select name="vehicle_type" class="form-control @error('vehicle_type') is-invalid @enderror" required>
                                <option value="">Select vehicle type</option>
                                <option value="bike" {{ old('vehicle_type', $boy->vehicle_type) === 'bike' ? 'selected' : '' }}>Bike</option>
                                <option value="car" {{ old('vehicle_type', $boy->vehicle_type) === 'car' ? 'selected' : '' }}>Car</option>
                                <option value="cycle" {{ old('vehicle_type', $boy->vehicle_type) === 'cycle' ? 'selected' : '' }}>Cycle</option>
                            </select>
                            @error('vehicle_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Vehicle Number --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Vehicle Number</label>
                            <input type="text" name="vehicle_number" class="form-control @error('vehicle_number') is-invalid @enderror" 
                                   placeholder="e.g., MH02AB1234" value="{{ old('vehicle_number', $boy->vehicle_number) }}">
                            @error('vehicle_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status *</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="">Select status</option>
                                <option value="available" {{ old('status', $boy->status) === 'available' ? 'selected' : '' }}>Available</option>
                                <option value="busy" {{ old('status', $boy->status) === 'busy' ? 'selected' : '' }}>Busy</option>
                                <option value="offline" {{ old('status', $boy->status) === 'offline' ? 'selected' : '' }}>Offline</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Info Card --}}
                        <div class="alert alert-info mb-4">
                            <strong>Current Stats:</strong>
                            <br>Rating: ⭐ {{ number_format($boy->rating, 1) }}
                            <br>Total Deliveries: {{ $boy->total_deliveries }}
                            <br>Last Updated: {{ $boy->last_location_update ? $boy->last_location_update->diffForHumans() : 'Never' }}
                        </div>

                        {{-- Buttons --}}
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-2">
                                <i class="fa fa-save"></i> Update Delivery Boy
                            </button>
                            <a href="{{ route('admin.delivery.boys') }}" class="btn btn-outline-secondary btn-lg rounded-2">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
