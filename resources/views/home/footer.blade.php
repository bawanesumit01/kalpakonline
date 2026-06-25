<!-- Professional E-Commerce Footer -->
<footer class="bg-dark text-white py-5" style="background: linear-gradient(135deg, #1a3a3a 0%, #2d5a5a 100%);">
    <div class="container-lg">
        <!-- Main Footer Content -->
        <div class="row mb-4">
            <!-- Brand & Social -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <div class="footer-section">
                    <div class="mb-4">
                        <img src="{{ asset('/assets/images/kalpak-logo.png') }}" width="220" height="65" alt="Kalpak Online Logo" class="img-fluid">
                    </div>
                    <p class="text-light mb-3 small">Your trusted destination for quality products and exceptional customer service.</p>
                    
                    <!-- Social Links -->
                    <div class="social-links">
                        <h6 class="text-uppercase fw-bold mb-3" style="font-size: 0.9rem; letter-spacing: 1px;">Follow Us</h6>
                        <ul class="d-flex list-unstyled gap-2">
                            <li>
                                <a href="#" class="btn btn-sm btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <svg width="18" height="18"><use xlink:href="#facebook"></use></svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-sm btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <svg width="18" height="18"><use xlink:href="#twitter"></use></svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-sm btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <svg width="18" height="18"><use xlink:href="#instagram"></use></svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-sm btn-outline-light rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <svg width="18" height="18"><use xlink:href="#youtube"></use></svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Information Links -->
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <div class="footer-section">
                    <h6 class="text-uppercase fw-bold mb-3" style="font-size: 0.95rem; letter-spacing: 1px; border-bottom: 2px solid #3ca090; padding-bottom: 10px;">Information</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('page.about') }}" class="text-light text-decoration-none footer-link">
                                <i class="bi bi-chevron-right me-2" style="font-size: 0.8rem;"></i>About Us
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('page.privacy') }}" class="text-light text-decoration-none footer-link">
                                <i class="bi bi-chevron-right me-2" style="font-size: 0.8rem;"></i>Privacy Policy
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('page.terms') }}" class="text-light text-decoration-none footer-link">
                                <i class="bi bi-chevron-right me-2" style="font-size: 0.8rem;"></i>Terms & Conditions
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('home.index') }}" class="text-light text-decoration-none footer-link">
                                <i class="bi bi-chevron-right me-2" style="font-size: 0.8rem;"></i>Home
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Shopping Links -->
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <div class="footer-section">
                    <h6 class="text-uppercase fw-bold mb-3" style="font-size: 0.95rem; letter-spacing: 1px; border-bottom: 2px solid #3ca090; padding-bottom: 10px;">Shopping</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('page.shipping') }}" class="text-light text-decoration-none footer-link">
                                <i class="bi bi-chevron-right me-2" style="font-size: 0.8rem;"></i>Shipping Policy
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('page.returns') }}" class="text-light text-decoration-none footer-link">
                                <i class="bi bi-chevron-right me-2" style="font-size: 0.8rem;"></i>Returns & Refunds
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('shop') }}" class="text-light text-decoration-none footer-link">
                                <i class="bi bi-chevron-right me-2" style="font-size: 0.8rem;"></i>Shop Products
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('cart.view') }}" class="text-light text-decoration-none footer-link">
                                <i class="bi bi-chevron-right me-2" style="font-size: 0.8rem;"></i>Shopping Cart
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Customer Service -->
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <div class="footer-section">
                    <h6 class="text-uppercase fw-bold mb-3" style="font-size: 0.95rem; letter-spacing: 1px; border-bottom: 2px solid #3ca090; padding-bottom: 10px;">Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('page.contact') }}" class="text-light text-decoration-none footer-link">
                                <i class="bi bi-chevron-right me-2" style="font-size: 0.8rem;"></i>Contact Us
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('page.faq') }}" class="text-light text-decoration-none footer-link">
                                <i class="bi bi-chevron-right me-2" style="font-size: 0.8rem;"></i>FAQ
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="mailto:support@kalpakonline.co.in" class="text-light text-decoration-none footer-link">
                                <i class="bi bi-chevron-right me-2" style="font-size: 0.8rem;"></i>Email Support
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-light text-decoration-none footer-link">
                                <i class="bi bi-chevron-right me-2" style="font-size: 0.8rem;"></i>Track Order
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Newsletter & Contact -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-section">
                    <h6 class="text-uppercase fw-bold mb-3" style="font-size: 0.95rem; letter-spacing: 1px; border-bottom: 2px solid #3ca090; padding-bottom: 10px;">Contact Info</h6>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-telephone" style="color: #3ca090; margin-top: 2px;"></i>
                                <div>
                                    <p class="small text-muted mb-1">Customer Support</p>
                                    <a href="tel:+919876543210" class="text-light text-decoration-none fw-bold">+91-98765-43210</a>
                                </div>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-envelope" style="color: #3ca090; margin-top: 2px;"></i>
                                <div>
                                    <p class="small text-muted mb-1">Email</p>
                                    <a href="mailto:support@kalpakonline.co.in" class="text-light text-decoration-none fw-bold">support@kalpakonline.co.in</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-geo-alt" style="color: #3ca090; margin-top: 2px;"></i>
                                <div>
                                    <p class="small text-muted mb-1">Address</p>
                                    <p class="small text-light mb-0">Kalpak Online<br>Mumbai, Maharashtra<br>India</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

        <!-- Bottom Footer -->
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <p class="mb-0 small text-light">
                    <span style="color: #3ca090; font-weight: bold;">©2026 Kalpak Online.</span> All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="d-flex justify-content-center justify-content-md-end gap-3">
                    <a href="{{ route('page.privacy') }}" class="small text-light text-decoration-none footer-link">Privacy Policy</a>
                    <span class="small text-muted">|</span>
                    <a href="{{ route('page.terms') }}" class="small text-light text-decoration-none footer-link">Terms</a>
                    <span class="small text-muted">|</span>
                    <a href="{{ route('page.shipping') }}" class="small text-light text-decoration-none footer-link">Shipping</a>
                    <span class="small text-muted">|</span>
                    <a href="{{ route('page.returns') }}" class="small text-light text-decoration-none footer-link">Returns</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Footer Styles -->
<style>
    .footer-link {
        transition: all 0.3s ease;
        display: inline-block;
    }

    .footer-link:hover {
        color: #3ca090 !important;
        transform: translateX(2px);
    }

    .social-links a {
        transition: all 0.3s ease;
    }

    .social-links a:hover {
        background-color: #3ca090 !important;
        border-color: #3ca090 !important;
        transform: translateY(-2px);
    }

    .footer-section h6 {
        color: #ffffff;
        font-weight: 700;
    }

    footer p {
        line-height: 1.6;
    }

    /* Responsive Footer */
    @media (max-width: 768px) {
        .footer-section {
            margin-bottom: 2rem;
        }

        .footer-section h6 {
            font-size: 0.85rem !important;
        }
    }
</style>