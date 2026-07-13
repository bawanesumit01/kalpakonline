@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('content')
    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                    <div class="mdc-card p-0">

                        <!-- Breadcrumbs -->
                        <div class="row mx-4">
                            <div class="col-8 align-self-center">
                                <h4 class="mdc-typography--headline4 pt-2">Marquee Messages</h4>
                                <div class="d-flex align-items-center">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="#" class="text-decoration-none">Home</a>
                                            </li>
                                            <li class="breadcrumb-item mdc-typography--subtitle1 active"
                                                aria-current="page">
                                                Marquee
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-4 align-self-center">
                                <div class="d-flex no-block justify-content-end align-items-center">
                                    <a href="{{ route('dashboard') }}">
                                        <button
                                            class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded">
                                            <i class="fa-solid fa-arrow-left pe-1"></i>Back
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Display Success Message --}}
                        @if (session('success'))
                            <div class="alert alert-success mx-3 mt-3" role="alert">
                                <h4 class="alert-heading"><i class="fa fa-check-circle"></i> Success!</h4>
                                <hr>
                                <p class="mb-0"><strong>{{ session('success') }}</strong></p>
                            </div>
                        @endif

                        {{-- Display Error Message --}}
                        @if (session('error'))
                            <div class="alert alert-danger mx-3 mt-3" role="alert">
                                <h4 class="alert-heading"><i class="fa fa-exclamation-circle"></i> Error!</h4>
                                <hr>
                                <p class="mb-0"><strong>{{ session('error') }}</strong></p>
                            </div>
                        @endif

                        {{-- Display Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger mx-3 mt-3" role="alert">
                                <h4 class="alert-heading"><i class="fa fa-exclamation-circle"></i> Validation Errors!</h4>
                                <hr>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li><strong>{{ $error }}</strong></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row m-2">

                            <!-- Live Marquee Preview -->
                            <div class="col-md-12 my-3">
                                <div class="mdc-card p-4">
                                    <h5 class="mdc-typography--headline5 mb-3">
                                        <i class="fa-solid fa-eye"></i> Live Preview
                                    </h5>
                                    <p class="text-muted mb-3">How it will appear on the homepage:</p>
                                    <div style="background: #3ca090; color: #fff; padding: 10px 0; position: relative; overflow: hidden;">
                                        <marquee behavior="scroll" direction="left" scrollamount="5"
                                            onmouseover="this.stop()" onmouseout="this.start()" id="marquee-preview">
                                            @foreach($messages as $msg)
                                                <span class="mx-5">
                                                    <i class="{{ $msg->icon }}"></i> <span class="message-preview-{{ $msg->id }}">{{ $msg->message }}</span>
                                                </span>
                                            @endforeach
                                        </marquee>
                                    </div>
                                </div>
                            </div>

                            <!-- Add New Message Form -->
                            <div class="col-md-12 my-3">
                                <div class="mdc-card p-4" style="background: #f8f9fa;">
                                    <h5 class="mdc-typography--headline5 mb-3">
                                        <i class="fa-solid fa-plus"></i> Add New Message
                                    </h5>
                                    <form method="POST" action="{{ route('admin.marquee.store') }}" class="row g-3">
                                        @csrf

                                        <div class="col-md-6">
                                            <label for="message" class="form-label">Message Text <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('message') is-invalid @enderror"
                                                id="message" name="message" rows="2" placeholder="Enter announcement message" maxlength="500" required></textarea>
                                            <small class="text-muted d-block mt-1">
                                                <i class="fa-solid fa-lightbulb"></i> Example: Free Delivery on orders above ₹499
                                            </small>
                                            @error('message')
                                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="icon" class="form-label">Font Awesome Icon <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="icon-preview-new">
                                                    <i class="fa-solid fa-star"></i>
                                                </span>
                                                <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                                    id="icon" name="icon" value="fa-solid fa-star" placeholder="fa-solid fa-star"
                                                    maxlength="100" required>
                                            </div>
                                            <small class="text-muted d-block mt-1">
                                                <i class="fa-solid fa-lightbulb"></i> Examples: fa-solid fa-truck, fa-solid fa-fire, fa-solid fa-gift, fa-solid fa-star
                                            </small>
                                            @error('icon')
                                                <p class="mt-2 text-sm text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success" style="background-color: #3ca090; border-color: #3ca090;">
                                                <i class="fa-solid fa-plus pe-2"></i>Add Message
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Existing Messages -->
                            <div class="col-md-12 my-3">
                                <div class="mdc-card p-4">
                                    <h5 class="mdc-typography--headline5 mb-3">
                                        <i class="fa-solid fa-list"></i> All Messages ({{ $messages->count() }})
                                    </h5>

                                    @if($messages->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="5%">#</th>
                                                        <th width="40%">Message</th>
                                                        <th width="20%">Icon Preview</th>
                                                        <th width="15%">Status</th>
                                                        <th width="20%">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($messages as $msg)
                                                        <tr>
                                                            <td>{{ $msg->order }}</td>
                                                            <td>{{ Str::limit($msg->message, 60) }}</td>
                                                            <td>
                                                                <i class="{{ $msg->icon }}" style="font-size: 1.5rem; color: #3ca090;"></i>
                                                                <small class="d-block text-muted">{{ $msg->icon }}</small>
                                                            </td>
                                                            <td>
                                                                @if($msg->is_active)
                                                                    <span class="badge bg-success">
                                                                        <i class="fa-solid fa-check"></i> Active
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-secondary">
                                                                        <i class="fa-solid fa-ban"></i> Inactive
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <!-- Edit Button -->
                                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                                    data-bs-target="#editModal{{ $msg->id }}">
                                                                    <i class="fa-solid fa-edit"></i> Edit
                                                                </button>

                                                                <!-- Delete Button -->
                                                                <form action="{{ route('admin.marquee.destroy', $msg->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                                        onclick="return confirm('Are you sure you want to delete this message?')">
                                                                        <i class="fa-solid fa-trash"></i> Delete
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>

                                                        <!-- Edit Modal -->
                                                        <div class="modal fade" id="editModal{{ $msg->id }}" tabindex="-1">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">
                                                                            <i class="fa-solid fa-edit"></i> Edit Message
                                                                        </h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <form method="POST" action="{{ route('admin.marquee.update', $msg->id) }}">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label for="message{{ $msg->id }}" class="form-label">Message Text</label>
                                                                                <textarea class="form-control" id="message{{ $msg->id }}"
                                                                                    name="message" rows="2" maxlength="500" required>{{ $msg->message }}</textarea>
                                                                                <small class="text-muted d-block mt-1">Max 500 characters</small>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for="icon{{ $msg->id }}" class="form-label">Font Awesome Icon</label>
                                                                                <div class="input-group mb-3">
                                                                                    <span class="input-group-text" id="icon-preview-{{ $msg->id }}">
                                                                                        <i class="{{ $msg->icon }}"></i>
                                                                                    </span>
                                                                                    <input type="text" class="form-control" id="icon{{ $msg->id }}"
                                                                                        name="icon" value="{{ $msg->icon }}" maxlength="100" required>
                                                                                </div>
                                                                                <small class="text-muted">
                                                                                    Examples: fa-solid fa-truck, fa-solid fa-fire, fa-solid fa-gift
                                                                                </small>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input" type="checkbox" id="is_active{{ $msg->id }}"
                                                                                        name="is_active" value="1" {{ $msg->is_active ? 'checked' : '' }}>
                                                                                    <label class="form-check-label" for="is_active{{ $msg->id }}">
                                                                                        <i class="fa-solid fa-power-off"></i> Active (Show in marquee)
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit" class="btn btn-primary">
                                                                                <i class="fa-solid fa-save pe-2"></i>Save Changes
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fa-solid fa-info-circle"></i> No messages yet. Add your first message using the form above.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Icon Reference Guide -->
                            <div class="col-md-12 my-3">
                                <div class="mdc-card p-4" style="background: #f8f9fa;">
                                    <h5 class="mdc-typography--headline5 mb-3">
                                        <i class="fa-solid fa-book"></i> Font Awesome Icon Reference
                                    </h5>
                                    <p class="text-muted">Popular icons for marquee messages:</p>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <code>fa-solid fa-truck</code> <i class="fa-solid fa-truck ms-2"></i> - Delivery/Shipping
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <code>fa-solid fa-fire</code> <i class="fa-solid fa-fire ms-2"></i> - Sale/Hot
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <code>fa-solid fa-gift</code> <i class="fa-solid fa-gift ms-2"></i> - Offer/Promo
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <code>fa-solid fa-star</code> <i class="fa-solid fa-star ms-2"></i> - Special/Feature
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <code>fa-solid fa-phone</code> <i class="fa-solid fa-phone ms-2"></i> - Contact/Support
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <code>fa-solid fa-clock</code> <i class="fa-solid fa-clock ms-2"></i> - Time/Limited
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <code>fa-solid fa-check</code> <i class="fa-solid fa-check ms-2"></i> - Verified/Quality
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <code>fa-solid fa-bolt</code> <i class="fa-solid fa-bolt ms-2"></i> - Lightning/Fast
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Update icon preview when typing
        document.getElementById('icon').addEventListener('input', function() {
            const iconClass = this.value.trim();
            const preview = document.getElementById('icon-preview-new');
            if (iconClass) {
                preview.innerHTML = `<i class="${iconClass}"></i>`;
            }
        });

        // Update icon preview in modals
        @foreach($messages as $msg)
            document.getElementById('icon{{ $msg->id }}').addEventListener('input', function() {
                const iconClass = this.value.trim();
                const preview = document.getElementById('icon-preview-{{ $msg->id }}');
                if (iconClass) {
                    preview.innerHTML = `<i class="${iconClass}"></i>`;
                }
            });

            // Update message preview in live marquee
            document.getElementById('message{{ $msg->id }}').addEventListener('input', function() {
                const preview = document.querySelector('.message-preview-{{ $msg->id }}');
                if (preview) {
                    preview.textContent = this.value;
                }
            });
        @endforeach
    </script>
@endsection
