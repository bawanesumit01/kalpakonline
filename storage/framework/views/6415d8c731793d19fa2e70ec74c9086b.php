

<?php $__env->startSection('content'); ?>
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">

        <div class="card border-0 shadow-sm rounded-3 p-4">

          
          <div class="text-center mb-4">
            <h4 class="fw-bold">Welcome to Kalpak Store</h4>
            <p class="text-muted">Enter your mobile number to continue</p>
          </div>

          
          <?php if($errors->any()): ?>
            <div class="alert alert-danger"><?php echo e($errors->first()); ?></div>
          <?php endif; ?>

          
          <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
          <?php endif; ?>

          
          <form action="<?php echo e(route('customer.send.otp')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="mb-3">
              <label class="form-label fw-semibold">Mobile Number</label>
              <div class="input-group">
                <span class="input-group-text">+91</span>
                <input type="tel"
                       name="mobile"
                       class="form-control <?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       placeholder="Enter 10 digit mobile number"
                       maxlength="10"
                       value="<?php echo e(old('mobile')); ?>"
                       required>
              </div>
              <?php $__errorArgs = ['mobile'];
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kalpakon/public_html/resources/views/home/auth/login.blade.php ENDPATH**/ ?>