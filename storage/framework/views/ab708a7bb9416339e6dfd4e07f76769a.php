<?php $__empty_1 = true; $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<div class="cart-item d-flex align-items-center gap-3 border-bottom py-3" id="offcanvas-item-<?php echo e($item->id); ?>">
    <img src="<?php echo e(asset('/' . $item->product->main_image)); ?>"
         width="60" height="60" class="rounded object-fit-cover"
         alt="<?php echo e($item->product->product_name); ?>">
    <div class="flex-grow-1">
        <h6 class="mb-1 fs-6"><?php echo e($item->product->product_name); ?></h6>
        <small class="text-muted">&#8377; <?php echo e($item->product->final_price); ?> each</small>
        <div class="d-flex align-items-center gap-2 mt-2">
            <button class="btn btn-outline-secondary btn-sm px-2 py-0 offcanvas-qty-decrease" data-cart-id="<?php echo e($item->id); ?>">−</button>
            <span class="offcanvas-qty fw-semibold" data-cart-id="<?php echo e($item->id); ?>"><?php echo e($item->quantity); ?></span>
            <button class="btn btn-outline-secondary btn-sm px-2 py-0 offcanvas-qty-increase" data-cart-id="<?php echo e($item->id); ?>">+</button>
        </div>
    </div>
    <div class="text-end">
        <div class="fw-semibold offcanvas-subtotal" data-cart-id="<?php echo e($item->id); ?>">
            &#8377; <?php echo e(number_format($item->product->final_price * $item->quantity, 2)); ?>

        </div>
        <button class="btn btn-link text-danger p-0 mt-1 offcanvas-remove" data-cart-id="<?php echo e($item->id); ?>">
            <small>Remove</small>
        </button>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<div class="text-center py-5">
    <p class="mt-3 text-muted">Your cart is empty</p>
    <a href="/" class="btn btn-primary btn-sm mt-2" data-bs-dismiss="offcanvas">Start Shopping</a>
</div>
<?php endif; ?><?php /**PATH /home/kalpakon/public_html/resources/views/offcanvas-cart-items.blade.php ENDPATH**/ ?>