@extends('home.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Contact Us</li>
                </ol>
            </nav>

            <div class="mb-5">
                <h1 class="display-5 fw-bold mb-3">Contact Us</h1>
                <p class="lead text-muted">We'd love to hear from you. Get in touch with our customer support team.</p>
            </div>

            <div class="row g-4 mb-5">
                <!-- Contact Information -->
                <div class="col-lg-5">
                    <h3 class="mb-4 fw-bold">Get In Touch</h3>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="card-title fw-bold mb-2">📧 Email Us</h6>
                            <p class="card-text text-muted mb-2">
                                <a href="mailto:support@kalpakonline.co.in" class="text-decoration-none">
                                    Kalpakudyoginfo@gmail.com
                                </a>
                            </p>
                            <p class="card-text small text-muted">We typically reply within 24 hours.</p>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="card-title fw-bold mb-2">📞 Call Us</h6>
                            <p class="card-text text-muted mb-2">
                                <a href="tel:+918669988077" class="text-decoration-none">
                                    +91-8669988077
                                </a> , <a href="tel:+918669988075" class="text-decoration-none">
                                    +91-8669988075
                                </a>
                            </p>
                            <p class="card-text small text-muted">Monday - Friday, 10 AM to 6 PM IST</p>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="card-title fw-bold mb-2">📍 Visit Us</h6>
                            <p class="card-text text-muted mb-2">
                                Kalpak Online<br>
                                Plot number 4, Sham nagar,<br> sector 3, besa pipla road, <br>pipla - 440034.
                            </p>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title fw-bold mb-2\">🕐 Business Hours</h6>
                            <p class="card-text text-muted mb-0\">
                                <strong>Monday - Friday:</strong> 10 AM - 6 PM IST<br>
                                <strong>Saturday:</strong> 11 AM - 4 PM IST<br>
                                <strong>Sunday:</strong> Closed<br>
                                <strong>Holidays:</strong> Closed
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="card-title fw-bold mb-4">Send us a Message</h3>

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Please fix the following errors:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('page.contact') }}" method="POST" novalidate>
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">Full Name *</label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        id="name" 
                                        name="name" 
                                        value="{{ old('name') }}"
                                        required
                                    >
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold">Email Address *</label>
                                    <input 
                                        type="email" 
                                        class="form-control @error('email') is-invalid @enderror" 
                                        id="email" 
                                        name="email" 
                                        value="{{ old('email') }}"
                                        required
                                    >
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-bold">Phone Number</label>
                                    <input 
                                        type="tel" 
                                        class="form-control @error('phone') is-invalid @enderror" 
                                        id="phone" 
                                        name="phone" 
                                        value="{{ old('phone') }}"
                                    >
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="subject" class="form-label fw-bold">Subject *</label>
                                    <select 
                                        class="form-select @error('subject') is-invalid @enderror" 
                                        id="subject" 
                                        name="subject"
                                        required
                                    >
                                        <option value="">-- Select a subject --</option>
                                        <option value="general" {{ old('subject') === 'general' ? 'selected' : '' }}>General Inquiry</option>
                                        <option value="order" {{ old('subject') === 'order' ? 'selected' : '' }}>Order Related</option>
                                        <option value="product" {{ old('subject') === 'product' ? 'selected' : '' }}>Product Question</option>
                                        <option value="feedback" {{ old('subject') === 'feedback' ? 'selected' : '' }}>Feedback</option>
                                        <option value="complaint" {{ old('subject') === 'complaint' ? 'selected' : '' }}>Complaint</option>
                                        <option value="other" {{ old('subject') === 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="message" class="form-label fw-bold">Message *</label>
                                    <textarea 
                                        class="form-control @error('message') is-invalid @enderror" 
                                        id="message" 
                                        name="message" 
                                        rows="6" 
                                        required
                                    >{{ old('message') }}</textarea>
                                    <small class="text-muted d-block mt-1">Max 1000 characters</small>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input 
                                        type="checkbox" 
                                        class="form-check-input @error('agree') is-invalid @enderror" 
                                        id="agree" 
                                        name="agree"
                                        required
                                    >
                                    <label class="form-check-label" for="agree">
                                        I agree to the privacy policy and terms of service
                                    </label>
                                    @error('agree')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="mt-5 pt-5 border-top">
                <h3 class="fw-bold mb-4">Frequently Asked Questions</h3>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                What is your response time?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We typically respond to all inquiries within 24 hours during business hours. For urgent matters, please call us directly.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                How can I track my order?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can track your order through your account dashboard or via the tracking link sent in your order confirmation email.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                What's your return policy?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We offer hassle-free returns within 30 days of delivery. Please visit our Returns & Refunds Policy page for detailed information.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection
