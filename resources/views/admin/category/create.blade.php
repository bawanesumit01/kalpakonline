@extends('layouts.app')

@section('content')
    <div class="page-wrapper mdc-toolbar-fixed-adjust">
        <main class="content-wrapper">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                    <div class="mdc-card p-0">

                        <!-- Breadcrumbs -->
                        <div class="row mx-4">
                            <div class="col-5 align-self-center">
                                <h4 class="mdc-typography--headline4 pt-2">Category</h4>
                                <div class="d-flex align-items-center">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="#" class="text-decoration-none">Home</a>
                                            </li>
                                            <li class="breadcrumb-item mdc-typography--subtitle1 active"
                                                aria-current="page">
                                                Category
                                            </li>
                                            <li class="breadcrumb-item mdc-typography--subtitle1 active"
                                                aria-current="page">
                                                Create
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-7 align-self-center">
                                <div class="d-flex no-block justify-content-end align-items-center">
                                    <a href="{{ route('category.index') }}">
                                        <button
                                            class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded"
                                            style="--mdc-ripple-fg-size: 44px; --mdc-ripple-fg-scale: 2.0637770928470114; --mdc-ripple-fg-translate-start: 12.137451171875px, 0.1999969482421875px; --mdc-ripple-fg-translate-end: 15.10000228881836px, -6px;">
                                            <i class="fa-solid fa-angle-left pe-1"></i>Back
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- form -->
                        <form class="shadow pt-3" method="POST" action="{{ route('category.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row m-2">
                                <!-- Category Name -->
                                <div class="col-md-6 my-2 ">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" id="category_name" type="text"
                                            name="category_name" value="{{ old('category_name') }}" required autofocus
                                            autocomplete="category_name">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="category_name" class="mdc-floating-label">Category Name</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        @error('category_name')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                @if (auth()->user()->role === 'superadmin')
                                    <!-- vendor -->
                                    <div class="col-md-6 my-2">

                                        <div class="mdc-text-field mdc-text-field--outlined">
                                            <select class="mdc-text-field__input" id="vendor_id" name="vendor_id" required>
                                                <option value="" disabled selected></option>
                                                @foreach ($vendors as $vendor)
                                                    <option value="{{ $vendor->vendor_id }}">{{ $vendor->vendor_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="mdc-notched-outline">
                                                <div class="mdc-notched-outline__leading"></div>
                                                <div class="mdc-notched-outline__notch">
                                                    <label for="vendor_id" class="mdc-floating-label">Vendor</label>
                                                </div>
                                                <div class="mdc-notched-outline__trailing"></div>
                                            </div>
                                            @error('vendor_id')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror

                                        </div>
                                    </div>
                                @else
                                    <!-- ADMIN → Hidden vendor_id -->
                                    <input type="hidden" name="vendor_id" value="{{ auth()->user()->vendor->vendor_id }}">
                                @endif
                                
                                <!-- cat_image -->
                                <div class="col-md-4 my-2">
                                    <div class="">
                                        <label for="cat_image" class="">Category Image  </label>
                                        <input class="" type="file" id="cat_image" name="cat_image"
                                            accept="image/*" onchange="previewCatImage(event)">


                                    </div>

                                    @error('cat_image')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                    <!-- Image Preview -->
                                    <div class="mt-2">
                                        <img id="catImagePreview" src="#" alt="Selected Image Preview"
                                            style="display:none; width:120px; height:120px; object-fit:cover; border:1px solid #ddd; border-radius:8px;">
                                    </div>
                                </div>


                                <!-- Actions -->
                                <div class="col-md-12 flex items-center justify-end mt-3 d-flex gap-3 pt2 ">

                                    <button type="submit"
                                        class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded"
                                        style="--mdc-ripple-fg-size: 44px; --mdc-ripple-fg-scale: 2.0637770928470114; --mdc-ripple-fg-translate-start: 12.137451171875px, 0.1999969482421875px; --mdc-ripple-fg-translate-end: 15.10000228881836px, -6px;">
                                        Create
                                    </button>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        function previewCatImage(event) {
            const input = event.target;
            const preview = document.getElementById('catImagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
