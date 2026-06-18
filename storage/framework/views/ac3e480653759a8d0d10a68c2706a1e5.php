

<?php $__env->startSection('content'); ?>
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">

        <div class="card border-0 shadow-sm rounded-3 p-4">

          <div class="text-center mb-4">
            <h4 class="fw-bold">Verify OTP</h4>
            <p class="text-muted">
              OTP sent to <strong>+91 <?php echo e(session('otp_mobile')); ?></strong>
            </p>
          </div>

          <?php if($errors->any()): ?>
            <div class="alert alert-danger"><?php echo e($errors->first()); ?></div>
          <?php endif; ?>

          <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
          <?php endif; ?>

          <form action="<?php echo e(route('customer.verify.otp.submit')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="mb-3">
              <label class="form-label fw-semibold">Enter OTP</label>
              <input type="text"
                     name="otp"
                     class="form-control form-control-lg text-center <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                     placeholder="Enter 6 digit OTP"
                     maxlength="6"
                     required>
              <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="text-center mb-3">
              <small class="text-muted">OTP expires in <span id="countdown" class="text-danger fw-bold">10:00</span></small>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary btn-lg rounded-1">
                Verify OTP
              </button>
            </div>

            
            <div class="text-center mt-3">
              <small class="text-muted">Didn't receive OTP?</small>
              <a href="<?php echo e(route('customer.login')); ?>" class="text-primary small ms-1">Resend OTP</a>
            </div>

          </form>

        </div>

      </div>
    </div>
  </div>
</section>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kalpakon/public_html/resources/views/home/auth/verify-otp.blade.php ENDPATH**/ ?>