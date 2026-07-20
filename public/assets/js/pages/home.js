/* ====================================
   HOME PAGE JAVASCRIPT
   ==================================== */

// ════════ HERO SLIDER AUTO-ROTATION ════════
(function() {
    let currentSlide = 0;
    const totalSlides = document.querySelectorAll('.hero-slide').length;
    const sliderInterval = 5000; // Change slide every 5 seconds

    function showSlide(index) {
        document.querySelectorAll('.hero-slide').forEach(slide => {
            slide.classList.remove('active');
            slide.style.display = 'none';
        });
        const activeSlide = document.querySelectorAll('.hero-slide')[index];
        activeSlide.classList.add('active');
        activeSlide.style.display = 'block';
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    if (totalSlides > 1) {
        setInterval(nextSlide, sliderInterval);
    }

    // Initialize first slide as active
    showSlide(0);
})();

// ════════ ADD TO CART FUNCTIONALITY ════════
(function() {
    $(document).on('click', '.btn-cart', function(e) {
        e.preventDefault();

        const btn = $(this);
        const productId = btn.attr('data-product-id');
        const quantity = btn.closest('.product-actions-modern').find('.quantity').val() || 1;

        if (!productId) {
            alert('Product ID missing on button!');
            return;
        }

        btn.prop('disabled', true).text('Adding...');

        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                product_id: productId,
                quantity: quantity,
            },
            success: function(res) {
                if (res.success) {
                    $('.cart-count').text(res.cart_count);
                    renderOffcanvasCart();
                    showToast(res.message, 'success');

                    setTimeout(function() {
                        const offcanvasEl = document.getElementById('offcanvasCart');
                        if (offcanvasEl) {
                            new bootstrap.Offcanvas(offcanvasEl).show();
                        }
                    }, 300);
                }
            },
            error: function(xhr) {
                console.error('AJAX Error:', xhr.status, xhr.responseText);
                if (xhr.status === 419) {
                    alert('CSRF token mismatch.');
                } else if (xhr.status === 404) {
                    alert('Route not found.');
                } else if (xhr.status === 500) {
                    alert('Server error. Check logs.');
                } else {
                    alert('Error ' + xhr.status);
                }
            },
            complete: function() {
                btn.prop('disabled', false).html(
                    '<i class="bi bi-cart-plus"></i> <span>Add to Cart</span>'
                );
            }
        });
    });

    // ════════ QUANTITY INCREASE ════════
    $(document).on('click', '.offcanvas-qty-increase', function() {
        const cartId = $(this).data('cart-id');
        const qtyEl = $(`.offcanvas-qty[data-cart-id="${cartId}"]`);
        const newQty = parseInt(qtyEl.text()) + 1;
        updateOffcanvasQty(cartId, newQty);
    });

    // ════════ QUANTITY DECREASE ════════
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

    // ════════ REMOVE ITEM ════════
    $(document).on('click', '.offcanvas-remove', function() {
        const cartId = $(this).data('cart-id');
        removeOffcanvasItem(cartId);
    });

    // ════════ HELPERS ════════
    function updateOffcanvasQty(cartId, quantity) {
        $.post('/cart/update', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            cart_id: cartId,
            quantity: quantity,
        }, function(res) {
            if (res.success) {
                $(`.offcanvas-qty[data-cart-id="${cartId}"]`).text(quantity);
                $(`.offcanvas-subtotal[data-cart-id="${cartId}"]`).html('&#8377; ' + res.subtotal);
                $('.offcanvas-total').html('&#8377; ' + res.cartTotal);
            }
        });
    }

    function removeOffcanvasItem(cartId) {
        $.post('/cart/remove', {
            _token: $('meta[name="csrf-token"]').attr('content'),
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
            url: '/cart/items',
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
})();
