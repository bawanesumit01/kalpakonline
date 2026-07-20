@extends('layouts.app')

@section('content')
    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                    <div class="mdc-card p-0">
                        <!-- Breadcrumbs & Header -->
                        <div class="row mx-4">
                            <div class="col-8 align-self-center">
                                <h4 class="mdc-typography--headline4 pt-2">🎬 Hero Slider Management</h4>
                            </div>
                            <div class="col-4 align-self-center">
                                <div class="d-flex no-block justify-content-end align-items-center">
                                    <button class="mdc-button mdc-button--raised mdc-button--dense" data-bs-toggle="modal" data-bs-target="#addSliderModal">
                                        <i class="fa-solid fa-plus pe-1"></i>Add New Slider
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Status Messages -->
                        @if (session('success'))
                            <div class="alert alert-success mx-4 mt-3">{{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger mx-4 mt-3">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Sliders Table -->
                        <div class="table-responsive p-4">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Order</th>
                                        <th>Video</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($sliders as $slider)
                                        <tr>
                                            <td>
                                                @if($slider->image_path && file_exists(public_path($slider->image_path)))
                                                    <img src="{{ asset($slider->image_path) }}" alt="Slider" style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                @else
                                                    <span class="badge bg-warning">No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ $slider->title ?? 'N/A' }}</td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" value="{{ $slider->order }}" style="width: 80px;">
                                            </td>
                                            <td>
                                                @if($slider->video_url)
                                                    <span class="badge bg-info">
                                                        <i class="fa-solid fa-video"></i> Yes
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($slider->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editSliderModal{{ $slider->id }}">
                                                    <i class="fa-solid fa-edit"></i> Edit
                                                </button>
                                                <form action="{{ route('hero-slider.destroy', $slider->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this slider?')">
                                                        <i class="fa-solid fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editSliderModal{{ $slider->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Hero Slider</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('hero-slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Image</label>
                                                                <input type="file" name="image" class="form-control" accept="image/*">
                                                                @if($slider->image_path)
                                                                    <small class="text-muted d-block mt-2">Current image: <img src="{{ asset($slider->image_path) }}" style="width: 100px; height: 60px; object-fit: cover;"></small>
                                                                @endif
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Title</label>
                                                                <input type="text" name="title" class="form-control" value="{{ $slider->title }}" maxlength="255">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Description</label>
                                                                <textarea name="description" class="form-control" rows="3" maxlength="1000">{{ $slider->description }}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Video File (Optional)</label>
                                                                <input type="file" name="video" class="form-control" accept="video/mp4,video/webm,video/avi,video/quicktime">
                                                                <small class="text-muted">Supported: MP4, WebM, AVI, MOV. Max 50MB</small>
                                                                @if($slider->video_url && file_exists(public_path($slider->video_url)))
                                                                    <small class="text-muted d-block mt-2">Current video: <strong>{{ basename($slider->video_url) }}</strong></small>
                                                                @endif
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Button Text</label>
                                                                    <input type="text" name="button_text" class="form-control" value="{{ $slider->button_text }}" maxlength="50">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label">Button Link</label>
                                                                    <input type="text" name="button_link" class="form-control" value="{{ $slider->button_link }}" maxlength="500">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 mt-3">
                                                                <label class="form-check">
                                                                    <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $slider->is_active ? 'checked' : '' }}>
                                                                    <span class="form-check-label">Active</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Update Slider</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <p class="text-muted">No sliders found. Add your first slider!</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Slider Modal -->
    <div class="modal fade" id="addSliderModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Hero Slider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('hero-slider.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Image <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                            <small class="text-muted">Max 5MB. Recommended: 1920x600px</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" maxlength="1000"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Video File (Optional)</label>
                            <input type="file" name="video" class="form-control" accept="video/mp4,video/webm,video/avi,video/quicktime">
                            <small class="text-muted">Supported: MP4, WebM, AVI, MOV. Max 50MB</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Button Text</label>
                                <input type="text" name="button_text" class="form-control" value="Start Shopping" maxlength="50">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Button Link</label>
                                <input type="text" name="button_link" class="form-control" value="/shop" maxlength="500">
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" value="1" checked>
                                <span class="form-check-label">Active</span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Slider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
