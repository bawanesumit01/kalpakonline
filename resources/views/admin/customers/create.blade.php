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
                            <h4 class="mdc-typography--headline4 pt-2">Create New Customer</h4>
                            <div class="d-flex align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('admin.customers.index') }}" class="text-decoration-none">Customers</a>
                                        </li>
                                        <li class="breadcrumb-item mdc-typography--subtitle1 active" aria-current="page">
                                            Create
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="col-7 align-self-center">
                            <div class="d-flex no-block justify-content-end align-items-center gap-2">
                                <a href="{{ route('admin.customers.index') }}">
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

                            <!-- Success Message -->
                            @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <form action="{{ route('admin.customers.store') }}" method="POST">
                                @csrf

                                <!-- Personal Information -->
                                <div class="mdc-card mb-3 p-4">
                                    <h5 class="mdc-typography--title mb-3">Personal Information</h5>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                                <input type="text" id="name" name="name" value="{{ old('name') }}" 
                                                       class="form-control @error('name') is-invalid @enderror" required 
                                                       placeholder="Enter customer full name">
                                                @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="mobile" class="form-label">Mobile Number (10 digits) <span class="text-danger">*</span></label>
                                                <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}" 
                                                       placeholder="9876543210" class="form-control @error('mobile') is-invalid @enderror" 
                                                       required maxlength="10">
                                                @error('mobile')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                                               class="form-control @error('email') is-invalid @enderror" required
                                               placeholder="customer@example.com">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="mdc-card p-4">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-plus pe-2"></i>Create Customer
                                        </button>
                                        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                                            <i class="fa-solid fa-times pe-2"></i>Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Right Column (1/3) - Info -->
                        <div class="col-lg-4">
                            <!-- Information Card -->
                            <div class="mdc-card mb-3 p-4">
                                <h5 class="mdc-typography--title mb-3">Required Information</h5>
                                
                                <div class="mb-3 pb-3 border-bottom">
                                    <p class="text-muted small mb-1">Full Name</p>
                                    <p class="small">Customer's complete name as they would like it displayed</p>
                                </div>

                                <div class="mb-3 pb-3 border-bottom">
                                    <p class="text-muted small mb-1">Mobile Number</p>
                                    <p class="small">10-digit mobile number without country code (e.g., 9876543210)</p>
                                </div>

                                <div>
                                    <p class="text-muted small mb-1">Email Address</p>
                                    <p class="small">Valid email address for communication and order updates</p>
                                </div>
                            </div>

                            <!-- Tips Card -->
                            <div class="mdc-card p-4" style="background-color: #f5f5f5;">
                                <h5 class="mdc-typography--title mb-3">Tips</h5>
                                
                                <ul style="font-size: 0.95rem; padding-left: 1rem;">
                                    <li class="mb-2">Ensure mobile number is unique</li>
                                    <li class="mb-2">Email should be valid and unique</li>
                                    <li class="mb-2">Customer can update info later</li>
                                    <li>All fields are required</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
