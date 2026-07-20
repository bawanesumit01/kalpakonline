/* ====================================
   PRODUCT DETAILS PAGE JAVASCRIPT
   ==================================== */

(function() {
    // ════════ QUANTITY CONTROLS ════════
    const qtyIncreaseBtn = document.getElementById('qty-increase');
    const qtyDecreaseBtn = document.getElementById('qty-decrease');
    const qtyInput = document.getElementById('detail-quantity');

    if (qtyIncreaseBtn) {
        qtyIncreaseBtn.addEventListener('click', function() {
            const max = parseInt(qtyInput.getAttribute('max')) || 99;
            const current = parseInt(qtyInput.value);
            if (current < max) qtyInput.value = current + 1;
        });
    }

    if (qtyDecreaseBtn) {
        qtyDecreaseBtn.addEventListener('click', function() {
            const current = parseInt(qtyInput.value);
            if (current > 1) qtyInput.value = current - 1;
        });
    }

    // ════════ THUMBNAIL GALLERY ════════
    const thumbs = document.querySelectorAll('.thumb');
    const mainImage = document.querySelector('.product-main-image img');
    const leftArrow = document.querySelector('.slider-arrow.left');
    const rightArrow = document.querySelector('.slider-arrow.right');
    const thumbnailsContainer = document.querySelector('.thumbnails-container');

    thumbs.forEach(thumb => {
        thumb.addEventListener('click', function() {
            thumbs.forEach(t => t.classList.remove('active-thumb'));
            this.classList.add('active-thumb');
            if (mainImage) {
                mainImage.src = this.querySelector('img').src;
            }
        });
    });

    if (leftArrow && thumbnailsContainer) {
        leftArrow.addEventListener('click', function() {
            thumbnailsContainer.scrollBy({ left: -100, behavior: 'smooth' });
        });
    }

    if (rightArrow && thumbnailsContainer) {
        rightArrow.addEventListener('click', function() {
            thumbnailsContainer.scrollBy({ left: 100, behavior: 'smooth' });
        });
    }

    // ════════ ADD TO CART ════════
    $(document).on('click', '.btn-cart-detail', function() {
        const btn = $(this);
        const productId = btn.attr('data-product-id');
        const quantity = $('#detail-quantity').val() || 1;

        if (!productId) {
            alert('Product ID missing!');
            return;
        }

        btn.prop('disabled', true).html('Adding...');

        $.ajax({
            url: '/cart/add',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                product_id: productId,
                quantity: quantity,
            },
            success: function(res) {
                if (res.success) {
                    $('.cart-count').text(res.cart_count);
                    showToast(res.message, 'success');
                    renderOffcanvasCart();

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
                showToast('Error adding to cart. Please try again.', 'danger');
            },
            complete: function() {
                btn.prop('disabled', false).html(
                    '<i class="bi bi-cart-plus"></i> Add to Cart'
                );
            }
        });
    });

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
                    }
                }
            }
        });
    }

    // Initialize first thumbnail as active
    if (thumbs.length > 0) {
        thumbs[0].classList.add('active-thumb');
    }
})();
