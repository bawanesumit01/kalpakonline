

<?php $__env->startSection('content'); ?>
    <section
        style="background-image: url('/assets/images/bg.jpg');background-repeat: no-repeat;background-size: cover;">
        <div class="container-lg pt-5">
            <div class="row pt-4">
                <div class="col-lg-6 pt-5 mt-5">

                    <div class="d-flex gap-3">
                        <a href="<?php echo e(route('shop')); ?>"
                            class="btn btn-primary text-uppercase fs-6 rounded-pill px-4 py-3 mt-3">Start Shopping</a>
                    </div>
                    <div class="row my-5">

                    </div>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-3 g-0 justify-content-center">
                <div class="col d-flex">
                    <div class="card border-0 bg-primary rounded-0 p-4 text-light flex-fill">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <svg width="60" height="60">
                                    <use xlink:href="#fresh"></use>
                                </svg>
                            </div>
                            <div class="col-md-9">
                                <div class="card-body p-0">
                                    <h5 class="text-light">Wide Product Range</h5>
                                    <p class="card-text">All your daily needs from edible oil to mobile accessories in one
                                        place.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="card border-0 bg-secondary rounded-0 p-4 text-light flex-fill">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <svg width="60" height="60">
                                    <use xlink:href="#organic"></use>
                                </svg>
                            </div>
                            <div class="col-md-9">
                                <div class="card-body p-0">
                                    <h5 class="text-light">Quality & Trusted Products</h5>
                                    <p class="card-text">We provide carefully selected, reliable and genuine products for
                                        every customer.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="card border-0 bg-danger rounded-0 p-4 text-light flex-fill">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <svg width="60" height="60">
                                    <use xlink:href="#delivery"></use>
                                </svg>
                            </div>
                            <div class="col-md-9">
                                <div class="card-body p-0">
                                    <h5 class="text-light">Easy & Convenient Shopping</h5>
                                    <p class="card-text">Simple ordering, affordable prices and quick service you can trust.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!--category-->
    <section class="py-5 overflow-hidden">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-12">

                    <div class="section-header d-flex flex-wrap justify-content-between mb-5">
                        <h2 class="section-title">Category</h2>

                        <div class="d-flex align-items-center">
                            <a href="#" class="btn btn-primary me-2">View All</a>
                            <div class="swiper-buttons">
                                <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
                                <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="category-carousel swiper">
                        <div class="swiper-wrapper">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="#" class="nav-link swiper-slide text-center">
                                    <img src="<?php echo e(!empty($category->cat_image) ? asset('/categoryImage/' . $category->cat_image) : asset('/categoryImage/default_category_img.png')); ?>"
                                        class="rounded-circle w-100" style="aspect-ratio: 3 / 3;"
                                        alt="<?php echo e($category->category_name ?? 'Category Thumbnail'); ?>">
                                    <h4 class="fs-6 mt-3 fw-normal category-title"><?php echo e($category->category_name ?? null); ?>

                                    </h4>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!--products -->
    <section class="pb-5">
        <div class="container-lg">

            <div class="row">
                <div class="col-md-12">

                    <div class="section-header d-flex flex-wrap justify-content-between my-4">

                        <h2 class="section-title">Best selling products</h2>

                        <div class="d-flex align-items-center">
                            <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary rounded-1">View All</a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row" id="start-shopping">
                <div class="col-md-12">

                    <div
                        class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">

                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col">
                                <div class="product-item">
                                    <figure>
                                        <a href="<?php echo e(route('product.details', $product->id)); ?>" title="Product Title">
                                            <img src="<?php echo e(asset('/' . $product->main_image)); ?>"
                                                alt="<?php echo e($product->product_name ?? null); ?>" class="tab-image">
                                        </a>
                                    </figure>
                                    <div class="d-flex flex-column text-center">
                                        <h3 class="fs-6 fw-normal"><?php echo e($product->product_name ?? null); ?></h3>
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <!--<del>$24.00</del>-->
                                            <span class="text-dark fw-semibold">&#8377;
                                                <?php echo e($product->final_price ?? null); ?></span>
                                        </div>
                                        <div class="button-area p-3 pt-0">
                                            <div class="row g-1 mt-2">
                                                <div class="col-3">
                                                    <input type="number" name="quantity"
                                                        class="form-control border-dark-subtle input-number quantity"
                                                        value="1" min="1">
                                                </div>
                                                <div class="col-9">
                                                    <a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"
                                                        data-product-id="<?php echo e($product->id); ?>">
                                                        <svg width="18" height="18">
                                                            <use xlink:href="#cart"></use>
                                                        </svg>
                                                        Add to Cart
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </div>
                    <!-- / product-grid -->


                </div>
            </div>
        </div>
    </section>


    <section class="py-5">
        <div class="container-lg">
            <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-5">
                <div class="col">
                    <div class="card mb-3 border border-dark-subtle p-3">
                        <div class="text-dark mb-3">
                            <svg width="32" height="32">
                                <use xlink:href="#package"></use>
                            </svg>
                        </div>
                        <div class="card-body p-0">
                            <h5>Free delivery</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-3 border border-dark-subtle p-3">
                        <div class="text-dark mb-3">
                            <svg width="32" height="32">
                                <use xlink:href="#secure"></use>
                            </svg>
                        </div>
                        <div class="card-body p-0">
                            <h5>100% secure payment</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-3 border border-dark-subtle p-3">
                        <div class="text-dark mb-3">
                            <svg width="32" height="32">
                                <use xlink:href="#quality"></use>
                            </svg>
                        </div>
                        <div class="card-body p-0">
                            <h5>Quality guarantee</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-3 border border-dark-subtle p-3">
                        <div class="text-dark mb-3">
                            <svg width="32" height="32">
                                <use xlink:href="#savings"></use>
                            </svg>
                        </div>
                        <div class="card-body p-0">
                            <h5>guaranteed savings</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card mb-3 border border-dark-subtle p-3">
                        <div class="text-dark mb-3">
                            <svg width="32" height="32">
                                <use xlink:href="#offers"></use>
                            </svg>
                        </div>
                        <div class="card-body p-0">
                            <h5>Daily offers</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipi elit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php $__env->startPush('scripts'); ?>
        <script>
            $(document).ready(function() {
                // =====================
                // ADD TO CART
                // =====================
                $(document).on('click', '.btn-cart', function(e) {
                    e.preventDefault();

                    const btn = $(this);
                    const productId = btn.attr('data-product-id');
                    const quantity = btn.closest('.button-area').find('.quantity').val() || 1;

                    // DEBUG — check these values in browser console
                    console.log('Product ID:', productId);
                    console.log('Quantity:', quantity);
                    console.log('CSRF Token:', $('meta[name="csrf-token"]').attr('content'));

                    if (!productId) {
                        alert('Product ID missing on button! Add data-product-id attribute.');
                        return;
                    }

                    btn.prop('disabled', true).text('Adding...');

                    $.ajax({
                        url: "<?php echo e(route('cart.add')); ?>",
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            product_id: productId,
                            quantity: quantity,
                        },
                        success: function(res) {
                            if (res.success) {
                                $('.cart-count').text(res.cart_count);

                                // ✅ First render cart, then open offcanvas
                                renderOffcanvasCart();
                                showToast(res.message, 'success');

                                setTimeout(function() {
                                    const offcanvasEl = document.getElementById(
                                        'offcanvasCart');
                                    if (offcanvasEl) {
                                        new bootstrap.Offcanvas(offcanvasEl).show();
                                    }
                                }, 300); // small delay to let render complete
                            }
                        },
                        error: function(xhr) {
                            console.error('AJAX Error:', xhr.status, xhr.responseText);

                            if (xhr.status === 419) {
                                alert(
                                    'CSRF token mismatch. Make sure meta csrf tag is in your <head>.');
                            } else if (xhr.status === 404) {
                                alert('Route not found. Check route name cart.add exists.');
                            } else if (xhr.status === 500) {
                                alert('Server error. Check Laravel logs: storage/logs/laravel.log');
                            } else {
                                alert('Error ' + xhr.status + ': ' + xhr.responseText);
                            }
                        },
                        complete: function() {
                            btn.prop('disabled', false).html(
                                '<svg width="18" height="18"><use xlink:href="#cart"></use></svg> Add to Cart'
                            );
                        }
                    });
                });
                // =====================
                // QUANTITY INCREASE
                // =====================
                $(document).on('click', '.offcanvas-qty-increase', function() {
                    const cartId = $(this).data('cart-id');
                    const qtyEl = $(`.offcanvas-qty[data-cart-id="${cartId}"]`);
                    const newQty = parseInt(qtyEl.text()) + 1;
                    updateOffcanvasQty(cartId, newQty);
                });

                // =====================
                // QUANTITY DECREASE
                // =====================
                $(document).on('click', '.offcanvas-qty-decrease', function() {
                    const cartId = $(this).data('cart-id');
                    const qtyEl = $(`.offcanvas-qty[data-cart-id="${cartId}"]`);
                    const newQty = parseInt(qtyEl.text()) - 1;

                    if (newQty < 1) {
                        removeOffcanvasItem(cartId);
                    } else {
                        updateOffcanvasQty(cartId, newQty);
                    }
                });

                // =====================
                // REMOVE ITEM
                // =====================
                $(document).on('click', '.offcanvas-remove', function() {
                    const cartId = $(this).data('cart-id');
                    removeOffcanvasItem(cartId);
                });

                // =====================
                // HELPERS
                // =====================
                function updateOffcanvasQty(cartId, quantity) {
                    $.post("<?php echo e(route('cart.update')); ?>", {
                        _token: "<?php echo e(csrf_token()); ?>",
                        cart_id: cartId,
                        quantity: quantity,
                    }, function(res) {
                        if (res.success) {
                            $(`.offcanvas-qty[data-cart-id="${cartId}"]`).text(quantity);
                            $(`.offcanvas-subtotal[data-cart-id="${cartId}"]`).html('&#8377; ' + res.subtotal);
                            $('.offcanvas-total').html('&#8377; ' + res.cartTotal);
                            updateCartBadge();
                        }
                    });
                }

                function removeOffcanvasItem(cartId) {
                    $.post("<?php echo e(route('cart.remove')); ?>", {
                        _token: "<?php echo e(csrf_token()); ?>",
                        cart_id: cartId,
                    }, function(res) {
                        if (res.success) {
                            $(`#offcanvas-item-${cartId}`).fadeOut(300, function() {
                                $(this).remove();
                                $('.cart-count').text(res.cart_count);
                                $('.offcanvas-total').html('&#8377; ' + res.cartTotal);

                                if (res.cart_count == 0) {
                                    $('#offcanvas-cart-items').html(`
                        <div class="text-center py-5" id="empty-cart-msg">
                            <p class="mt-3 text-muted">Your cart is empty</p>
                            <a href="/" class="btn btn-primary btn-sm mt-2" data-bs-dismiss="offcanvas">Start Shopping</a>
                        </div>
                    `);
                                    $('#offcanvas-cart-footer').hide();
                                }
                            });
                        }
                    });
                }

                function renderOffcanvasCart() {
                    $.ajax({
                        url: "<?php echo e(route('cart.items')); ?>",
                        method: 'GET',
                        success: function(res) {
                            if (res.success) {
                                $('#offcanvas-cart-items').html(res.html);
                                $('.offcanvas-total').html('&#8377; ' + res.cartTotal);
                                $('.cart-count').text(res.cart_count);

                                if (res.cart_count > 0) {
                                    $('#offcanvas-cart-footer').show();
                                } else {
                                    $('#offcanvas-cart-footer').hide();
                                }
                            }
                        },
                        error: function(xhr) {
                            console.error('renderOffcanvasCart error:', xhr.status, xhr.responseText);
                        }
                    });
                }

                function updateCartBadge() {
                    $.get("<?php echo e(route('cart.items')); ?>", function(res) {
                        $('.cart-count').text(res.cart_count);
                    });
                }

                function showToast(message, type = 'success') {
                    const toast = `
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:9999">
            <div class="toast show align-items-center text-white bg-${type} border-0">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>`;
                    $('body').append(toast);
                    setTimeout(() => $('.toast-container').last().remove(), 3000);
                }

            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('home.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kalpakon/public_html/resources/views/home/index.blade.php ENDPATH**/ ?>