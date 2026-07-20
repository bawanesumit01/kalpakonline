/* ====================================
   SHOPPING CART PAGE JAVASCRIPT
   ==================================== */

(function() {
    // ════════ UPDATE QUANTITY ════════
    $(document).on('change', '.qty-input', function() {
        const cartId = $(this).data('cart-id');
        const qty = $(this).val();
        const row = $('#cart-row-' + cartId);

        $.post('/cart/update', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            cart_id: cartId,
            quantity: qty,
        }, function(res) {
            if (res.success) {
                row.find('.item-subtotal').html('&#8377; ' + res.subtotal);
                $('#cart-total').html('&#8377; ' + res.cartTotal);
                $('.cart-count').text(res.cart_count);
            }
        });
    });

    // ════════ REMOVE ITEM ════════
    $(document).on('click', '.btn-remove', function() {
        const cartId = $(this).data('cart-id');

        $.post('/cart/remove', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            cart_id: cartId,
        }, function(res) {
            if (res.success) {
                $('#cart-row-' + cartId).fadeOut(300, function() { 
                    $(this).remove(); 
                });
                $('#cart-total').html('&#8377; ' + res.cartTotal);
                $('.cart-count').text(res.cart_count);

                if (res.cart_count == 0) {
                    location.reload();
                }
            }
        });
    });
})();
