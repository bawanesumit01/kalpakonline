/* ====================================
   FAQ PAGE SEARCH FUNCTIONALITY
   ==================================== */

(function() {
    const faqSearch = document.getElementById('faqSearch');
    
    if (!faqSearch) return;

    faqSearch.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const faqItems = document.querySelectorAll('.accordion-item');
        
        faqItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(searchTerm) ? 'block' : 'none';
        });
    });
})();
