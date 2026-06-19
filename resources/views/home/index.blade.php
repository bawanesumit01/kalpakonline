@extends('home.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section-modern">
        <div class="hero-background">
            <div class="hero-shape hero-shape-1"></div>
            <div class="hero-shape hero-shape-2"></div>
            <div class="hero-shape hero-shape-3"></div>
        </div>
        <div class="container-lg">
            <div class="row align-items-center" style="min-height: 60vh;">
                <div class="col-lg-6 col-md-8">
                    <div class="hero-content-modern" data-aos="fade-up">
                        <span class="hero-badge-modern">
                            <i class="bi bi-stars"></i> Welcome to Kalpak Online
                        </span>
                        <h1 class="hero-title-modern">
                            Your Daily Essentials,<br>
                            <span class="gradient-text">Delivered Fresh</span>
                        </h1>
                        <p class="hero-description-modern">
                            Experience hassle-free shopping with a wide range of quality products from groceries to mobile
                            accessories, all at your fingertips.
                        </p>
                        <div class="hero-buttons-modern">
                            <a href="{{ route('shop') }}" class="btn-primary-modern">
                                Start Shopping
                                <i class="bi bi-arrow-right"></i>
                            </a>
                            <a href="#products" class="btn-outline-modern">
                                <i class="bi bi-grid-3x3-gap"></i>
                                Explore Products
                            </a>
                        </div>
                        <div class="hero-stats-modern">
                            <div class="stat-card-modern">
                                <h3 class="stat-number">1000+</h3>
                                <p class="stat-label">Products</p>
                            </div>
                            <div class="stat-divider"></div>
                            <div class="stat-card-modern">
                                <h3 class="stat-number">5000+</h3>
                                <p class="stat-label">Happy Customers</p>
                            </div>
                            <div class="stat-divider"></div>
                            <div class="stat-card-modern">
                                <h3 class="stat-number">24/7</h3>
                                <p class="stat-label">Support</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="hero-image-modern" data-aos="fade-left" data-aos-delay="200">
                        <div class="floating-card floating-card-1">
                            <i class="bi bi-basket"></i>
                            <span>Fresh Products</span>
                        </div>
                        <div class="floating-card floating-card-2">
                            <i class="bi bi-truck"></i>
                            <span>Fast Delivery</span>
                        </div>
                        <div class="floating-card floating-card-3">
                            <i class="bi bi-shield-check"></i>
                            <span>Secure Payment</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section-modern">
        <div class="container-lg">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card-modern">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon-modern feature-icon-1">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                        <h3 class="feature-title-modern">Wide Product Range</h3>
                        <p class="feature-description-modern">All your daily needs from edible oil to mobile accessories in
                            one place.</p>
                        <div class="feature-number">01</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card-modern">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon-modern feature-icon-2">
                                <i class="bi bi-shield-check"></i>
                            </div>
                        </div>
                        <h3 class="feature-title-modern">Quality & Trusted</h3>
                        <p class="feature-description-modern">Carefully selected, reliable and genuine products for every
                            customer.</p>
                        <div class="feature-number">02</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card-modern">
                        <div class="feature-icon-wrapper">
                            <div class="feature-icon-modern feature-icon-3">
                                <i class="bi bi-lightning-charge"></i>
                            </div>
                        </div>
                        <h3 class="feature-title-modern">Fast Delivery</h3>
                        <p class="feature-description-modern">Quick and reliable delivery service to your doorstep with
                            care.</p>
                        <div class="feature-number">03</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Section -->
    <section class="category-section-modern">
        <div class="container-lg">
            <div class="section-header-new" data-aos="fade-up">
                <div class="section-subtitle-new">Browse by</div>
                <h2 class="section-title-new">Popular Categories</h2>
                <p class="section-description-new">Discover our wide range of product categories</p>
            </div>

            <div class="category-grid-modern" data-aos="fade-up" data-aos-delay="100">
                @foreach ($categories as $category)
                    <a href="#" class="category-card-modern">
                        <div class="category-image-modern">
                            <img src="{{ !empty($category->cat_image) ? asset('/categoryImage/' . $category->cat_image) : asset('/categoryImage/default_category_img.png') }}"
                                alt="{{ $category->category_name ?? 'Category' }}">
                            <div class="category-overlay-modern"></div>
                        </div>
                        <div class="category-content-modern">
                            <h4 class="category-name-modern">{{ $category->category_name ?? 'Category' }}</h4>
                            <span class="category-link-modern">
                                Explore Now
                                <i class="bi bi-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section-modern" id="products">
        <div class="container-lg">
            <div class="section-header-new" data-aos="fade-up">
                <div class="section-subtitle-new">Shop Now</div>
                <h2 class="section-title-new">Best Selling Products</h2>
                <p class="section-description-new">Top-rated products loved by our customers</p>
            </div>

            <div class="product-grid-modern" data-aos="fade-up" data-aos-delay="100">
                @foreach ($products as $product)
                    <div class="product-card-modern">
                        <div class="product-image-wrapper-modern">
                            <a href="{{ route('product.details', $product->id) }}">
                                <img src="{{ asset('/' . $product->main_image) }}"
                                    alt="{{ $product->product_name ?? null }}" class="product-image-modern">
                            </a>
                            <div class="product-badge-modern">New</div>
                        </div>
                        <div class="product-content-modern">
                            <h3 class="product-title-modern">
                                <a href="{{ route('product.details', $product->id) }}">
                                    {{ $product->product_name ?? null }}
                                </a>
                            </h3>
                            <div class="product-price-modern">
                                <span class="price-current">&#8377; {{ $product->final_price ?? null }}</span>
                            </div>
                            <div class="product-actions-modern">
                                <div class="quantity-wrapper-modern">
                                    <input type="number" class="quantity-input-modern quantity" value="1"
                                        min="1">
                                </div>
                                <button class="btn-add-cart-modern btn-cart" data-product-id="{{ $product->id }}">
                                    <i class="bi bi-cart-plus"></i>
                                    <span>Add to Cart</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ route('shop') }}" class="btn-view-all-modern">
                    View All Products
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>


    <!-- Benefits Section -->
    <section class="benefits-section-modern">
        <div class="container-lg">
            <div class="benefits-grid-modern">
                <div class="benefit-card-modern" data-aos="fade-up" data-aos-delay="100">
                    <div class="benefit-icon-modern benefit-icon-1">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="benefit-content-modern">
                        <h5 class="benefit-title-modern">Free Delivery</h5>
                        <p class="benefit-text-modern">On orders above ₹500</p>
                    </div>
                </div>
                <div class="benefit-card-modern" data-aos="fade-up" data-aos-delay="200">
                    <div class="benefit-icon-modern benefit-icon-2">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="benefit-content-modern">
                        <h5 class="benefit-title-modern">100% Secure Payment</h5>
                        <p class="benefit-text-modern">Your money is safe with us</p>
                    </div>
                </div>
                <div class="benefit-card-modern" data-aos="fade-up" data-aos-delay="300">
                    <div class="benefit-icon-modern benefit-icon-3">
                        <i class="bi bi-award"></i>
                    </div>
                    <div class="benefit-content-modern">
                        <h5 class="benefit-title-modern">Quality Guarantee</h5>
                        <p class="benefit-text-modern">Premium quality products</p>
                    </div>
                </div>
                <div class="benefit-card-modern" data-aos="fade-up" data-aos-delay="400">
                    <div class="benefit-icon-modern benefit-icon-4">
                        <i class="bi bi-piggy-bank"></i>
                    </div>
                    <div class="benefit-content-modern">
                        <h5 class="benefit-title-modern">Guaranteed Savings</h5>
                        <p class="benefit-text-modern">Best prices guaranteed</p>
                    </div>
                </div>
                <div class="benefit-card-modern" data-aos="fade-up" data-aos-delay="500">
                    <div class="benefit-icon-modern benefit-icon-5">
                        <i class="bi bi-tag"></i>
                    </div>
                    <div class="benefit-content-modern">
                        <h5 class="benefit-title-modern">Daily Offers</h5>
                        <p class="benefit-text-modern">New deals every day</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
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
                        url: "{{ route('cart.add') }}",
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
                                    'CSRF token mismatch. Make sure meta csrf tag is in your <head>.'
                                    );
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
                    $.post("{{ route('cart.update') }}", {
                        _token: "{{ csrf_token() }}",
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
                    $.post("{{ route('cart.remove') }}", {
                        _token: "{{ csrf_token() }}",
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
                        url: "{{ route('cart.items') }}",
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
                    $.get("{{ route('cart.items') }}", function(res) {
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
    @endpush
@endsection
