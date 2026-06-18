@extends('home.app')

@section('content')

<style>
.shop-wrap { display: flex; gap: 0; min-height: 100vh; }

/* ── Sidebar ── */
.shop-sidebar {
  width: 260px; min-width: 260px;
  background: #fff;
  border-right: 1px solid #e9ecef;
  padding: 24px 18px;
  position: sticky; top: 0;
  height: 100vh; overflow-y: auto;
}
.shop-sidebar::-webkit-scrollbar { width: 4px; }
.shop-sidebar::-webkit-scrollbar-thumb { background: #dee2e6; border-radius: 4px; }

.sidebar-heading {
  font-size: 16px; font-weight: 700;
  color: #212529; margin-bottom: 20px;
  padding-bottom: 12px; border-bottom: 2px solid #f1f3f5;
  letter-spacing: 0.3px;
}
.s-section { margin-bottom: 22px; padding-bottom: 22px; border-bottom: 1px solid #f1f3f5; }
.s-section:last-of-type { border-bottom: none; }
.s-title {
  font-size: 12px; font-weight: 700;
  color: #6c757d; text-transform: uppercase;
  letter-spacing: 0.8px; margin-bottom: 12px;
}
.filter-label {
  display: flex; align-items: center; gap: 9px;
  font-size: 13.5px; color: #495057;
  margin-bottom: 8px; cursor: pointer;
  transition: color 0.15s;
}
.filter-label:hover { color: #212529; }
.filter-label input[type=checkbox],
.filter-label input[type=radio] { accent-color: var(--bs-primary); width: 15px; height: 15px; }
.filter-count { margin-left: auto; font-size: 11px; color: #adb5bd; }

/* Price slider */
.price-slider { width: 100%; accent-color: var(--bs-primary); }
.price-display {
  display: flex; justify-content: space-between;
  font-size: 12px; color: #6c757d; margin: 5px 0 10px;
}
.price-inputs { display: flex; gap: 8px; }
.price-input {
  flex: 1; padding: 6px 8px; font-size: 12px;
  border: 1px solid #dee2e6; border-radius: 6px;
  color: #495057; background: #f8f9fa;
}
.price-input:focus { outline: none; border-color: var(--bs-primary); }

/* Star rating */
.star-row {
  display: flex; align-items: center; gap: 6px;
  margin-bottom: 7px; cursor: pointer;
  font-size: 13px; color: #6c757d;
  padding: 4px 6px; border-radius: 6px; transition: background 0.15s;
}
.star-row:hover { background: #f8f9fa; color: #212529; }
.star-row.active { background: #fff8e1; }
.stars { color: #f9a825; font-size: 14px; letter-spacing: -1px; }

/* Color swatches */
.color-dots { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px; }
.cdot {
  width: 22px; height: 22px; border-radius: 50%;
  cursor: pointer; border: 2px solid transparent;
  transition: transform 0.15s, border-color 0.15s;
}
.cdot:hover { transform: scale(1.15); }
.cdot.active { border-color: #495057; transform: scale(1.1); }

.btn-clear-all {
  width: 100%; padding: 9px; border: 1px solid #dee2e6;
  border-radius: 8px; cursor: pointer; font-size: 13px;
  background: transparent; color: #6c757d; transition: all 0.15s;
}
.btn-clear-all:hover { background: #f8f9fa; color: #212529; }

/* ── Main Area ── */
.shop-main { flex: 1; min-width: 0; padding: 24px 20px; background: #f8f9fa; }

.shop-breadcrumb {
  font-size: 12px; color: #6c757d; margin-bottom: 16px;
}
.shop-breadcrumb a { color: var(--bs-primary); text-decoration: none; }
.shop-breadcrumb a:hover { text-decoration: underline; }

.top-bar {
  display: flex; align-items: center; gap: 10px;
  flex-wrap: wrap; margin-bottom: 14px;
  background: #fff; padding: 12px 16px;
  border-radius: 10px; border: 1px solid #e9ecef;
}
.search-box {
  flex: 1; min-width: 200px; padding: 8px 14px;
  border: 1px solid #dee2e6; border-radius: 8px;
  font-size: 13.5px; color: #495057; background: #f8f9fa;
  transition: border-color 0.15s;
}
.search-box:focus { outline: none; border-color: var(--bs-primary); background: #fff; }
.sort-sel {
  padding: 8px 12px; border: 1px solid #dee2e6;
  border-radius: 8px; font-size: 13px; color: #495057;
  background: #f8f9fa; cursor: pointer;
}
.sort-sel:focus { outline: none; border-color: var(--bs-primary); }
.view-btns { display: flex; gap: 4px; }
.vbtn {
  padding: 8px 12px; border: 1px solid #dee2e6;
  border-radius: 7px; cursor: pointer; font-size: 14px;
  background: #f8f9fa; color: #6c757d; transition: all 0.15s;
}
.vbtn.active { background: var(--bs-primary); color: #fff; border-color: transparent; }

.active-tags { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 12px; }
.af-tag {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 4px 12px; background: #fff;
  border: 1px solid #dee2e6; border-radius: 20px;
  font-size: 12px; color: #495057; cursor: pointer;
  transition: all 0.15s;
}
.af-tag:hover { border-color: #dc3545; color: #dc3545; }

.result-info { font-size: 13px; color: #6c757d; margin-bottom: 14px; }

/* ── Product Grid ── */
.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 16px;
}
.product-grid.list-view { grid-template-columns: 1fr; }

.pcard {
  background: #fff; border: 1px solid #e9ecef;
  border-radius: 12px; overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
}
.pcard:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.09); border-color: #dee2e6; }
.pcard.list-view { display: flex; }

.pcard-img-wrap {
  position: relative; background: #f8f9fa;
  aspect-ratio: 1; overflow: hidden;
  display: flex; align-items: center; justify-content: center;
}
.pcard.list-view .pcard-img-wrap { width: 160px; min-width: 160px; aspect-ratio: auto; }
.pcard-img-wrap img { width: 100%; height: 100%; object-fit: contain; padding: 12px; }

.pcard-badge {
  position: absolute; top: 10px; left: 10px;
  padding: 3px 9px; border-radius: 20px;
  font-size: 10px; font-weight: 600; text-transform: uppercase;
  letter-spacing: 0.5px;
}
.badge-sale { background: #fff3cd; color: #856404; }
.badge-new  { background: #d1e7dd; color: #0a3622; }
.badge-hot  { background: #f8d7da; color: #58151c; }

.out-of-stock-overlay {
  position: absolute; inset: 0;
  background: rgba(255,255,255,0.7);
  display: flex; align-items: center; justify-content: center;
}
.out-of-stock-overlay span {
  background: #6c757d; color: #fff;
  padding: 4px 12px; border-radius: 20px;
  font-size: 11px; font-weight: 600;
}

.pcard-body { padding: 12px 14px; flex: 1; }
.pcard-cat { font-size: 10px; color: #adb5bd; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 4px; }
.pcard-name { font-size: 14px; font-weight: 600; color: #212529; margin-bottom: 5px; line-height: 1.4; }
.pcard-price-row { display: flex; align-items: center; gap: 7px; margin: 6px 0; }
.pcard-price { font-size: 16px; font-weight: 700; color: #212529; }
.pcard-old { font-size: 12px; color: #adb5bd; text-decoration: line-through; }
.pcard-disc { font-size: 11px; font-weight: 600; color: #198754; }

.pcard-footer {
  display: flex; gap: 7px; padding: 10px 14px;
  border-top: 1px solid #f1f3f5;
}
.btn-add-cart {
  flex: 1; padding: 8px 10px; font-size: 12.5px; font-weight: 500;
  border: 1px solid #dee2e6; border-radius: 8px; cursor: pointer;
  background: #f8f9fa; color: #495057; transition: all 0.2s;
  display: flex; align-items: center; justify-content: center; gap: 5px;
}
.btn-add-cart:hover:not(:disabled) { background: var(--bs-primary); color: #fff; border-color: transparent; }
.btn-add-cart:disabled { opacity: 0.5; cursor: not-allowed; }
.btn-wish {
  padding: 8px 12px; border: 1px solid #dee2e6;
  border-radius: 8px; cursor: pointer; background: transparent;
  color: #adb5bd; font-size: 15px; transition: all 0.15s;
}
.btn-wish:hover { color: #dc3545; border-color: #f8d7da; }
.btn-wish.active { color: #dc3545; border-color: #f8d7da; background: #fff5f5; }

/* ── Pagination ── */
.shop-pagination { display: flex; gap: 4px; justify-content: center; margin-top: 24px; flex-wrap: wrap; }
.pgbtn {
  width: 34px; height: 34px; border: 1px solid #dee2e6;
  border-radius: 7px; display: flex; align-items: center;
  justify-content: center; cursor: pointer; font-size: 13px;
  background: #fff; color: #6c757d; transition: all 0.15s;
}
.pgbtn.active { background: var(--bs-primary); color: #fff; border-color: transparent; }
.pgbtn:hover:not(.active) { border-color: var(--bs-primary); color: var(--bs-primary); }

/* ── Category filter pills (top) ── */
.cat-pills { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px; }
.cat-pill {
  padding: 6px 16px; border: 1px solid #dee2e6;
  border-radius: 20px; font-size: 12.5px; cursor: pointer;
  background: #fff; color: #6c757d; transition: all 0.15s;
  white-space: nowrap;
}
.cat-pill.active { background: var(--bs-primary); color: #fff; border-color: transparent; }
.cat-pill:hover:not(.active) { border-color: var(--bs-primary); color: var(--bs-primary); }

.no-results {
  grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #6c757d;
}
.no-results .icon { font-size: 48px; margin-bottom: 12px; }

/* ── Responsive ── */
@media (max-width: 768px) {
  .shop-sidebar { display: none; }
  .shop-main { padding: 16px 12px; }
  .product-grid { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; }
}
</style>

<div class="shop-wrap">

  {{-- ════════════ SIDEBAR ════════════ --}}
  <aside class="shop-sidebar">
    <div class="sidebar-heading">🔍 Filters</div>

    {{-- Categories --}}
    <div class="s-section">
      <div class="s-title">Categories</div>
      <label class="filter-label">
        <input type="radio" name="cat-filter" value="" onchange="applyFilters()" checked> All Categories
      </label>
      @foreach ($categories as $category)
        <label class="filter-label">
          <input type="radio" name="cat-filter" value="{{ $category->id }}" onchange="applyFilters()">
          {{ $category->category_name }}
          <span class="filter-count">({{ $category->products_count ?? '' }})</span>
        </label>
      @endforeach
    </div>

    {{-- Price Range --}}
    <div class="s-section">
      <div class="s-title">Price Range</div>
      <input type="range" class="price-slider" min="0" max="10000" value="10000"
             id="price-range" oninput="updatePrice(this.value)">
      <div class="price-display">
        <span>₹0</span><span id="price-val">₹10,000</span>
      </div>
      <div class="price-inputs">
        <input class="price-input w-100" type="number" placeholder="Min" id="pmin" oninput="applyFilters()">
        <input class="price-input w-100" type="number" placeholder="Max" id="pmax" value="10000" oninput="applyFilters()">
      </div>
    </div>

  

    {{-- Availability --}}
    <div class="s-section">
      <div class="s-title">Availability</div>
      <label class="filter-label">
        <input type="checkbox" id="instock" onchange="applyFilters()"> In Stock Only
      </label>
      <label class="filter-label">
        <input type="checkbox" id="onsale" onchange="applyFilters()"> On Sale Only
      </label>
    </div>

    <button class="btn-clear-all" onclick="clearAll()">✕ Clear All Filters</button>
  </aside>

  {{-- ════════════ MAIN CONTENT ════════════ --}}
  <div class="shop-main">

    {{-- Breadcrumb --}}
    <div class="shop-breadcrumb">
      <a href="{{ url('/') }}">Home</a> › <span>Shop</span>
    </div>

    {{-- Category Pills (top) --}}
    <div class="cat-pills" id="cat-pills">
      <div class="cat-pill active" onclick="filterByPill('',this)">All</div>
      @foreach ($categories as $category)
        <div class="cat-pill" onclick="filterByPill('{{ $category->id }}', this)"
             data-cat-id="{{ $category->id }}">
          {{ $category->category_name }}
        </div>
      @endforeach
    </div>

    {{-- Top Bar --}}
    <div class="top-bar">
      <input class="search-box" type="text" placeholder="Search products..." id="search-input" oninput="applyFilters()">
      <select class="sort-sel" id="sort-sel" onchange="applyFilters()">
        <option value="popular">Popular</option>
        <option value="price-asc">Price: Low → High</option>
        <option value="price-desc">Price: High → Low</option>
        <option value="newest">Newest</option>
        <option value="name-asc">Name: A → Z</option>
      </select>
      <div class="view-btns">
        <button class="vbtn active" id="grid-btn" onclick="setView('grid')" title="Grid View">⊞</button>
        <button class="vbtn" id="list-btn" onclick="setView('list')" title="List View">☰</button>
      </div>
    </div>

    {{-- Active Filter Tags --}}
    <div class="active-tags" id="active-tags"></div>

    {{-- Result Info --}}
    <div class="result-info" id="result-info">Loading...</div>

    {{-- Product Grid --}}
    <div class="product-grid" id="product-grid"></div>

    {{-- Pagination --}}
    <div class="shop-pagination" id="pagination"></div>
  </div>
</div>

@push('scripts')
@php
$productsJs = $products->map(function($p) {
    return [
        'id'       => $p->id,
        'name'     => $p->product_name,
        'cat_id'   => $p->category_id ?? null,
        'cat_name' => optional($p->category)->category_name ?? 'Uncategorized',
        'price'    => (float)($p->final_price ?? $p->selling_price ?? $p->price ?? 0),
        'old_price'=> (float)($p->mrp ?? $p->price ?? 0),
        'image'    => $p->main_image ? asset('/' . $p->main_image) : asset('/assets/images/default_product.png'),
        'instock'  => ($p->quantity ?? 1) > 0,
        'is_new'   => $p->created_at && \Carbon\Carbon::parse($p->created_at)->diffInDays(now()) <= 30,
    ];
})->values();
 
$categoriesJs = $categories->map(function($c) {
    return [
        'id'   => $c->id,
        'name' => $c->category_name,
    ];
})->values();
@endphp
<script>
// ─── Inject Laravel data as JS ───
const allProducts   = {!! json_encode($productsJs) !!};
const allCategories = {!! json_encode($categoriesJs) !!};
 
// ─── State ───
let filtered   = [...allProducts];
let viewMode   = 'grid';
let minRating  = 0;
let activeCatId= '';
let page       = 1;
const PER_PAGE = 12;
 
// ─── Helpers ───
function pct(price, old) {
  return old > price ? Math.round((1 - price / old) * 100) : 0;
}
 
function formatPrice(n) {
  return '₹' + Number(n).toLocaleString('en-IN');
}
 
// ─── Render one card ───
function renderCard(p) {
  const isList = viewMode === 'list';
  const disc   = pct(p.price, p.old_price);
  const badge  = p.is_new ? 'new' : (disc >= 10 ? 'sale' : '');
  const badgeLabel = p.is_new ? 'NEW' : (disc >= 10 ? disc + '% OFF' : '');
 
  return `
  <div class="pcard${isList ? ' list-view' : ''}" id="pcard-${p.id}">
    <div class="pcard-img-wrap">
      <img src="${p.image}" alt="${p.name}" loading="lazy"
           onerror="this.src='{{ asset('/assets/images/default_product.png') }}'">
      ${badge ? `<span class="pcard-badge badge-${badge}">${badgeLabel}</span>` : ''}
      ${!p.instock ? `<div class="out-of-stock-overlay"><span>Out of Stock</span></div>` : ''}
    </div>
    <div style="flex:1;min-width:0;display:flex;flex-direction:column;">
      <div class="pcard-body">
        <div class="pcard-cat">${p.cat_name}</div>
        <div class="pcard-name">${p.name}</div>
        <div class="pcard-price-row">
          <span class="pcard-price">${formatPrice(p.price)}</span>
          ${p.old_price > p.price
            ? `<span class="pcard-old">${formatPrice(p.old_price)}</span>
               <span class="pcard-disc">${disc}% off</span>`
            : ''}
        </div>
        ${isList ? `<div style="font-size:12px;color:#adb5bd;margin-top:5px">
          ${p.instock ? '✓ In Stock' : '✗ Out of Stock'}
        </div>` : ''}
      </div>
      <div class="pcard-footer" style="margin-top:auto;">
        <button class="btn-add-cart" onclick="addToCartJs(${p.id}, event)"
          ${!p.instock ? 'disabled' : ''} data-product-id="${p.id}">
          <svg width="14" height="14"><use xlink:href="#cart"></use></svg>
          Add to Cart
        </button>
        <button class="btn-wish" onclick="toggleWish(${p.id}, this)" title="Wishlist">♡</button>
      </div>
    </div>
  </div>`;
}
 
// ─── Apply Filters ───
function applyFilters() {
  const q       = document.getElementById('search-input').value.toLowerCase().trim();
  const sort    = document.getElementById('sort-sel').value;
  const maxP    = parseFloat(document.getElementById('pmax').value) || 10000;
  const minP    = parseFloat(document.getElementById('pmin').value) || 0;
  const onlyStk = document.getElementById('instock').checked;
  const onlySale= document.getElementById('onsale').checked;
  const catRad  = document.querySelector('input[name="cat-filter"]:checked');
  const catId   = catRad ? catRad.value : activeCatId;
 
  filtered = allProducts.filter(p => {
    if (q && !p.name.toLowerCase().includes(q) && !p.cat_name.toLowerCase().includes(q)) return false;
    if (catId && String(p.cat_id) !== String(catId)) return false;
    if (p.price > maxP || p.price < minP) return false;
    if (onlyStk && !p.instock) return false;
    if (onlySale && p.old_price <= p.price) return false;
    return true;
  });
 
  if (sort === 'price-asc')  filtered.sort((a,b) => a.price - b.price);
  else if (sort === 'price-desc') filtered.sort((a,b) => b.price - a.price);
  else if (sort === 'newest')    filtered.sort((a,b) => (b.is_new ? 1 : 0) - (a.is_new ? 1 : 0));
  else if (sort === 'name-asc')  filtered.sort((a,b) => a.name.localeCompare(b.name));
 
  page = 1;
  renderAll();
}
 
function renderAll() {
  const grid  = document.getElementById('product-grid');
  const total = filtered.length;
  const start = (page - 1) * PER_PAGE;
  const slice = filtered.slice(start, start + PER_PAGE);
 
  document.getElementById('result-info').textContent =
    `Showing ${Math.min(start+1, total)}–${Math.min(start+slice.length, total)} of ${total} product${total !== 1 ? 's' : ''}`;
 
  grid.className = 'product-grid' + (viewMode === 'list' ? ' list-view' : '');
 
  grid.innerHTML = slice.length
    ? slice.map(renderCard).join('')
    : `<div class="no-results">
         <div class="icon">🔍</div>
         <div style="font-weight:600;margin-bottom:4px">No products found</div>
         <div style="font-size:13px">Try adjusting your filters or search term</div>
       </div>`;
 
  renderPagination(total);
  renderActiveTags();
}
 
function renderPagination(total) {
  const pages = Math.ceil(total / PER_PAGE);
  const pg    = document.getElementById('pagination');
  if (pages <= 1) { pg.innerHTML = ''; return; }
  let h = `<div class="pgbtn" onclick="changePage(${Math.max(1,page-1)})">‹</div>`;
  for (let i = 1; i <= pages; i++)
    h += `<div class="pgbtn${i===page?' active':''}" onclick="changePage(${i})">${i}</div>`;
  h += `<div class="pgbtn" onclick="changePage(${Math.min(pages,page+1)})">›</div>`;
  pg.innerHTML = h;
}
 
function changePage(p) { page = p; renderAll(); window.scrollTo(0,80); }
 
function renderActiveTags() {
  const tags = document.getElementById('active-tags');
  let h = '';
  const catRad = document.querySelector('input[name="cat-filter"]:checked');
  if (catRad && catRad.value) {
    const cat = allCategories.find(c => String(c.id) === catRad.value);
    if (cat) h += `<div class="af-tag" onclick="clearCategory()">📁 ${cat.name} ×</div>`;
  }
  if (minRating > 0) h += `<div class="af-tag" onclick="setRating(0,null)">${minRating}★+ ×</div>`;
  if (document.getElementById('instock').checked)
    h += `<div class="af-tag" onclick="document.getElementById('instock').checked=false;applyFilters()">In Stock ×</div>`;
  if (document.getElementById('onsale').checked)
    h += `<div class="af-tag" onclick="document.getElementById('onsale').checked=false;applyFilters()">On Sale ×</div>`;
  tags.innerHTML = h;
}
 
// ─── Category Pill click ───
function filterByPill(catId, el) {
  document.querySelectorAll('.cat-pill').forEach(p => p.classList.remove('active'));
  el.classList.add('active');
  activeCatId = catId;
  // sync sidebar radio
  const radio = document.querySelector(`input[name="cat-filter"][value="${catId}"]`);
  if (radio) radio.checked = true;
  applyFilters();
}
 
function clearCategory() {
  activeCatId = '';
  document.querySelector('input[name="cat-filter"][value=""]').checked = true;
  document.querySelectorAll('.cat-pill').forEach(p => p.classList.remove('active'));
  document.querySelector('.cat-pill').classList.add('active');
  applyFilters();
}
 
// ─── Price ───
function updatePrice(v) {
  document.getElementById('price-val').textContent = '₹' + parseInt(v).toLocaleString('en-IN');
  document.getElementById('pmax').value = v;
  applyFilters();
}
 
// ─── Rating ───
function setRating(r, el) {
  minRating = r;
  document.querySelectorAll('.star-row').forEach(x => x.classList.remove('active'));
  if (el) el.classList.add('active');
  const radios = document.querySelectorAll('.star-row input[type=radio]');
  if (r === 0 && radios[0]) radios[0].checked = true;
  applyFilters();
}
 
// ─── View Toggle ───
function setView(v) {
  viewMode = v;
  document.getElementById('grid-btn').classList.toggle('active', v === 'grid');
  document.getElementById('list-btn').classList.toggle('active', v === 'list');
  renderAll();
}
 
// ─── Wishlist (client-side only) ───
const wishlist = new Set();
function toggleWish(id, btn) {
  if (wishlist.has(id)) { wishlist.delete(id); btn.classList.remove('active'); btn.innerHTML = '♡'; }
  else { wishlist.add(id); btn.classList.add('active'); btn.innerHTML = '♥'; }
}
 
// ─── Add to Cart (wired to your existing AJAX) ───
function addToCartJs(productId, e) {
  const btn = e.currentTarget;
  btn.disabled = true;
  btn.innerHTML = 'Adding...';
 
  $.ajax({
    url: "{{ route('cart.add') }}",
    method: 'POST',
    data: {
      _token:     $('meta[name="csrf-token"]').attr('content'),
      product_id: productId,
      quantity:   1,
    },
    success: function (res) {
      if (res.success) {
        $('.cart-count').text(res.cart_count);
        renderOffcanvasCart();
        showToast(res.message, 'success');
        setTimeout(() => {
          const el = document.getElementById('offcanvasCart');
          if (el) new bootstrap.Offcanvas(el).show();
        }, 300);
        btn.innerHTML = '<svg width="14" height="14"><use xlink:href="#cart"></use></svg> ✓ Added';
        btn.style.background = 'var(--bs-primary)';
        btn.style.color = '#fff';
        btn.style.borderColor = 'transparent';
      }
    },
    error: function (xhr) {
      console.error(xhr.status, xhr.responseText);
      if (xhr.status === 419) alert('CSRF mismatch.');
      else alert('Error ' + xhr.status);
    },
    complete: function () {
      btn.disabled = false;
      setTimeout(() => {
        btn.innerHTML = '<svg width="14" height="14"><use xlink:href="#cart"></use></svg> Add to Cart';
        btn.style.background = '';
        btn.style.color = '';
        btn.style.borderColor = '';
      }, 2000);
    }
  });
}
 
// ─── Clear All ───
function clearAll() {
  document.querySelector('input[name="cat-filter"][value=""]').checked = true;
  document.querySelectorAll('.cat-pill').forEach(p => p.classList.remove('active'));
  document.querySelector('.cat-pill').classList.add('active');
  document.getElementById('price-range').value = 10000;
  document.getElementById('price-val').textContent = '₹10,000';
  document.getElementById('pmin').value = '';
  document.getElementById('pmax').value = 10000;
  document.getElementById('search-input').value = '';
  document.getElementById('instock').checked = false;
  document.getElementById('onsale').checked  = false;
  document.querySelectorAll('.star-row').forEach((x,i) => x.classList.toggle('active', i===0));
  minRating = 0; activeCatId = '';
  applyFilters();
}
 
// ─── Toast (reuse from home page) ───
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
 
// ─── Offcanvas cart helpers (same as home page) ───
function renderOffcanvasCart() {
  $.ajax({
    url: "{{ route('cart.items') }}",
    method: 'GET',
    success: function (res) {
      if (res.success) {
        $('#offcanvas-cart-items').html(res.html);
        $('.offcanvas-total').html('&#8377; ' + res.cartTotal);
        $('.cart-count').text(res.cart_count);
        $('#offcanvas-cart-footer').toggle(res.cart_count > 0);
      }
    }
  });
}
 
// ─── Init ───
$(document).ready(function () { applyFilters(); });
</script>
@endpush
@endsection