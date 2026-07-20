/* ====================================
   CHECKOUT PAGE VALIDATION
   ==================================== */

$(document).ready(function() {
    // ════════ FORM VALIDATION ════════
    $('#checkout-form').on('submit', function(e) {
        e.preventDefault();
        
        // Basic validation
        let isValid = true;
        const requiredFields = $(this).find('[required]');
        
        requiredFields.each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            alert('Please fill all required fields');
            return false;
        }
        
        // Submit form
        this.submit();
    });

    // ════════ REMOVE VALIDATION ERROR ON INPUT ════════
    $('.form-control-modern').on('input', function() {
        $(this).removeClass('is-invalid');
    });

    // ════════ PIN CODE VALIDATION ════════
    $('input[name="pincode"]').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
    });

    // ════════ PHONE NUMBER VALIDATION ════════
    $('input[name="phone"]').on('input', function() {
        this.value = this.value.replace(/[^0-9+\s]/g, '');
    });
});
