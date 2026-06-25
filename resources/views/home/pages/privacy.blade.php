@extends('home.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Privacy Policy</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">
                    <h1 class="mb-4 fw-bold">Privacy Policy</h1>
                    <p class="text-muted mb-4"><em>Last Updated: {{ now()->format('F d, Y') }}</em></p>

                    <h5 class="mt-5 mb-3 fw-bold">1. Introduction</h5>
                    <p>
                        Kalpak Online ("we," "us," "our," or "Company") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our services.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">2. Information We Collect</h5>
                    <p><strong>Personal Information You Provide:</strong></p>
                    <ul>
                        <li>Name, email address, and phone number</li>
                        <li>Delivery address and postal code</li>
                        <li>Payment information (for order processing)</li>
                        <li>Account credentials (username, password)</li>
                        <li>Communication preferences</li>
                        <li>Any other information you choose to provide</li>
                    </ul>
                    <p class="mt-3"><strong>Information Collected Automatically:</strong></p>
                    <ul>
                        <li>Browser type and operating system</li>
                        <li>IP address and geographic location</li>
                        <li>Pages visited and time spent on each page</li>
                        <li>Referral source and links clicked</li>
                        <li>Cookies and similar tracking technologies</li>
                    </ul>

                    <h5 class="mt-5 mb-3 fw-bold">3. How We Use Your Information</h5>
                    <p>We use the information we collect for the following purposes:</p>
                    <ul>
                        <li>Processing and fulfilling your orders</li>
                        <li>Sending order confirmations and delivery updates</li>
                        <li>Responding to customer inquiries and support requests</li>
                        <li>Improving our website, products, and services</li>
                        <li>Personalizing your shopping experience</li>
                        <li>Sending promotional emails and newsletters (with your consent)</li>
                        <li>Detecting and preventing fraudulent activities</li>
                        <li>Complying with legal obligations</li>
                    </ul>

                    <h5 class="mt-5 mb-3 fw-bold">4. How We Protect Your Information</h5>
                    <p>
                        We implement administrative, technical, and physical security measures to protect your personal information. However, no security system is impenetrable. We cannot guarantee absolute security of your data.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">5. Sharing Your Information</h5>
                    <p>
                        We do not sell, trade, or rent your personal information to third parties. We may share your information with:
                    </p>
                    <ul>
                        <li>Delivery partners for order fulfillment</li>
                        <li>Payment processors to handle transactions</li>
                        <li>Customer support platforms</li>
                        <li>Legal authorities if required by law</li>
                        <li>Service providers under confidentiality agreements</li>
                    </ul>

                    <h5 class="mt-5 mb-3 fw-bold">6. Cookies and Tracking Technologies</h5>
                    <p>
                        We use cookies to enhance your browsing experience. You can control cookie settings through your browser preferences. Disabling cookies may limit certain website functionality.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">7. Your Rights</h5>
                    <p>You have the right to:</p>
                    <ul>
                        <li>Access the personal information we hold about you</li>
                        <li>Request correction of inaccurate data</li>
                        <li>Request deletion of your information</li>
                        <li>Opt-out of promotional communications</li>
                        <li>Withdraw consent for data processing</li>
                    </ul>

                    <h5 class="mt-5 mb-3 fw-bold">8. Third-Party Links</h5>
                    <p>
                        Our website may contain links to third-party websites. We are not responsible for the privacy practices of external websites. We recommend reviewing their privacy policies.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">9. Children's Privacy</h5>
                    <p>
                        Our services are not directed to children under 18 years of age. We do not knowingly collect personal information from children. If we learn we have collected data from a child, we will take steps to delete it promptly.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">10. Policy Changes</h5>
                    <p>
                        We may update this Privacy Policy periodically. We will notify you of significant changes via email or prominent notice on our website. Your continued use of our services after changes constitutes your acceptance of the updated policy.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">11. Contact Us</h5>
                    <p>
                        If you have questions about this Privacy Policy or our privacy practices, please contact us:
                    </p>
                    <ul>
                        <li><strong>Email:</strong> support@kalpakonline.co.in</li>
                        <li><strong>Phone:</strong> +91-XXXXXXXXXX</li>
                        <li><strong>Address:</strong> Kalpak Online, [Your Address], India</li>
                    </ul>
                </div>
            </div>
    </div>
</div>
@endsection
