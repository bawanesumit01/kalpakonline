@extends('home.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">FAQ</li>
                </ol>
            </nav>

            <div class="mb-5">
                <h1 class="display-5 fw-bold mb-3">Frequently Asked Questions</h1>
                <p class="lead text-muted">Find answers to common questions about shopping at Kalpak Online.</p>
            </div>

            <!-- Search FAQ -->
            <div class="mb-5">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light border-0">
                        <i class="fas fa-search"></i>
                    </span>
                    <input 
                        type="text" 
                        class="form-control form-control-lg border-0 bg-light" 
                        id="faqSearch"
                        placeholder="Search FAQs..."
                    >
                </div>
            </div>

            <!-- FAQ Sections -->
            <div class="row g-4">
                <!-- Ordering & Payments -->
                <div class="col-lg-12">
                    <h3 class="fw-bold mb-4 mt-4">
                        <i class="fas fa-shopping-bag text-primary me-2"></i>Ordering & Payments
                    </h3>
                    <div class="accordion accordion-flush mb-5">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    How do I place an order?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqOrders">
                                <div class="accordion-body">
                                    <ol>
                                        <li>Browse our catalog and add items to your cart</li>
                                        <li>Click the cart icon and review your items</li>
                                        <li>Click "Proceed to Checkout"</li>
                                        <li>Enter your shipping address</li>
                                        <li>Review order summary and select Cash on Delivery</li>
                                        <li>Click "Place Order"</li>
                                        <li>You'll receive an order confirmation email</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    What payment methods do you accept?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqOrders">
                                <div class="accordion-body">
                                    We currently accept <strong>Cash on Delivery (COD)</strong> payments. You can pay the full amount to our delivery partner when your order arrives at your doorstep.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Can I modify or cancel my order?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqOrders">
                                <div class="accordion-body">
                                    Orders can be modified or cancelled within <strong>2 hours</strong> of placement. After that, contact our support team at support@kalpakonline.co.in for assistance.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    Do you charge any hidden fees?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqOrders">
                                <div class="accordion-body">
                                    No, we don't charge any hidden fees. All costs including product price, taxes, and shipping charges are clearly displayed before you confirm your order. What you see is what you pay.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping & Delivery -->
                <div class="col-lg-12">
                    <h3 class="fw-bold mb-4 mt-4">
                        <i class="fas fa-truck text-primary me-2"></i>Shipping & Delivery
                    </h3>
                    <div class="accordion accordion-flush mb-5">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    What are your shipping charges?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse show" data-bs-parent="#faqShipping">
                                <div class="accordion-body">
                                    <ul class="mb-0">
                                        <li><strong>Free Shipping:</strong> On orders above ₹499</li>
                                        <li><strong>Standard Shipping:</strong> ₹40 for orders below ₹499</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                    What's the expected delivery time?
                                </button>
                            </h2>
                            <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqShipping">
                                <div class="accordion-body">
                                    Standard delivery typically takes <strong>5-7 working days</strong> from order confirmation. Delivery times may vary based on your location and product availability. Express delivery is available in select cities.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                                    How do I track my order?
                                </button>
                            </h2>
                            <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqShipping">
                                <div class="accordion-body">
                                    You can track your order through:
                                    <ul class="mt-2 mb-0">
                                        <li>Your account dashboard at kalpakonline.co.in</li>
                                        <li>Tracking link in your order confirmation email</li>
                                        <li>SMS updates sent to your registered mobile number</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                                    Do you deliver to all areas?
                                </button>
                            </h2>
                            <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqShipping">
                                <div class="accordion-body">
                                    We deliver to most cities and towns across India. Some remote areas may have limited service. You can check if your area is serviceable during checkout by entering your pin code.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq9">
                                    What if I'm not home during delivery?
                                </button>
                            </h2>
                            <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqShipping">
                                <div class="accordion-body">
                                    Our delivery partner will try to contact you on the phone number provided. If you're unavailable, they may leave a note or attempt redelivery. Contact our support team for rescheduling if needed.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Returns & Refunds -->
                <div class="col-lg-12">
                    <h3 class="fw-bold mb-4 mt-4">
                        <i class="fas fa-undo text-primary me-2"></i>Returns & Refunds
                    </h3>
                    <div class="accordion accordion-flush mb-5">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq10">
                                    What's your return policy?
                                </button>
                            </h2>
                            <div id="faq10" class="accordion-collapse collapse show" data-bs-parent="#faqReturns">
                                <div class="accordion-body">
                                    You can return most items within <strong>30 days</strong> of delivery if they're unused, in original packaging, and in resalable condition. Visit our Returns & Refunds Policy page for complete details.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq11">
                                    How long does refund processing take?
                                </button>
                            </h2>
                            <div id="faq11" class="accordion-collapse collapse" data-bs-parent="#faqReturns">
                                <div class="accordion-body">
                                    After we receive and inspect your returned item, refunds typically take <strong>5-7 business days</strong> to appear in your account.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq12">
                                    What if I receive a damaged product?
                                </button>
                            </h2>
                            <div id="faq12" class="accordion-collapse collapse" data-bs-parent="#faqReturns">
                                <div class="accordion-body">
                                    Report damaged products within <strong>48 hours</strong> of delivery with photos as proof. We'll provide a replacement or full refund (including shipping) without needing to return the item.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq13">
                                    Do you charge for returns?
                                </button>
                            </h2>
                            <div id="faq13" class="accordion-collapse collapse" data-bs-parent="#faqReturns">
                                <div class="accordion-body">
                                    For eligible returns, we provide a prepaid return label. If you choose your own courier, return shipping costs are non-refundable. For defective items, return shipping is free.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account & Security -->
                <div class="col-lg-12">
                    <h3 class="fw-bold mb-4 mt-4">
                        <i class="fas fa-lock text-primary me-2"></i>Account & Security
                    </h3>
                    <div class="accordion accordion-flush mb-5">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq14">
                                    Is my personal information secure?
                                </button>
                            </h2>
                            <div id="faq14" class="accordion-collapse collapse show" data-bs-parent="#faqSecurity">
                                <div class="accordion-body">
                                    Yes, we use industry-standard SSL encryption to protect your data. Your payment and personal information are securely transmitted and stored. Visit our Privacy Policy for more details.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq15">
                                    How do I reset my password?
                                </button>
                            </h2>
                            <div id="faq15" class="accordion-collapse collapse" data-bs-parent="#faqSecurity">
                                <div class="accordion-body">
                                    On the login page, click "Forgot Password". Enter your email address, and we'll send you a link to reset your password. The link is valid for 1 hour.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq16">
                                    Can I delete my account?
                                </button>
                            </h2>
                            <div id="faq16" class="accordion-collapse collapse" data-bs-parent="#faqSecurity">
                                <div class="accordion-body">
                                    Yes, you can request account deletion by contacting our support team at support@kalpakonline.co.in. Please note that we'll retain minimal information required by law.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products -->
                <div class="col-lg-12">
                    <h3 class="fw-bold mb-4 mt-4">
                        <i class="fas fa-box text-primary me-2"></i>Products
                    </h3>
                    <div class="accordion accordion-flush mb-5">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq17">
                                    Are your products authentic?
                                </button>
                            </h2>
                            <div id="faq17" class="accordion-collapse collapse show" data-bs-parent="#faqProducts">
                                <div class="accordion-body">
                                    Yes, all products on Kalpak Online are 100% authentic. We source directly from authorized distributors and manufacturers to ensure quality.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq18">
                                    Do products come with warranty?
                                </button>
                            </h2>
                            <div id="faq18" class="accordion-collapse collapse" data-bs-parent="#faqProducts">
                                <div class="accordion-body">
                                    Products come with manufacturer warranty (if applicable). Warranty details are mentioned in the product description. For warranty claims, contact the manufacturer directly or our support team.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq19">
                                    Will I get an invoice with my order?
                                </button>
                            </h2>
                            <div id="faq19" class="accordion-collapse collapse" data-bs-parent="#faqProducts">
                                <div class="accordion-body">
                                    Yes, an invoice is included with every shipment. You'll also receive an email copy of your invoice for your records.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Still Need Help? -->
                <div class="col-lg-12 mt-5">
                    <div class="card bg-light border-0">
                        <div class="card-body text-center py-5">
                            <h4 class="card-title fw-bold mb-3">Didn't find your answer?</h4>
                            <p class="card-text text-muted mb-4">
                                Our customer support team is here to help. Get in touch with us anytime.
                            </p>
                            <a href="{{ route('page.contact') }}" class="btn btn-primary btn-lg">
                                Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // FAQ Search functionality
    document.getElementById('faqSearch').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const faqItems = document.querySelectorAll('.accordion-item');
        
        faqItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(searchTerm) ? 'block' : 'none';
        });
    });
</script>
@endsection
