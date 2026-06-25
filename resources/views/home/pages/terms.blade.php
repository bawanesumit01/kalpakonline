@extends('home.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Terms & Conditions</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">
                    <h1 class="mb-4 fw-bold">Terms & Conditions</h1>
                    <p class="text-muted mb-4"><em>Last Updated: {{ now()->format('F d, Y') }}</em></p>

                    <h5 class="mt-5 mb-3 fw-bold">1. Acceptance of Terms</h5>
                    <p>
                        By accessing and using the Kalpak Online website (\"Service\"), you agree to be bound by these Terms & Conditions. If you do not agree to these terms, please refrain from using our services.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">2. Use License</h5>
                    <p>
                        We grant you a limited, revocable, non-exclusive, and non-transferable license to access and use our website for personal, non-commercial purposes. You agree not to:
                    </p>
                    <ul>
                        <li>Reproduce, duplicate, or copy content from our website without permission</li>
                        <li>Modify, adapt, or translate our website content</li>
                        <li>Reverse engineer or attempt to gain unauthorized access</li>
                        <li>Use our website for any illegal or unauthorized purpose</li>
                        <li>Transmit harmful code, viruses, or malware</li>
                        <li>Engage in any behavior that restricts or inhibits use of the website</li>
                    </ul>

                    <h5 class="mt-5 mb-3 fw-bold">3. Product Information</h5>
                    <p>
                        All product descriptions, pricing, and availability information on our website are subject to change without notice. We strive to provide accurate information but do not guarantee that all product details are complete or error-free.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">4. Order Placement & Acceptance</h5>
                    <p>
                        When you place an order, you are making an offer to purchase. We reserve the right to accept or reject any order at our discretion. An order confirmation email does not constitute acceptance of your order. Acceptance occurs when we dispatch your order.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">5. Pricing and Payment</h5>
                    <ul>
                        <li>All prices are in Indian Rupees (₹) and include applicable taxes.</li>
                        <li>Prices are subject to change at any time without prior notice.</li>
                        <li>We accept Cash on Delivery payment method.</li>
                        <li>You must pay the full amount at the time of delivery.</li>
                        <li>If payment is not received, we reserve the right to cancel the delivery.</li>
                    </ul>

                    <h5 class="mt-5 mb-3 fw-bold">6. Shipping & Delivery</h5>
                    <ul>
                        <li>We deliver to addresses within India only.</li>
                        <li>Estimated delivery time is 5-7 working days from order placement.</li>
                        <li>Delivery times are estimates and not guaranteed.</li>
                        <li>We are not liable for delays due to courier partners or unforeseen circumstances.</li>
                        <li>Risk of loss passes to you upon delivery to your address.</li>
                    </ul>

                    <h5 class="mt-5 mb-3 fw-bold">7. Returns & Refunds</h5>
                    <p>
                        Please refer to our Returns & Refunds Policy for detailed information about returning products and obtaining refunds.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">8. Warranty Disclaimer</h5>
                    <p>
                        Our website and all products are provided \"as-is\" without any warranties. We disclaim all express, implied, and statutory warranties including merchantability, fitness for a particular purpose, and non-infringement.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">9. Limitation of Liability</h5>
                    <p>
                        To the maximum extent permitted by law, Kalpak Online shall not be liable for any indirect, incidental, special, consequential, or punitive damages arising from your use or inability to use the website or products.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">10. Intellectual Property Rights</h5>
                    <p>
                        All content on our website, including text, graphics, logos, images, and software, is the exclusive property of Kalpak Online or licensed to us. Unauthorized use is prohibited.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">11. User Accounts</h5>
                    <ul>
                        <li>You are responsible for maintaining the confidentiality of your account credentials.</li>
                        <li>You agree to notify us immediately of any unauthorized access to your account.</li>
                        <li>You are liable for all activities conducted under your account.</li>
                        <li>We reserve the right to suspend or terminate accounts that violate these terms.</li>
                    </ul>

                    <h5 class="mt-5 mb-3 fw-bold">12. Third-Party Content</h5>
                    <p>
                        Our website may contain links to third-party websites and services. We are not responsible for the content, accuracy, or practices of external websites. Use of third-party services is at your own risk.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">13. Governing Law</h5>
                    <p>
                        These Terms & Conditions are governed by and construed in accordance with the laws of India. You agree to submit to the exclusive jurisdiction of courts located in India.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">14. Amendments</h5>
                    <p>
                        We may update these Terms & Conditions at any time. Changes become effective immediately upon posting. Your continued use of the website constitutes acceptance of updated terms.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">15. Contact Us</h5>
                    <p>
                        If you have questions about these Terms & Conditions, please contact us at support@kalpakonline.co.in
                    </p>
                </div>
            </div>
    </div>
</div>
@endsection
