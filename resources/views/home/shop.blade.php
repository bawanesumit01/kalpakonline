@extends('home.app')

@section('content')
<style>
  :root {
    --primary: #000;
    --light-gray: #f5f5f5;
    --border-color: #e0e0e0;
    --text-primary: #212121;
    --text-secondary: #666;
  }

  * { box-sizing: border-box; }

  /* ════════ HEADER SECTION ════════ */
  .shop-header {
    background: white;
    padding: 24px 20px;
    border-bottom: 1px solid var(--border-color);
  }

  .shop-header-title {
    max-width: 1400px;
    margin: 0 auto;
  }

  .shop-header h1 {
    font-size: 32px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 8px 0;
    letter-spacing: -0.5px;
  }

  /* ════════ CATEGORY TABS ════════ */
  .category-tabs {
    background: white;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-color);
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  .category-tabs::-webkit-scrollbar {
    height: 4px;
  }

  .category-tabs::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 2px;
  }

  .tabs-container {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    gap: 24px;
    padding: 0;
    list-style: none;
    white-space: nowrap;
  }

  .category-tab {
    padding: 8px 0;
    border: none;
    background: transparent;
    color: var(--text-secondary);
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    border-bottom: 2px solid transparent;
  }

  .category-tab:hover {
    color: var(--text-primary);
  }

  .category-tab.active {
    color: var(--text-primary);
    font-weight: 600;
    border-bottom-color: var(--text-primary);
  }

  /* ════════ MAIN CONTENT ════════ */
  .shop-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 32px 20px;
  }

  /* ════════ FILTERS BAR ════════ */
  .filters-bar {
    display: flex;
    gap: 16px;
    align-items: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
  }

  .search-box {
    flex: 1;
    min-width: 250px;
    padding: 12px 16px;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.3s;
  }

  .search-box:focus {
    outline: none;
    border-color: var(--text-primary);
  }

  .sort-select {
    padding: 12px 16px;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    font-size: 14px;
    background: white;
    cursor: pointer;
    transition: border-color 0.3s;
  }

  .sort-select:focus {
    outline: none;
    border-color: var(--text-primary);
  }

  /* ════════ PRODUCT GRID ════════ */
  .product-grid-modern {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 24px;
    margin-bottom: 48px;
  }

  .product-card-modern {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
  }

  .product-card-modern:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  }

  .product-image-wrapper-modern {
    position: relative;
    background: var(--light-gray);
    aspect-ratio: 1;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .product-image-wrapper-modern a {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .product-image-modern {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 16px;
    transition: transform 0.3s ease;
  }

  .product-card-modern:hover .product-image-modern {
    transform: scale(1.08);
  }

  .product-badge-modern {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 6px 10px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: #000;
    color: white;
  }

  .product-content-modern {
    padding: 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .product-title-modern {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 12px 0;
    line-height: 1.4;
    min-height: 28px;
  }

  .product-title-modern a {
    color: var(--text-primary);
    text-decoration: none;
    transition: color 0.2s;
  }

  .product-title-modern a:hover {
    color: #0d6efd;
  }

  .product-price-modern {
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
  }

  .price-original {
    font-size: 13px;
    color: var(--text-secondary);
    text-decoration: line-through;
  }

  .price-current {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
  }

  .price-discount {
    font-size: 12px;
    font-weight: 700;
    color: #dc3545;
    background: #fff3cd;
    padding: 2px 6px;
    border-radius: 3px;
  }

  .product-actions-modern {
    display: flex;
    gap: 8px;
    margin-top: auto;
  }

  .quantity-wrapper-modern {
    display: flex;
    align-items: center;
  }

  .quantity-input-modern {
    width: 60px;
    padding: 8px 10px;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    text-align: center;
    font-size: 13px;
  }

  .btn-add-cart-modern {
    flex: 1;
    padding: 10px 12px;
    background: var(--text-primary);
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }

  .btn-add-cart-modern:hover:not(:disabled) {
    background: #333;
  }

  .btn-add-cart-modern:disabled {
    background: #ccc;
    cursor: not-allowed;
  }

  /* ════════ FREQUENTLY BOUGHT ════════ */
  .frequently-bought {
    background: var(--light-gray);
    padding: 40px 20px;
    margin-bottom: 48px;
    border-radius: 8px;
  }

  .frequently-bought-content {
    max-width: 1400px;
    margin: 0 auto;
  }

  .frequently-bought h2 {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 24px 0;
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .frequently-bought-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 16px;
  }

  .frequently-bought-item {
    background: white;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
  }

  .frequently-bought-item:hover {
    background: var(--text-primary);
    color: white;
    border-color: var(--text-primary);
  }

  .frequently-bought-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 12px;
    border-radius: 8px;
    object-fit: cover;
  }

  .frequently-bought-name {
    font-size: 14px;
    font-weight: 500;
    line-height: 1.4;
  }

  /* ════════ PAGINATION ════════ */
  .pagination {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 40px;
    flex-wrap: wrap;
  }

  .page-btn {
    width: 40px;
    height: 40px;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    background: white;
    color: var(--text-primary);
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s;
  }

  .page-btn:hover {
    border-color: var(--text-primary);
  }

  .page-btn.active {
    background: var(--text-primary);
    color: white;
    border-color: var(--text-primary);
  }

  /* ════════ NO RESULTS ════════ */
  .no-results {
    text-align: center;
    padding: 60px 20px;
  }

  .no-results-icon {
    font-size: 48px;
    margin-bottom: 16px;
  }

  .no-results-text {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 8px;
  }

  .no-results-desc {
    color: var(--text-secondary);
    font-size: 14px;
  }

  /* ════════ RESPONSIVE ════════ */
  @media (max-width: 768px) {
    .product-grid-modern {
      grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
      gap: 16px;
    }

    .frequently-bought-grid {
      grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    }

    .filters-bar {
      flex-direction: column;
    }

    .search-box {
      min-width: 100%;
    }

    .tabs-container {
      gap: 16px;
    }

    .category-tab {
      font-size: 13px;
    }

    .product-actions-modern {
      flex-direction: column;
    }

    .quantity-wrapper-modern {
      width: 100%;
    }

    .quantity-input-modern {
      width: 100%;
    }
  }
</style>

<!-- Header -->
<div class="shop-header">
  <div class="shop-header-title">
    <h1>Shop All Products</h1>
  </div>
</div>

<!-- Category Tabs -->
<div class="category-tabs">
  <ul class="tabs-container">
    <li>
      <button class="category-tab active" onclick="filterByTab('all', this)">All</button>
    </li>
    @foreach($categories as $category)
      <li>
        <button class="category-tab" onclick="filterByTab({{ $category->category_id }}, this)">
          {{ $category->category_name }}
        </button>
      </li>
    @endforeach
  </ul>
</div>

<!-- Main Content -->
<div class="shop-container">

  <!-- Filters Bar -->
  <div class="filters-bar">
    <input type="text" id="searchInput" class="search-box" placeholder="Search products..." oninput="applyFilters()">
    <select id="sortSelect" class="sort-select" onchange="applyFilters()">
      <option value="popular">Sort By: Popular</option>
      <option value="price-low">Sort By: Price Low to High</option>
      <option value="price-high">Sort By: Price High to Low</option>
      <option value="newest">Sort By: Newest</option>
      <option value="name">Sort By: Name A-Z</option>
    </select>
  </div>

  <!-- Product Grid -->
  <div class="product-grid-modern" id="productGrid"></div>

  <!-- Pagination -->
  <div class="pagination" id="pagination"></div>

</div>

<!-- Frequently Bought Section -->
<div class="frequently-bought">
  <div class="frequently-bought-content">
    <h2 id="frequentlyBoughtTitle">Frequently Bought</h2>
    <div class="frequently-bought-grid" id="frequentlyBoughtGrid">
      @foreach($categories->take(6) as $category)
        <div class="frequently-bought-item" onclick="filterByCategory({{ $category->category_id }})">
          <div style="background: var(--light-gray); width: 80px; height: 80px; margin: 0 auto 12px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 32px;">
            📦
          </div>
          <div class="frequently-bought-name">{{ $category->category_name }}</div>
        </div>
      @endforeach
    </div>
  </div>
</div>

@push('scripts')
@php
$productsData = $products->map(function($p) {
    return [
        'id'       => $p->id,
        'name'     => $p->product_name,
        'unit'     => $p->unit,
        'cat_id'   => $p->category_id,
        'cat_name' => $p->category->category_name ?? 'Other',
        'price'    => (float)($p->final_price ?? $p->selling_price ?? 0),
        'selling_price' => (float)($p->selling_price ?? $p->final_price ?? 0),
        'image'    => $p->main_image ? asset($p->main_image) : asset('/assets/images/default_product.png'),
        'instock'  => $p->stock_quantity > 0,
    ];
})->values();
@endphp

<script>
  const allProducts = {!! json_encode($productsData) !!};
  const urlParams = new URLSearchParams(window.location.search);
  const categoryParam = urlParams.get('category');
  
  let filtered = [...allProducts];
  let currentPage = 1;
  const itemsPerPage = 12;
  let activeCategory = 'all';

  // Initialize active category based on slug
  @if($categorySlug)
    const activeCategory_obj = {!! json_encode($categories->first(fn($c) => $c->slug === $categorySlug)) !!};
    if (activeCategory_obj) {
      activeCategory = activeCategory_obj.category_id;
    }
  @endif

  function renderCard(product) {
    const discount = calculateDiscount(product);
    return `
      <div class="product-card-modern">
        <div class="product-image-wrapper-modern">
          <a href="/product/${product.id}">
            <img src="${product.image}" alt="${product.name}" class="product-image-modern"
                 onerror="this.src='{{ asset('/assets/images/default_product.png') }}'">
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
    const search = document.getElementById('searchInput').value.toLowerCase();
    const sort = document.getElementById('sortSelect').value;

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
    if (pages <= 1) { pg.innerHTML = ''; return; }
    let html = '';
    for (let i = 1; i <= pages; i++) {
      html += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="goToPage(${i})">${i}</button>`;
    }
    pg.innerHTML = html;
  }

  function goToPage(p) { currentPage = p; renderAll(); window.scrollTo(0, 0); }

  function filterByTab(catId, btn) {
    document.querySelectorAll('.category-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    if (catId === 'all') {
      window.location.href = `{{ route('shop') }}`;
    } else {
      // Find the slug for this category
      const categories = {!! json_encode($categories->map(fn($c) => ['id' => $c->category_id, 'slug' => $c->slug])) !!};
      const category = categories.find(c => c.id == catId);
      if (category) {
        window.location.href = `{{ route('shop') }}?category=${category.slug}`;
      }
    }
  }

  function filterByCategory(catId) {
    const categories = {!! json_encode($categories->map(fn($c) => ['id' => $c->category_id, 'slug' => $c->slug])) !!};
    const category = categories.find(c => c.id == catId);
    if (category) {
      window.location.href = `{{ route('shop') }}?category=${category.slug}`;
    }
  }

  function updateFrequentlyBought() {
    const grid = document.getElementById('frequentlyBoughtGrid');
    const title = document.getElementById('frequentlyBoughtTitle');
    
    if (activeCategory !== 'all' && activeCategory !== null) {
      const categoryProducts = allProducts.filter(p => p.cat_id == activeCategory);
      
      const category = categoryProducts.length > 0 ? categoryProducts[0].cat_name : 'Category';
      title.textContent = `More from ${category}`;
      
      let html = '';
      categoryProducts.slice(0, 6).forEach(product => {
        html += `
          <div class="frequently-bought-item" onclick="goToProductDetails(${product.id})">
            <img src="${product.image}" alt="${product.name}" class="frequently-bought-icon"
                 onerror="this.src='{{ asset('/assets/images/default_product.png') }}'">
            <div class="frequently-bought-name">${product.name}</div>
          </div>
        `;
      });
      grid.innerHTML = html;
    } else {
      title.textContent = 'Frequently Bought';
      let allCategoriesHtml = '';
      const allCategories = {!! json_encode($categories->map(fn($c) => ['id' => $c->category_id, 'name' => $c->category_name])->take(6)) !!};
      allCategories.forEach(category => {
        allCategoriesHtml += `
          <div class="frequently-bought-item" onclick="filterByCategory(${category.id})">
            <div style="background: var(--light-gray); width: 80px; height: 80px; margin: 0 auto 12px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 32px;">
              📦
            </div>
            <div class="frequently-bought-name">${category.name}</div>
          </div>
        `;
      });
      grid.innerHTML = allCategoriesHtml;
    }
  }

  function goToProductDetails(productId) {
    window.location.href = `/product/${productId}`;
  }

  $(document).ready(function() {
    // Highlight active tab
    if (activeCategory !== 'all' && activeCategory !== null) {
      document.querySelectorAll('.category-tab').forEach(tab => {
        tab.classList.remove('active');
      });
      const activeTab = document.querySelector(`.category-tab[onclick*="filterByTab(${activeCategory}"]`);
      if (activeTab) activeTab.classList.add('active');
    }
    applyFilters();
    updateFrequentlyBought();

    // =====================
    // ADD TO CART (Same as Home Page)
    // =====================
    $(document).on('click', '.btn-cart', function(e) {
      e.preventDefault();

      const btn = $(this);
      const productId = btn.attr('data-product-id');
      const quantity = btn.closest('.product-actions-modern').find('.quantity').val() || 1;

      if (!productId) {
        alert('Product ID missing!');
        return;
      }

      btn.prop('disabled', true).html('Adding...');

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
          console.error('Error:', xhr.status, xhr.responseText);
          alert('Error adding to cart');
        },
        complete: function() {
          btn.prop('disabled', false).html('<i class="bi bi-cart-plus"></i> <span>Add to Cart</span>');
        }
      });
    });

    function renderOffcanvasCart() {
      $.ajax({
        url: "{{ route('cart.items') }}",
        method: 'GET',
        success: function(res) {
          if (res.success) {
            $('#offcanvas-cart-items').html(res.html);
            $('.offcanvas-total').html('&#8377; ' + res.cartTotal);
            $('.cart-count').text(res.cart_count);
            $('#offcanvas-cart-footer').toggle(res.cart_count > 0);
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
