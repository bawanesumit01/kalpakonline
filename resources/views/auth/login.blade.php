
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kalpak Store</title>
    @include('components.css')
    <link rel="shortcut icon" href="{{ asset('/assets/images/kp.png') }}" />
</head>

<body> 
    <script src="{{ asset('/assets/js/preloader.js') }}"></script>
    <div class="body-wrapper">
        <div class="main-wrapper">
            <div class="page-wrapper full-page-wrapper d-flex align-items-center justify-content-center">
                <main class="auth-page">
                    <div class="mdc-layout-grid">
                        <div class="mdc-layout-grid__inner">
                            <div
                                class="stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-1-tablet">
                            </div>
                            <div
                                class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-6-tablet">
                                <div class="mdc-card">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mdc-layout-grid">
                                            <div class="mdc-layout-grid__inner">
                                                <div
                                                    class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                                    <div class="mdc-text-field w-100">
                                                        <input class="mdc-text-field__input" id="email"
                                                            type="email" name="email" value="{{ old('email') }}"
                                                            required autofocus autocomplete="username">
                                                        <div class="mdc-line-ripple"></div>
                                                        <label for="email" class="mdc-floating-label">Email</label>

                                                        @error('email')
                                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div
                                                    class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                                    <div class="mdc-text-field w-100">
                                                        <input class="mdc-text-field__input" type="password"
                                                            id="password" type="password" name="password" required
                                                            autocomplete="current-password">
                                                        <div class="mdc-line-ripple"></div>
                                                        <label for="password"
                                                            class="mdc-floating-label">Password</label>
                                                        @error('password')
                                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div
                                                    class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                                    <div class="mdc-form-field">
                                                        <div class="mdc-checkbox">
                                                            <input type="checkbox" class="mdc-checkbox__native-control"
                                                                id="checkbox-1" name="remember" />

                                                            <div class="mdc-checkbox__background">
                                                                <svg class="mdc-checkbox__checkmark"
                                                                    viewBox="0 0 24 24">
                                                                    <path class="mdc-checkbox__checkmark-path"
                                                                        fill="none"
                                                                        d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                                                </svg>
                                                                <div class="mdc-checkbox__mixedmark"></div>
                                                            </div>
                                                        </div>
                                                        <label for="checkbox-1">Remember me</label>

                                                    </div>
                                                </div>
                                                <div
                                                    class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop d-flex align-items-center justify-content-end">
                                                    @if (Route::has('password.request'))
                                                        <a href="{{ route('password.request') }}"
                                                            class="text-sm text-gray-600 dark:text-gray-400 underline
                                                        hover:text-gray-900 dark:hover:text-gray-100
                                                        focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                                            Forgot your password?
                                                        </a>
                                                    @endif
                                                </div>
                                                <div
                                                    class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                                    <button type="submit"
                                                        class="mdc-button mdc-button--raised w-100">
                                                        Login
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div
                                class="stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-1-tablet">
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
    @include('components.js')
</body>

</html>
