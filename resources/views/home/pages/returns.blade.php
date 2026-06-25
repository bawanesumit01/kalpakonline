@extends('home.app')

@section('content')
<div class=\"container py-5\">
    <div class=\"row\">
        <div class=\"col-lg-12\">
            <!-- Breadcrumb -->
            <nav aria-label=\"breadcrumb\" class=\"mb-4\">
                <ol class=\"breadcrumb\">
                    <li class=\"breadcrumb-item\"><a href=\"{{ route('home.index') }}\">Home</a></li>
                    <li class=\"breadcrumb-item active\">Returns & Refunds</li>
                </ol>
            </nav>

            <div class=\"card border-0 shadow-sm\">
                <div class=\"card-body p-4 p-lg-5\">
                    <h1 class=\"mb-4 fw-bold\">Returns & Refunds Policy</h1>
                    <p class=\"text-muted mb-4\"><em>Last Updated: {{ now()->format('F d, Y') }}</em></p>

                    <h5 class=\"mt-5 mb-3 fw-bold\">1. Return Period</h5>
                    <p>
                        You have up to <strong>30 days</strong> from the date of delivery to initiate a return request. Items returned after 30 days will not be accepted unless the product is defective.
                    </p>

                    <h5 class=\"mt-5 mb-3 fw-bold\">2. Returnable Products</h5>
                    <p>
                        Most products are returnable. However, the following items cannot be returned:
                    </p>
                    <ul>
                        <li>Personalized or customized items</li>
                        <li>Items marked as \"Non-Returnable\" on the product page</li>
                        <li>Perishable or consumable items (food, cosmetics, etc.)</li>\n                        <li>Items that show signs of wear or use beyond normal testing</li>
                        <li>Items with missing original tags, packaging, or accessories</li>
                        <li>Items damaged due to customer misuse or negligence</li>
                    </ul>

                    <h5 class=\"mt-5 mb-3 fw-bold\">3. Return Conditions</h5>
                    <p>
                        To be eligible for return, the product must meet the following conditions:
                    </p>
                    <ul>
                        <li>Product should be unused and in original condition</li>
                        <li>All original packaging and accessories should be included</li>
                        <li>Original tags and labels should be intact</li>
                        <li>No signs of wear, damage, or alteration</li>
                    </ul>

                    <h5 class=\"mt-5 mb-3 fw-bold\">4. How to Return</h5>
                    <p>
                        To initiate a return:
                    </p>
                    <ol>
                        <li>Log in to your account on our website</li>
                        <li>Navigate to \"My Orders\" and select the order</li>
                        <li>Click \"Return Item\" and select the reason for return</li>
                        <li>Confirm the return request</li>
                        <li>A return shipping label will be generated (for returns within 7 days)</li>
                        <li>Pack the product securely in original packaging</li>
                        <li>Use the provided shipping label and hand over to courier</li>
                        <li>Keep the tracking number for reference</li>
                    </ol>

                    <h5 class=\"mt-5 mb-3 fw-bold\">5. Return Shipping</h5>
                    <ul>
                        <li><strong>Free Return Shipping:</strong> Provided for defective or wrong items</li>
                        <li><strong>Paid Return Shipping:</strong> Customer bears return shipping cost (₹40-100) for changed mind returns</li>
                        <li>Return shipping charges will be deducted from refund amount</li>
                    </ul>

                    <h5 class=\"mt-5 mb-3 fw-bold\">6. Refund Process</h5>
                    <p>
                        Once we receive your returned item:
                    </p>
                    <ol>
                        <li>We will inspect the product for defects or damage (2-3 business days)</li>
                        <li>If the product meets return criteria, refund is approved</li>
                        <li>Refund is processed to your original payment method</li>
                        <li>Refund amount = Product price - Return shipping charges (if applicable)</li>
                    </ol>
                    <p class=\"mt-3\">
                        <em>Note: Refunds for Cash on Delivery orders will be processed within 5-7 business days to your bank account provided during return.</em>
                    </p>

                    <h5 class=\"mt-5 mb-3 fw-bold\">7. Refund Timeline</h5>
                    <ul>
                        <li>Return approval: 2-3 business days after receiving item</li>
                        <li>Refund processing: 5-7 business days after approval</li>
                        <li>Bank credit: May take an additional 2-3 days depending on your bank</li>
                    </ul>
                    <p class=\"mt-3\">
                        <em>Total refund time: 10-15 business days</em>
                    </p>

                    <h5 class=\"mt-5 mb-3 fw-bold\">8. Defective or Damaged Products</h5>
                    <p>
                        If your product arrives damaged or defective:
                    </p>
                    <ul>
                        <li>Report within <strong>48 hours</strong> of delivery with photos</li>
                        <li>Free return shipping will be provided</li>
                        <li>We will replace the product or process a full refund</li>
                        <li>No deduction for return shipping charges</li>
                    </ul>

                    <h5 class=\"mt-5 mb-3 fw-bold\">9. Wrong Item Received</h5>
                    <p>
                        If you received a wrong item:
                    </p>
                    <ul>
                        <li>Report within 7 days of delivery</li>
                        <li>Free return shipping will be arranged</li>
                        <li>Correct item will be shipped immediately</li>
                        <li>No shipping charges will be deducted from refund</li>
                    </ul>

                    <h5 class=\"mt-5 mb-3 fw-bold\">10. Cancellation of Return Request</h5>
                    <p>
                        You can cancel a return request before the item is picked up by contacting us. Once the item is picked up, cancellation cannot be processed.
                    </p>

                    <h5 class=\"mt-5 mb-3 fw-bold\">11. Partial Returns</h5>
                    <p>
                        If you have ordered multiple items in one order and wish to return only some items:
                    </p>
                    <ul>
                        <li>You can return individual items separately</li>
                        <li>Each return will be processed independently</li>
                        <li>Return shipping charges will apply per return (if applicable)</li>
                    </ul>

                    <h5 class=\"mt-5 mb-3 fw-bold\">12. Non-Refundable Items</h5>
                    <p>
                        The following items are non-refundable:
                    </p>
                    <ul>
                        <li>Gift cards and vouchers</li>
                        <li>Downloaded digital products</li>
                        <li>Items explicitly marked as \"Final Sale\"</li>
                    </ul>

                    <h5 class=\"mt-5 mb-3 fw-bold\">13. Refund Disputes</h5>
                    <p>
                        If there is a dispute regarding a return or refund:
                    </p>
                    <ul>
                        <li>Contact our customer support team with documentation</li>
                        <li>We will investigate and resolve within 7 business days</li>
                        <li>Our decision will be final and binding</li>
                    </ul>

                    <h5 class=\"mt-5 mb-3 fw-bold\">14. Contact Us for Returns</h5>
                    <p>
                        For return-related queries or support:
                    </p>
                    <ul>
                        <li><strong>Email:</strong> support@kalpakonline.co.in</li>
                        <li><strong>Phone:</strong> +91-XXXXXXXXXX</li>
                        <li><strong>Hours:</strong> Monday - Friday, 9 AM - 6 PM IST</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
