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
                                <h4 class="mdc-typography--headline4 pt-2">Vendor</h4>
                                <div class="d-flex align-items-center">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="#" class="text-decoration-none">Home</a>
                                            </li>
                                            <li class="breadcrumb-item mdc-typography--subtitle1 active"
                                                aria-current="page">
                                                Vendor
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
                                    <a href="{{ route('vendor.index') }}">
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
                        <form class="shadow pt-3" method="POST" action="{{ route('vendor.store') }}">
                            @csrf
                            <div class="row m-2">
                                <!-- Vendor Name -->
                                <div class="col-md-6 my-2">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" id="vendor_name" type="text"
                                            name="vendor_name" value="{{ old('vendor_name') }}" required autofocus
                                            autocomplete="vendor_name">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="vendor_name" class="mdc-floating-label">Vendor Name</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        @error('vendor_name')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Name -->
                                <div class="col-md-6 my-2">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" id="name" type="text" name="name"
                                            value="{{ old('name') }}" required autofocus autocomplete="name">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="name" class="mdc-floating-label">Name</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        @error('name')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email Address -->
                                <div class="col-md-6 my-2">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" id="email" type="email" name="email"
                                            value="{{ old('email') }}" required autofocus autocomplete="name">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="email" class="mdc-floating-label">Email</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        @error('email')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- mobile -->
                                <div class="col-md-6 my-2">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" oninput="if(this.value.length > 10) this.value = this.value.slice(0,10);" 
                                        id="mobile" type="number" name="mobile" value="{{ old('mobile') }}" required autofocus autocomplete="name">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="mobile" class="mdc-floating-label">Mobile Number</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        @error('mobile')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="col-md-6 my-2">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" id="password" type="password" name="password"
                                            required autocomplete="new-password">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="password" class="mdc-floating-label">Password</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        @error('password')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-md-6 my-2">
                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <input class="mdc-text-field__input" id="password_confirmation" type="password"
                                            name="password_confirmation" required autocomplete="new-password">
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="password_confirmation" class="mdc-floating-label">Confirm
                                                    Password</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        @error('password_confirmation')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- role -->
                                <div class="col-md-6 my-2">

                                    <div class="mdc-text-field mdc-text-field--outlined">
                                        <select class="mdc-text-field__input" id="role" name="role" required>
                                            <option value="" disabled selected></option>
                                            <option value="admin">Admin (Vendor)</option>
                                            <option value="client">Client</option>
                                        </select>
                                        <div class="mdc-notched-outline">
                                            <div class="mdc-notched-outline__leading"></div>
                                            <div class="mdc-notched-outline__notch">
                                                <label for="role" class="mdc-floating-label">Role</label>
                                            </div>
                                            <div class="mdc-notched-outline__trailing"></div>
                                        </div>
                                        @error('role')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror

                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center justify-end mt-5 d-flex gap-3 pt2 col-md-12">

                                    <button type="submit"
                                        class="mdc-typography--button mdc-button mdc-button--raised mdc-button--dense mdc-ripple-upgraded"
                                        style="--mdc-ripple-fg-size: 44px; --mdc-ripple-fg-scale: 2.0637770928470114; --mdc-ripple-fg-translate-start: 12.137451171875px, 0.1999969482421875px; --mdc-ripple-fg-translate-end: 15.10000228881836px, -6px;">
                                        Create
                                    </button>
                                </div>
                        </form>


                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
