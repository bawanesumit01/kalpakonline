@extends('home.app')

@section('content')
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">

        <div class="card border-0 shadow-sm rounded-3 p-4">

          {{-- Logo / Title --}}
          <div class="text-center mb-4">
            <h4 class="fw-bold">Welcome to Kalpak Store</h4>
            <p class="text-muted">Enter your mobile number to continue</p>
          </div>

          {{-- Error --}}
          @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
          @endif

          {{-- Success --}}
          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          {{-- Login Form --}}
          <form action="{{ route('customer.send.otp') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label class="form-label fw-semibold">Mobile Number</label>
              <div class="input-group">
                <span class="input-group-text">+91</span>
                <input type="tel"
                       name="mobile"
                       class="form-control @error('mobile') is-invalid @enderror"
                       placeholder="Enter 10 digit mobile number"
                       maxlength="10"
                       value="{{ old('mobile') }}"
                       required>
              </div>
              @error('mobile')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-primary btn-lg rounded-1">
                Send OTP
              </button>
            </div>

          </form>

        </div>

      </div>
    </div>
  </div>
</section>
@endsection