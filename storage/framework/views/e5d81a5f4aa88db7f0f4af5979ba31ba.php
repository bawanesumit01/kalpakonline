

<?php $__env->startSection('content'); ?>
<section class="py-5">
  <div class="container-lg">
    <h2 class="mb-4">Shopping Cart</h2>

    <?php if($cartItems->isEmpty()): ?>
      <div class="text-center py-5">
        <svg width="64" height="64"><use xlink:href="#cart"></use></svg>
        <h4 class="mt-3">Your cart is empty</h4>
        <a href="<?php echo e(route('home.index')); ?>" class="btn btn-primary mt-3">Continue Shopping</a>
      </div>
    <?php else: ?>
    <div class="row">
      <div class="col-lg-8">
        <table class="table align-middle">
          <thead class="table-light">
            <tr>
              <th>Product</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Subtotal</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr id="cart-row-<?php echo e($item->id); ?>">
              <td>
                <div class="d-flex align-items-center gap-3">
                  <img src="<?php echo e(asset('/' . $item->product->main_image)); ?>"
                       width="60" alt="<?php echo e($item->product->product_name); ?>">
                  <span><?php echo e($item->product->product_name); ?></span>
                </div>
              </td>
              <td>&#8377; <?php echo e($item->product->final_price); ?></td>
              <td>
                <input type="number"
                       class="form-control qty-input"
                       style="width:80px"
                       value="<?php echo e($item->quantity); ?>"
                       min="1"
                       data-cart-id="<?php echo e($item->id); ?>">
              </td>
              <td class="item-subtotal">
                &#8377; <?php echo e(number_format($item->product->final_price * $item->quantity, 2)); ?>

              </td>
              <td>
                <button class="btn btn-sm btn-danger btn-remove"
                        data-cart-id="<?php echo e($item->id); ?>">
                  &times;
                </button>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>

      <div class="col-lg-4">
        <div class="card border-0 shadow-sm p-4">
          <h5>Order Summary</h5>
          <hr>
          <div class="d-flex justify-content-between mb-3">
            <span>Total</span>
            <strong id="cart-total">&#8377; <?php echo e(number_format($total, 2)); ?></strong>
          </div>
          <a href="#" class="btn btn-primary w-100">Proceed to Checkout</a>
          <a href="<?php echo e(route('home.index')); ?>" class="btn btn-outline-secondary w-100 mt-2">
            Continue Shopping
          </a>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php $__env->startPush('scripts'); ?>
<script>
// Update quantity
$(document).on('change', '.qty-input', function () {
    const cartId  = $(this).data('cart-id');
    const qty     = $(this).val();
    const row     = $('#cart-row-' + cartId);

    $.post("<?php echo e(route('cart.update')); ?>", {
        _token:   "<?php echo e(csrf_token()); ?>",
        cart_id:  cartId,
        quantity: qty,
    }, function (res) {
        if (res.success) {
            row.find('.item-subtotal').html('&#8377; ' + res.subtotal);
            $('#cart-total').html('&#8377; ' + res.cartTotal);
            $('.cart-count').text(
                parseInt($('.cart-count').text()) // recount if needed
            );
        }
    });
});

// Remove item
$(document).on('click', '.btn-remove', function () {
    const cartId = $(this).data('cart-id');

    $.post("<?php echo e(route('cart.remove')); ?>", {
        _token:  "<?php echo e(csrf_token()); ?>",
        cart_id: cartId,
    }, function (res) {
        if (res.success) {
            $('#cart-row-' + cartId).fadeOut(300, function () { $(this).remove(); });
            $('#cart-total').html('&#8377; ' + res.cartTotal);
            $('.cart-count').text(res.cart_count);

            if (res.cart_count == 0) location.reload();
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('home.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kalpakon/public_html/resources/views/home/cart.blade.php ENDPATH**/ ?>