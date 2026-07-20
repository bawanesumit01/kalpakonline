@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">⚙️ Site Settings</h2>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Settings Form -->
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('site-settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Logo Section -->
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label fw-bold mb-3">
                                <i class="bi bi-image"></i> Site Logo
                            </label>
                            
                            <div class="logo-preview-container mb-3 p-3 border rounded" style="background-color: #f8f9fa; min-height: 150px; display: flex; align-items: center; justify-content: center;">
                                @if($settings->logo_path && file_exists(public_path($settings->logo_path)))
                                    <img id="logoPreview" src="{{ asset($settings->logo_path) }}" alt="Current Logo" class="img-fluid" style="max-height: 120px;">
                                @else
                                    <div class="text-center text-muted">
                                        <i class="bi bi-image" style="font-size: 2rem;"></i>
                                        <p class="mt-2">No logo uploaded</p>
                                    </div>
                                @endif
                            </div>

                            <input type="file" name="logo" id="logoInput" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                            <small class="form-text text-muted d-block mt-2">
                                <i class="bi bi-info-circle"></i> Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB
                            </small>
                            @error('logo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label fw-bold mb-3">
                                <i class="bi bi-shop"></i> Site Name
                            </label>
                            <input type="text" name="site_name" class="form-control @error('site_name') is-invalid @enderror" 
                                   value="{{ old('site_name', $settings->site_name) }}" placeholder="Enter site name" required>
                            @error('site_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label fw-bold mb-3">
                                <i class="bi bi-file-text"></i> Site Description
                            </label>
                            <textarea name="site_description" rows="4" class="form-control @error('site_description') is-invalid @enderror" 
                                      placeholder="Enter site description">{{ old('site_description', $settings->site_description) }}</textarea>
                            @error('site_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Contact Information -->
                <h5 class="mb-3">
                    <i class="bi bi-telephone"></i> Contact Information
                </h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-telephone-fill"></i> Phone Number
                            </label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $settings->phone) }}" placeholder="+91-XXXXXXXXXX">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-envelope-fill"></i> Email Address
                            </label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $settings->email) }}" placeholder="support@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">
                                <i class="bi bi-geo-alt-fill"></i> Office Address
                            </label>
                            <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" 
                                      placeholder="Enter office address">{{ old('address', $settings->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex gap-2 justify-content-end mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Logo Preview Script -->
<script>
document.getElementById('logoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const preview = document.getElementById('logoPreview');
            if (preview) {
                preview.src = event.target.result;
            } else {
                const container = document.querySelector('.logo-preview-container');
                container.innerHTML = `<img id="logoPreview" src="${event.target.result}" alt="Logo Preview" class="img-fluid" style="max-height: 120px;">`;
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
