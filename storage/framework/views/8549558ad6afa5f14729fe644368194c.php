

<?php $__env->startSection('content'); ?>
<style>
.main-product-img {
    max-height: 450px;
    object-fit: contain;
}
.thumbnails-container {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding: 10px 40px;
}
.thumbnails-container::-webkit-scrollbar { display: none; }
.thumb {
    min-width: 80px;
    height: 80px;
    border: 2px solid #eee;
    padding: 5px;
    cursor: pointer;
    background: #fff;
    border-radius: 8px;
    transition: border-color 0.2s;
}
.thumb img { width: 100%; height: 100%; object-fit: contain; }
.active-thumb { border-color: #0d6efd; }
.slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: #fff;
    border: 1px solid #ddd;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    cursor: pointer;
    z-index: 10;
}
.left-arrow { left: 0; }
.right-arrow { right: 0; }
.qty-btn {
    width: 36px;
    height: 36px;
    border: 1px solid #dee2e6;
    background: #f8f9fa;
    border-radius: 6px;
    font-size: 18px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}
.qty-btn:hover { background: #e9ecef; }
.qty-input {
    width: 60px;
    text-align: center;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 600;
    padding: 4px;
}
.product-badge {
    font-size: 13px;
    padding: 5px 12px;
    border-radius: 20px;
}
.divider { border-top: 1px solid #f0f0f0; margin: 16px 0; }
</style>

<section class="py-5">
  <div class="container-lg">

    <!---->
    <!--<nav aria-label="breadcrumb" class="mb-4">-->
    <!--    <ol class="breadcrumb">-->
    <!--        <li class="breadcrumb-item"><a href="<?php echo e(route('home.index')); ?>" class="text-decoration-none">Home</a></li>-->
    <!--        <li class="breadcrumb-item"><a href="#" class="text-decoration-none"><?php echo e($product->category->category_name ?? ''); ?></a></li>-->
    <!--        <li class="breadcrumb-item active"><?php echo e($product->product_name); ?></li>-->
    <!--    </ol>-->
    <!--</nav>-->

    <div class="row g-5">

      
      <div class="col-lg-5  d-flex justify-content-center">
        <div class="product-gallery-wrapper">

            
            <div class="main-image-box text-center mb-4 border rounded-3 p-3 bg-white">
                <img id="mainProductImage"
                     src="<?php echo e(asset('/' . $product->main_image)); ?>"
                     class="img-fluid main-product-img"
                     alt="<?php echo e($product->product_name); ?>">
            </div>

            
            <div class="thumbnail-slider position-relative">
                <button class="slider-arrow left-arrow" onclick="scrollThumbnails(-1)">&#10094;</button>
                <div class="thumbnails-container" id="thumbnailContainer">
                    <div class="thumb active-thumb">
                        <img src="<?php echo e(asset('/' . $product->main_image)); ?>" onclick="changeMainImage(this)">
                    </div>
                    <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="thumb">
                        <img src="<?php echo e(asset('/' . $image->image_path)); ?>" onclick="changeMainImage(this)">
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <button class="slider-arrow right-arrow" onclick="scrollThumbnails(1)">&#10095;</button>
            </div>

        </div>
      </div>

      
      <div class="col-lg-7 d-flex justify-content-center">
       <div>
        
        <span class="badge bg-primary-subtle text-primary product-badge mb-2">
            <?php echo e($product->category->category_name ?? ''); ?>

        </span>

        
        <h3 class="fw-bold mb-3"><?php echo e($product->product_name); ?></h3>

        
        <div class="d-flex align-items-center gap-3 mb-3">
            <span class="fs-2 fw-bold text-dark">₹<?php echo e($product->final_price ?? '00'); ?></span>
            <?php if($product->original_price && $product->original_price > $product->final_price): ?>
                <del class="text-muted fs-5">₹<?php echo e($product->original_price); ?></del>
            <?php endif; ?>
            <?php if($product->discount_percent): ?>
                <span class="badge bg-danger product-badge"><?php echo e($product->discount_percent); ?>% OFF</span>
            <?php endif; ?>
        </div>

        <div class="divider"></div>

        
        <div class="mb-3 d-flex align-items-center gap-2">
            <span class="fw-semibold">Availability:</span>
            <?php if($product->stock_status == 'in_stock'): ?>
                <span class="badge bg-success-subtle text-success product-badge">
                    ✓ In Stock
                </span>
            <?php elseif($product->stock_status == 'pre_order'): ?>
                <span class="badge bg-warning-subtle text-warning product-badge">
                    ⏳ Pre Order
                </span>
            <?php else: ?>
                <span class="badge bg-danger-subtle text-danger product-badge">
                    ✕ Out of Stock
                </span>
            <?php endif; ?>
        </div>

        
        <div class="mb-3">
            <span class="text-muted">SKU: <strong><?php echo e($product->product_sku); ?></strong></span>
        </div>

        <div class="divider"></div>

        
        <?php if($product->short_description): ?>
        <p class="text-muted mb-4"><?php echo e($product->short_description); ?></p>
        <?php endif; ?>

        
        <?php if($product->stock_status != 'out_of_stock'): ?>
        <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">

            
            <div class="d-flex align-items-center gap-2">
                <button class="qty-btn" id="qty-decrease">−</button>
                <input type="number" id="detail-quantity" class="qty-input" value="1" min="1" max="<?php echo e($product->stock_quantity); ?>">
                <button class="qty-btn" id="qty-increase">+</button>
            </div>

            
            <button class="btn btn-primary px-5 py-2 rounded-1 btn-cart-detail"
                    data-product-id="<?php echo e($product->id); ?>">
                <svg width="18" height="18" class="me-2"><use xlink:href="#cart"></use></svg>
                Add to Cart
            </button>

            
            <button class="btn btn-outline-secondary px-3 py-2 rounded-1">
                <svg width="18" height="18"><use xlink:href="#heart"></use></svg>
            </button>

        </div>
        <?php else: ?>
        <button class="btn btn-secondary px-5 py-2 rounded-1 mb-4" disabled>
            Out of Stock
        </button>
        <?php endif; ?>

        <div class="divider"></div>

        
        <div class="d-flex flex-column gap-2 text-muted small">
            <span><strong>Category:</strong> <?php echo e($product->category->category_name ?? '-'); ?></span>
            <span><strong>Vendor:</strong> <?php echo e($product->vendor->vendor_name ?? '-'); ?></span>
            <span><strong>Stock:</strong> <?php echo e($product->stock_quantity); ?> units available</span>
        </div>

      </div>
      </div>
      
    </div>
  </div>
</section>


<section class="pb-5">
  <div class="container-lg">
    <ul class="nav nav-tabs mb-4" role="tablist">
      <li class="nav-item">
        <a class="nav-link active fw-semibold" data-bs-toggle="tab" href="#description">Description</a>
      </li>
      <li class="nav-item">
        <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#details">Details</a>
      </li>
    </ul>
    <div class="tab-content">
      <div id="description" class="tab-pane fade show active">
        <p class="text-muted"><?php echo nl2br(e($product->description)); ?></p>
      </div>
      <div id="details" class="tab-pane fade">
        <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex gap-3">
            <strong style="width:140px">SKU</strong>
            <span><?php echo e($product->product_sku); ?></span>
          </li>
          <li class="list-group-item d-flex gap-3">
            <strong style="width:140px">Category</strong>
            <span><?php echo e($product->category->category_name ?? '-'); ?></span>
          </li>
          <li class="list-group-item d-flex gap-3">
            <strong style="width:140px">Vendor</strong>
            <span><?php echo e($product->vendor->vendor_name ?? '-'); ?></span>
          </li>
          <li class="list-group-item d-flex gap-3">
            <strong style="width:140px">Stock Quantity</strong>
            <span><?php echo e($product->stock_quantity); ?></span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function () {

    // =====================
    // QUANTITY CONTROLS
    // =====================
    $('#qty-increase').on('click', function () {
        const input   = $('#detail-quantity');
        const max     = parseInt(input.attr('max')) || 99;
        const current = parseInt(input.val());
        if (current < max) input.val(current + 1);
    });

    $('#qty-decrease').on('click', function () {
        const input   = $('#detail-quantity');
        const current = parseInt(input.val());
        if (current > 1) input.val(current - 1);
    });

    // =====================
    // ADD TO CART
    // =====================
    $(document).on('click', '.btn-cart-detail', function () {
        const btn       = $(this);
        const productId = btn.attr('data-product-id');
        const quantity  = $('#detail-quantity').val() || 1;

        btn.prop('disabled', true).html('Adding...');

        $.ajax({
            url: "<?php echo e(route('cart.add')); ?>",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                product_id: productId,
                quantity:   quantity,
            },
            success: function (res) {
                if (res.success) {
                    $('.cart-count').text(res.cart_count);
                    showToast(res.message, 'success');
                    renderOffcanvasCart();

                    setTimeout(function () {
                        const offcanvasEl = document.getElementById('offcanvasCart');
                        if (offcanvasEl) {
                            new bootstrap.Offcanvas(offcanvasEl).show();
                        }
                    }, 300);
                }
            },
            error: function (xhr) {
                console.error('Error:', xhr.status, xhr.responseText);
                showToast('Something went wrong!', 'danger');
            },
            complete: function () {
                btn.prop('disabled', false).html(
                    '<svg width="18" height="18" class="me-2"><use xlink:href="#cart"></use></svg> Add to Cart'
                );
            }
        });
    });

    // =====================
    // THUMBNAIL IMAGE
    // =====================
    window.changeMainImage = function(imgElement) {
        document.getElementById('mainProductImage').src = imgElement.src;
        document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active-thumb'));
        imgElement.closest('.thumb').classList.add('active-thumb');
    }

    window.scrollThumbnails = function(direction) {
        const container = document.getElementById('thumbnailContainer');
        container.scrollLeft += direction * 200;
    }

    // =====================
    // OFFCANVAS HELPERS
    // =====================
    function renderOffcanvasCart() {
        $.ajax({
            url: "<?php echo e(route('cart.items')); ?>",
            method: 'GET',
            success: function (res) {
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
            }
        });
    }

    function showToast(message, type = 'success') {
        const toast = `
            <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:9999">
                <div class="toast show align-items-center text-white bg-${type} border-0">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                data-bs-dismiss="toast"></button>
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
<?php echo $__env->make('home.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kalpakon/public_html/resources/views/home/product/product-details.blade.php ENDPATH**/ ?>