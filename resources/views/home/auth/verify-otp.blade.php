@extends('home.app')

@section('content')
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">

        <div class="card border-0 shadow-sm rounded-3 p-4">

          <div class="text-center mb-4">
            <h4 class="fw-bold">Verify OTP</h4>
            <p class="text-muted">
              OTP sent to <strong>+91 {{ session('otp_mobile') }}</strong>
            </p>
          </div>

          @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
          @endif

          @if(session('success'))
            <div class="alert alert-success">
              <strong>✅ Success!</strong> 
              <br>{{ session('success') }}
            </div>
          @endif

          @if(session('warning'))
            <div class="alert alert-warning">
              <strong>⚠️ Warning:</strong> 
              <br>{{ session('warning') }}
            </div>
          @endif

          @if(session('info'))
            <div class="alert alert-info">
              {{ session('info') }}
            </div>
          @endif

          <form action="{{ route('customer.verify.otp.submit') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label class="form-label fw-semibold">Enter OTP</label>
              <input type="text"
                     name="otp"
                     class="form-control form-control-lg text-center @error('otp') is-invalid @enderror"
                     placeholder="Enter 6 digit OTP"
                     maxlength="6"
                     required>
              @error('otp')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            {{-- OTP Countdown Timer --}}
            <div class="text-center mb-3">
              <small class="text-muted">OTP expires in <span id="countdown" class="text-danger fw-bold">10:00</span></small>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-lg rounded-1">
                Verify OTP
              </button>
            </div>

            {{-- Resend OTP --}}
            <div class="text-center mt-3">
              <small class="text-muted">Didn't receive OTP?</small>
              <a href="{{ route('customer.login') }}" class="text-primary small ms-1">Resend OTP</a>
            </div>

          </form>

        </div>

      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
// Countdown Timer
let timeLeft = 600; // 10 minutes in seconds
const countdown = document.getElementById('countdown');

const timer = setInterval(function () {
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    countdown.textContent = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

    if (timeLeft <= 0) {
        clearInterval(timer);
        countdown.textContent = 'Expired';
        countdown.classList.remove('text-danger');
        countdown.classList.add('text-secondary');
    }
    timeLeft--;
}, 1000);
</script>
@endpush

@endsection