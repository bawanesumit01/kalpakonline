/* ====================================
   ORDER SUCCESS PAGE JAVASCRIPT
   ==================================== */

(function() {
    // ════════ COPY ORDER NUMBER ════════
    window.copyOrderNumber = function() {
        const orderNumberEl = document.querySelector('.order-number-display');
        if (!orderNumberEl) return;

        const orderNumber = orderNumberEl.textContent.trim().split('\n')[0];
        navigator.clipboard.writeText(orderNumber).then(() => {
            alert('Order number copied to clipboard!');
        }).catch(err => {
            console.error('Failed to copy:', err);
        });
    };

    // ════════ PRINT ORDER ════════
    const printBtn = document.querySelector('.btn-print-order');
    if (printBtn) {
        printBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.print();
        });
    }
})();
