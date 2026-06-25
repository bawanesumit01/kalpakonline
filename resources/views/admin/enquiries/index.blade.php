@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Customer Enquiries
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-wrapper">
    <div class="container-fluid">
        <!-- Stats Cards -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Total Enquiries</div>
                            <div class="ms-auto">
                                <h3 class="card-title">{{ $totalEnquiries }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">New Enquiries</div>
                            <div class="ms-auto">
                                <h3 class="card-title">{{ $newEnquiries }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Responded</div>
                            <div class="ms-auto">
                                <h3 class="card-title">{{ $respondedEnquiries }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($enquiries as $enquiry)
                                    <tr>
                                        <td>
                                            <strong>{{ $enquiry->name }}</strong>
                                            @if($enquiry->phone)
                                                <br><small class="text-muted">{{ $enquiry->phone }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a>
                                        </td>
                                        <td>
                                            {{ ucfirst(str_replace('_', ' ', $enquiry->subject)) }}
                                        </td>
                                        <td>
                                            {!! $enquiry->getStatusLabelAttribute() !!}
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $enquiry->created_at->format('d M Y, H:i') }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.enquiries.show', $enquiry->id) }}" class="btn btn-sm btn-primary">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            No enquiries found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="card-footer d-flex align-items-center">
                    {{ $enquiries->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
