/* ====================================
   SHOP PAGE FILTERING & INTERACTION
   ==================================== */

(function() {
    const allProducts = window.productsData || [];
    const urlParams = new URLSearchParams(window.location.search);
    const categoryParam = urlParams.get('category');
    
    let filtered = [...allProducts];
    let currentPage = 1;
    const itemsPerPage = 12;
    let activeCategory = 'all';

    // Initialize active category based on slug
    if (window.categorySlug && window.categories) {
        const activeCategory_obj = window.categories.find(c => c.slug === window.categorySlug);
        if (activeCategory_obj) {
            activeCategory = activeCategory_obj.category_id;
        }
    }

    function renderCard(product) {
        const discount = calculateDiscount(product);
        return `
            <div class="product-card-modern">
                <div class="product-image-wrapper-modern">
                    <a href="/product/${product.id}">
                        <img src="${product.image}" alt="${product.name}" class="product-image-modern"
                             onerror="this.src='/assets/images/default_product.png'">
                    </a>
                    <div class="product-badge-modern">SALE</div>
                </div>
                <div class="product-content-modern">
                    <h3 class="product-title-modern">
                        <a href="/product/${product.id}">
                            ${product.name}
                        </a>
                    </h3>
                    ${product.unit ? `<div class="text-muted small mb-2"><i class="fa-solid fa-box"></i> ${product.unit}</div>` : ''}
                    <div class="product-price-modern">
                        <span class="price-original">&#8377; ${Number(product.selling_price).toLocaleString('en-IN')}</span>
                        <span class="price-current">&#8377; ${Number(product.price).toLocaleString('en-IN')}</span>
                        ${discount > 0 ? `<span class="price-discount">${discount}% off</span>` : ''}
                    </div>
                    <div class="product-actions-modern">
                        <div class="quantity-wrapper-modern">
                            <input type="number" class="quantity-input-modern quantity" value="1" min="1" data-product-id="${product.id}">
                        </div>
                        <button class="btn-add-cart-modern btn-cart" data-product-id="${product.id}">
                            <i class="bi bi-cart-plus"></i>
                            <span>Add to Cart</span>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    function calculateDiscount(product) {
        if (!product.selling_price || product.selling_price === 0) return 0;
        const discount = ((product.selling_price - product.price) / product.selling_price) * 100;
        return Math.round(discount);
    }

    function applyFilters() {
        const search = document.getElementById('searchInput')?.value.toLowerCase() || '';
        const sort = document.getElementById('sortSelect')?.value || 'all';

        filtered = allProducts.filter(p => {
            if (activeCategory !== 'all' && activeCategory !== null && p.cat_id != activeCategory) return false;
            if (search && !p.name.toLowerCase().includes(search)) return false;
            return true;
        });

        if (sort === 'price-low') filtered.sort((a, b) => a.price - b.price);
        else if (sort === 'price-high') filtered.sort((a, b) => b.price - a.price);
        else if (sort === 'newest') filtered.sort((a, b) => a.id - b.id);
        else if (sort === 'name') filtered.sort((a, b) => a.name.localeCompare(b.name));

        currentPage = 1;
        renderAll();
        updateFrequentlyBought();
    }

    function renderAll() {
        const grid = document.getElementById('productGrid');
        if (!grid) return;

        const total = filtered.length;
        const start = (currentPage - 1) * itemsPerPage;
        const page = filtered.slice(start, start + itemsPerPage);

        grid.innerHTML = page.length 
            ? page.map(renderCard).join('')
            : '<div class="no-results"><div class="no-results-icon">🔍</div><div class="no-results-text">No products found</div><div class="no-results-desc">Try adjusting your filters or search term</div></div>';

        renderPagination(total);
    }

    function renderPagination(total) {
        const pages = Math.ceil(total / itemsPerPage);
        const pg = document.getElementById('pagination');
        if (!pg || pages <= 1) { 
            if (pg) pg.innerHTML = '';
            return;
        }
        
        let html = '';
        for (let i = 1; i <= pages; i++) {
            html += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="goToShopPage(${i})">${i}</button>`;
        }
        pg.innerHTML = html;
    }

    window.goToShopPage = function(p) { 
        currentPage = p; 
        renderAll(); 
        window.scrollTo(0, 0); 
    };

    window.filterByTab = function(catId, btn) {
        document.querySelectorAll('.category-tab').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        if (catId === 'all') {
            window.location.href = `/shop`;
        } else {
            const cat = window.categories.find(c => c.category_id == catId);
            if (cat) {
                window.location.href = `/shop?category=${cat.slug}`;
            }
        }
    };

    window.applyShopFilters = function() {
        applyFilters();
    };

    // ════════ EVENT LISTENERS ════════
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const sortSelect = document.getElementById('sortSelect');

        if (searchInput) {
            searchInput.addEventListener('keyup', applyFilters);
        }
        if (sortSelect) {
            sortSelect.addEventListener('change', applyFilters);
        }

        // Initialize on page load
        if (allProducts.length > 0) {
            renderAll();
            updateFrequentlyBought();
        }
    });

    function updateFrequentlyBought() {
        // Update frequently bought section if it exists
        const frequentlyBoughtGrid = document.querySelector('.frequently-bought-grid');
        if (frequentlyBoughtGrid && filtered.length > 0) {
            const items = filtered.slice(0, 4);
            frequentlyBoughtGrid.innerHTML = items.map(item => `
                <div class="frequently-bought-item" onclick="window.location.href='/product/${item.id}'">
                    <img src="${item.image}" alt="${item.name}" class="frequently-bought-icon"
                         onerror="this.src='/assets/images/default_product.png'">
                    <div class="frequently-bought-name">${item.name}</div>
                </div>
            `).join('');
        }
    }
})();
