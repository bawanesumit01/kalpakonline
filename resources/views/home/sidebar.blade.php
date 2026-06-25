<!-- Sidebar for Static Pages -->
<div class="sidebar-menu sticky-top" style="top: 20px;">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0 fw-bold">
                <i class="bi bi-list-ul me-2"></i>Quick Links
            </h6>
        </div>
        <div class="list-group list-group-flush">
            <!-- Information Section -->
            <div class="list-group-item bg-light fw-bold text-uppercase" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                <i class="bi bi-info-circle me-2"></i>Information
            </div>
            <a href="{{ route('page.about') }}" class="list-group-item list-group-item-action {{ Route::currentRouteName() === 'page.about' ? 'active' : '' }}">
                <i class="bi bi-building me-2"></i>About Us
            </a>
            <a href="{{ route('page.privacy') }}" class="list-group-item list-group-item-action {{ Route::currentRouteName() === 'page.privacy' ? 'active' : '' }}">
                <i class="bi bi-shield-lock me-2"></i>Privacy Policy
            </a>
            <a href="{{ route('page.terms') }}" class="list-group-item list-group-item-action {{ Route::currentRouteName() === 'page.terms' ? 'active' : '' }}">
                <i class="bi bi-file-text me-2"></i>Terms & Conditions
            </a>

            <!-- Shopping Section -->
            <div class="list-group-item bg-light fw-bold text-uppercase mt-2" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                <i class="bi bi-bag-check me-2"></i>Shopping
            </div>
            <a href="{{ route('page.shipping') }}" class="list-group-item list-group-item-action {{ Route::currentRouteName() === 'page.shipping' ? 'active' : '' }}">
                <i class="bi bi-truck me-2"></i>Shipping Policy
            </a>
            <a href="{{ route('page.returns') }}" class="list-group-item list-group-item-action {{ Route::currentRouteName() === 'page.returns' ? 'active' : '' }}">
                <i class="bi bi-arrow-left-right me-2"></i>Returns & Refunds
            </a>

            <!-- Support Section -->
            <div class="list-group-item bg-light fw-bold text-uppercase mt-2" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                <i class="bi bi-headset me-2"></i>Support
            </div>
            <a href="{{ route('page.contact') }}" class="list-group-item list-group-item-action {{ Route::currentRouteName() === 'page.contact' ? 'active' : '' }}">
                <i class="bi bi-envelope me-2"></i>Contact Us
            </a>
            <a href="{{ route('page.faq') }}" class="list-group-item list-group-item-action {{ Route::currentRouteName() === 'page.faq' ? 'active' : '' }}">
                <i class="bi bi-question-circle me-2"></i>FAQ
            </a>

            <!-- Store Section -->
            <div class="list-group-item bg-light fw-bold text-uppercase mt-2" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                <i class="bi bi-shop me-2"></i>Store
            </div>
            <a href="{{ route('home.index') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-house-door me-2"></i>Home
            </a>
            <a href="{{ route('shop') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-bricks me-2"></i>Shop Products
            </a>
            <a href="{{ route('cart.view') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-cart3 me-2"></i>Shopping Cart
                <span class="badge bg-primary rounded-pill float-end">{{ $cartCount ?? 0 }}</span>
            </a>
        </div>
    </div>

    <!-- Help Box -->
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-body text-center">
            <h6 class="card-title fw-bold mb-2">
                <i class="bi bi-telephone text-primary"></i>
            </h6>
            <p class="card-text small text-muted mb-2">Need help?</p>
            <p class="card-text mb-3">
                <strong style="color: #3ca090;">support@kalpakonline.co.in</strong>
            </p>
            <a href="{{ route('page.contact') }}" class="btn btn-sm btn-primary w-100">
                <i class="bi bi-chat-dots me-1"></i>Contact Support
            </a>
        </div>
    </div>
</div>

<style>
    .sidebar-menu .list-group-item {
        border-left: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .sidebar-menu .list-group-item:hover {
        border-left-color: #3ca090;
        background-color: #f8f9fa;
        padding-left: 1.5rem;
    }

    .sidebar-menu .list-group-item.active {
        border-left-color: #3ca090;
        background-color: #e8f3f1;
        color: #3ca090;
        font-weight: 600;
    }

    .sidebar-menu .list-group-item i {
        color: #3ca090;
    }

    @media (max-width: 991.98px) {
        .sidebar-menu {
            position: static !important;
            margin-bottom: 2rem;
        }
    }
</style>
