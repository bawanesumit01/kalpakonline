/* ====================================
   AOS (ANIMATE ON SCROLL) INITIALIZATION
   ==================================== */

(function() {
    if (typeof AOS === 'undefined') {
        console.warn('AOS library not loaded');
        return;
    }

    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        offset: 100
    });
})();
