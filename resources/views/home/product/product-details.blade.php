@extends('home.app')

@section('content')
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

    <!--{{-- Breadcrumb --}}-->
    <!--<nav aria-label="breadcrumb" class="mb-4">-->
    <!--    <ol class="breadcrumb">-->
    <!--        <li class="breadcrumb-item"><a href="{{ route('home.index') }}" class="text-decoration-none">Home</a></li>-->
    <!--        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">{{ $product->category->category_name ?? '' }}</a></li>-->
    <!--        <li class="breadcrumb-item active">{{ $product->product_name }}</li>-->
    <!--    </ol>-->
    <!--</nav>-->

    <div class="row g-5">

      {{-- Left: Images --}}
      <div class="col-lg-5  d-flex justify-content-center">
        <div class="product-gallery-wrapper">

            {{-- Main Image --}}
            <div class="main-image-box text-center mb-4 border rounded-3 p-3 bg-white">
                <img id="mainProductImage"
                     src="{{ asset('/' . $product->main_image) }}"
                     class="img-fluid main-product-img"
                     alt="{{ $product->product_name }}">
            </div>

            {{-- Thumbnails --}}
            <div class="thumbnail-slider position-relative">
                <button class="slider-arrow left-arrow" onclick="scrollThumbnails(-1)">&#10094;</button>
                <div class="thumbnails-container" id="thumbnailContainer">
                    <div class="thumb active-thumb">
                        <img src="{{ asset('/' . $product->main_image) }}" onclick="changeMainImage(this)">
                    </div>
                    @foreach($product->images as $image)
                    <div class="thumb">
                        <img src="{{ asset('/' . $image->image_path) }}" onclick="changeMainImage(this)">
                    </div>
                    @endforeach
                </div>
                <button class="slider-arrow right-arrow" onclick="scrollThumbnails(1)">&#10095;</button>
            </div>

        </div>
      </div>

      {{-- Right: Product Info --}}
      <div class="col-lg-7 d-flex justify-content-center">
       <div>
        {{-- Category Tag --}}
        <span class="badge bg-primary-subtle text-primary product-badge mb-2">
            {{ $product->category->category_name ?? '' }}
        </span>

        {{-- Product Name --}}
        <h3 class="fw-bold mb-3">{{ $product->product_name }}</h3>

        {{-- Price --}}
        <div class="d-flex align-items-center gap-3 mb-3">
            <span class="fs-2 fw-bold text-dark">₹{{ $product->final_price ?? '00' }}</span>
            @if($product->original_price && $product->original_price > $product->final_price)
                <del class="text-muted fs-5">₹{{ $product->original_price }}</del>
            @endif
            @if($product->discount_percent)
                <span class="badge bg-danger product-badge">{{ $product->discount_percent }}% OFF</span>
            @endif
        </div>

        <div class="divider"></div>

        {{-- Stock Status --}}
        <div class="mb-3 d-flex align-items-center gap-2">
            <span class="fw-semibold">Availability:</span>
            @if($product->stock_status == 'in_stock')
                <span class="badge bg-success-subtle text-success product-badge">
                    ✓ In Stock
                </span>
            @elseif($product->stock_status == 'pre_order')
                <span class="badge bg-warning-subtle text-warning product-badge">
                    ⏳ Pre Order
                </span>
            @else
                <span class="badge bg-danger-subtle text-danger product-badge">
                    ✕ Out of Stock
                </span>
            @endif
        </div>

        {{-- SKU --}}
        <div class="mb-3">
            <span class="text-muted">SKU: <strong>{{ $product->product_sku }}</strong></span>
        </div>

        <div class="divider"></div>

        {{-- Short Description --}}
        @if($product->short_description)
        <p class="text-muted mb-4">{{ $product->short_description }}</p>
        @endif

        {{-- Quantity + Cart --}}
        @if($product->stock_status != 'out_of_stock')
        <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">

            {{-- Quantity Control --}}
            <div class="d-flex align-items-center gap-2">
                <button class="qty-btn" id="qty-decrease">−</button>
                <input type="number" id="detail-quantity" class="qty-input" value="1" min="1" max="{{ $product->stock_quantity }}">
                <button class="qty-btn" id="qty-increase">+</button>
            </div>

            {{-- Add to Cart Button --}}
            <button class="btn btn-primary px-5 py-2 rounded-1 btn-cart-detail"
                    data-product-id="{{ $product->id }}">
                <svg width="18" height="18" class="me-2"><use xlink:href="#cart"></use></svg>
                Add to Cart
            </button>

            {{-- Wishlist --}}
            <button class="btn btn-outline-secondary px-3 py-2 rounded-1">
                <svg width="18" height="18"><use xlink:href="#heart"></use></svg>
            </button>

        </div>
        @else
        <button class="btn btn-secondary px-5 py-2 rounded-1 mb-4" disabled>
            Out of Stock
        </button>
        @endif

        <div class="divider"></div>

        {{-- Meta Info --}}
        <div class="d-flex flex-column gap-2 text-muted small">
            <span><strong>Category:</strong> {{ $product->category->category_name ?? '-' }}</span>
            <span><strong>Vendor:</strong> {{ $product->vendor->vendor_name ?? '-' }}</span>
            <span><strong>Stock:</strong> {{ $product->stock_quantity }} units available</span>
        </div>

      </div>
      </div>
      
    </div>
  </div>
</section>

{{-- Product Tabs --}}
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
        <p class="text-muted">{!! nl2br(e($product->description)) !!}</p>
      </div>
      <div id="details" class="tab-pane fade">
        <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex gap-3">
            <strong style="width:140px">SKU</strong>
            <span>{{ $product->product_sku }}</span>
          </li>
          <li class="list-group-item d-flex gap-3">
            <strong style="width:140px">Category</strong>
            <span>{{ $product->category->category_name ?? '-' }}</span>
          </li>
          <li class="list-group-item d-flex gap-3">
            <strong style="width:140px">Vendor</strong>
            <span>{{ $product->vendor->vendor_name ?? '-' }}</span>
          </li>
          <li class="list-group-item d-flex gap-3">
            <strong style="width:140px">Stock Quantity</strong>
            <span>{{ $product->stock_quantity }}</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

@push('scripts')
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
            url: "{{ route('cart.add') }}",
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
            url: "{{ route('cart.items') }}",
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
@endpush

@endsection