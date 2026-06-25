@extends('home.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">About Us</li>
                </ol>
            </nav>

            <!-- Page Header -->
            <div class="mb-5">
                <h1 class="display-5 fw-bold mb-3">About Kalpak Online</h1>
                <p class="lead text-muted">Your trusted destination for quality products and exceptional customer service.</p>
            </div>

            <!-- Our Story -->
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-body p-4 p-lg-5">
                    <h2 class="card-title mb-3 fw-bold">Our Story</h2>
                    <p class="card-text mb-3">
                        Kalpak Online was founded with a simple mission: to bring quality products directly to your doorstep at competitive prices. Starting as a small venture, we've grown into a trusted online marketplace serving thousands of happy customers across India.
                    </p>
                    <p class="card-text mb-3">
                        We believe in transparency, reliability, and customer-first principles. Every product on our platform is carefully curated to ensure quality and value for money.
                    </p>
                    <p class="card-text">
                        Today, Kalpak Online continues to innovate and expand, bringing more diverse products and better experiences to our valued customers.
                    </p>
                </div>
            </div>

            <!-- Our Values -->
            <div class="mb-5">
                <h2 class="mb-4 fw-bold">Our Core Values</h2>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="mb-3">
                                    <span style="font-size: 2.5rem;">✓</span>
                                </div>
                                <h5 class="card-title fw-bold">Quality Assurance</h5>
                                <p class="card-text text-muted">
                                    We guarantee authentic, high-quality products that meet international standards.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="mb-3">
                                    <span style="font-size: 2.5rem;">🤝</span>
                                </div>
                                <h5 class="card-title fw-bold">Customer First</h5>
                                <p class="card-text text-muted">
                                    Your satisfaction is our priority. We listen, adapt, and continuously improve.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="mb-3">
                                    <span style="font-size: 2.5rem;">🚀</span>
                                </div>
                                <h5 class="card-title fw-bold">Innovation</h5>
                                <p class="card-text text-muted">
                                    We invest in technology to provide seamless shopping experiences.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="mb-3">
                                    <span style="font-size: 2.5rem;">💚</span>
                                </div>
                                <h5 class="card-title fw-bold">Responsibility</h5>
                                <p class="card-text text-muted">
                                    We operate responsibly towards our community, environment, and society.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Why Choose Us -->
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-body p-4 p-lg-5">
                    <h2 class="card-title mb-4 fw-bold">Why Choose Kalpak Online?</h2>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <strong>🛒 Wide Selection:</strong> Thousands of products across multiple categories.
                        </li>
                        <li class="mb-3">
                            <strong>💰 Competitive Prices:</strong> Best value for money with regular discounts and promotions.
                        </li>
                        <li class="mb-3">
                            <strong>📦 Fast Delivery:</strong> Reliable shipping to your doorstep within 5-7 working days.
                        </li>
                        <li class="mb-3">
                            <strong>🔒 Secure Transactions:</strong> Your payment information is protected with industry-standard security.
                        </li>
                        <li class="mb-3">
                            <strong>💬 24/7 Customer Support:</strong> We're here to help whenever you need us.
                        </li>
                        <li class="mb-3">
                            <strong>✅ Hassle-Free Returns:</strong> Easy return and refund process within 30 days.
                        </li>
                        <li>
                            <strong>🎁 Loyalty Rewards:</strong> Earn points on every purchase and redeem them for discounts.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Contact CTA -->
            <div class="card bg-light border-0 text-center p-5 mb-5">
                <h3 class="mb-3">Have Questions?</h3>
                <p class="text-muted mb-4">Get in touch with our customer service team. We're here to help!</p>
                <a href="{{ route('page.contact') }}" class="btn btn-primary btn-lg">Contact Us</a>
            </div>
    </div>
</div>
@endsection
