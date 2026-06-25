@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Enquiry Details
                </h2>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.enquiries.index') }}" class="btn btn-secondary">
                    Back to Enquiries
                </a>
            </div>
        </div>
    </div>
</div>

<div class="page-wrapper">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Enquiry Details -->
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Customer Information</h3>
                        <form action="{{ route('admin.enquiries.status', $enquiry->id) }}" method="POST" class="d-flex gap-2">
                            @csrf
                            <select name="status" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                <option value="new" {{ $enquiry->status === 'new' ? 'selected' : '' }}>New</option>
                                <option value="read" {{ $enquiry->status === 'read' ? 'selected' : '' }}>Read</option>
                                <option value="responded" {{ $enquiry->status === 'responded' ? 'selected' : '' }}>Responded</option>
                                <option value="closed" {{ $enquiry->status === 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <p class="text-body"><strong>{{ $enquiry->name }}</strong></p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <p class="text-body"><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <p class="text-body">{{ $enquiry->phone ?? 'Not provided' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subject</label>
                                <p class="text-body"><strong>{{ ucfirst(str_replace('_', ' ', $enquiry->subject)) }}</strong></p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Received Date</label>
                            <p class="text-body">{{ $enquiry->created_at->format('d M Y, H:i A') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Enquiry Message -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Customer Message</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-light" style="border-left: 4px solid #0d6efd;">
                            {!! nl2br(e($enquiry->message)) !!}
                        </div>
                    </div>
                </div>

                <!-- Admin Response -->
                @if($enquiry->admin_response)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Admin Response</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-light" style="border-left: 4px solid #28a745;">
                                {!! nl2br(e($enquiry->admin_response)) !!}
                            </div>
                            <small class="text-muted">
                                Responded by: {{ $enquiry->admin->name ?? 'System' }} on 
                                {{ $enquiry->responded_at->format('d M Y, H:i A') }}
                            </small>
                        </div>
                    </div>
                @endif

                <!-- Response Form -->
                @if($enquiry->status !== 'closed')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Send Response</h3>
                        </div>
                        <form action="{{ route('admin.enquiries.respond', $enquiry->id) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Response Message</label>
                                    <textarea 
                                        name="admin_response" 
                                        class="form-control @error('admin_response') is-invalid @enderror" 
                                        rows="6"
                                        placeholder="Write your response here..."
                                    >{{ old('admin_response', $enquiry->admin_response) }}</textarea>
                                    @error('admin_response')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">
                                    Send Response
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Info -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Status</h3>
                    </div>
                    <div class="card-body">
                        {!! $enquiry->getStatusLabelAttribute() !!}
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Actions</h3>
                    </div>
                    <div class="card-body d-grid gap-2">
                        <a href="mailto:{{ $enquiry->email }}" class="btn btn-outline-secondary">
                            Reply via Email
                        </a>
                        @if($enquiry->phone)
                            <a href="tel:{{ $enquiry->phone }}" class="btn btn-outline-secondary">
                                Call Customer
                            </a>
                        @endif
                        <form action="{{ route('admin.enquiries.destroy', $enquiry->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Are you sure?')">
                                Delete Enquiry
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
