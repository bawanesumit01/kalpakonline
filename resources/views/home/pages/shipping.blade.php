@extends('home.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Shipping Policy</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-lg-5">
                    <h1 class="mb-4 fw-bold">Shipping Policy</h1>
                    <p class="text-muted mb-4"><em>Last Updated: {{ now()->format('F d, Y') }}</em></p>

                    <h5 class="mt-5 mb-3 fw-bold">1. Delivery Locations</h5>
                    <p>
                        We currently deliver to all major cities and towns across India. Some remote areas may have extended delivery times or may not be serviceable. You can check your delivery address eligibility during checkout.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">2. Delivery Timeline</h5>
                    <ul>
                        <li><strong>Standard Delivery:</strong> 5-7 working days from order placement</li>
                        <li><strong>Expedited Delivery:</strong> Available in select cities (2-3 working days)</li>
                    </ul>
                    <p class="mt-3">
                        <em>Note: Delivery estimates are approximate and may vary based on product availability, location, and unforeseen circumstances like weather or courier delays.</em>
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">3. Shipping Charges</h5>
                    <ul>
                        <li><strong>Free Shipping:</strong> On orders above ₹499</li>
                        <li><strong>Standard Shipping:</strong> ₹40 for orders below ₹499</li>
                    </ul>
                    <p class="mt-3">
                        Shipping charges are calculated at checkout and will be clearly displayed before you confirm your order.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">4. Shipping Address Requirements</h5>
                    <p>
                        To ensure smooth delivery, please provide:
                    </p>
                    <ul>
                        <li>Complete and accurate address with apartment/house number</li>
                        <li>Correct pin code and city name</li>
                        <li>Valid mobile number (for delivery coordination)</li>
                        <li>Email address for order updates</li>
                    </ul>
                    <p class="mt-3">
                        We are not responsible for delivery delays or failed deliveries due to incomplete or incorrect address information.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">5. Order Processing</h5>
                    <p>
                        Your order will be processed and dispatched within 1-2 business days from the date of order confirmation. Once your order is shipped, you will receive a notification with tracking information.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">6. Tracking Your Order</h5>
                    <p>
                        After dispatch, you can track your order through:
                    </p>
                    <ul>
                        <li>Your account dashboard at kalpakonline.co.in</li>
                        <li>Order confirmation email with tracking number</li>
                        <li>SMS updates sent to your registered mobile number</li>
                    </ul>

                    <h5 class="mt-5 mb-3 fw-bold">7. Delivery Attempts</h5>
                    <p>
                        Our delivery partner will attempt to deliver your order at the provided address. If delivery is unsuccessful:
                    </p>
                    <ul>
                        <li>They will leave a delivery notice</li>
                        <li>You will receive an SMS notification</li>
                        <li>Contact us to reschedule delivery</li>
                        <li>After 3 failed attempts, the package will be returned to our warehouse</li>
                    </ul>

                    <h5 class="mt-5 mb-3 fw-bold">8. Delivery Instructions</h5>
                    <p>
                        You can provide special delivery instructions during checkout, such as:
                    </p>
                    <ul>
                        <li>Preferred delivery time window</li>
                        <li>Leave at safe place instructions</li>
                        <li>Alternative recipient details</li>
                        <li>Gate/entrance instructions</li>
                    </ul>

                    <h5 class="mt-5 mb-3 fw-bold">9. Signature on Delivery</h5>
                    <p>
                        For orders above ₹2,000, signature verification may be required upon delivery. This ensures secure delivery and protects both parties.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">10. Loss or Damage During Shipping</h5>
                    <p>
                        Although we take every precaution during shipping, if your order arrives damaged:
                    </p>
                    <ul>
                        <li>Report the damage within <strong>48 hours</strong> of delivery</li>
                        <li>Provide photographic evidence of the damage</li>
                        <li>We will provide a replacement or full refund</li>
                        <li>Replacement shipping is free</li>
                    </ul>

                    <h5 class="mt-5 mb-3 fw-bold">11. Lost Orders</h5>
                    <p>
                        If your order is lost during transit, we will:
                    </p>
                    <ul>
                        <li>File a claim with the courier service</li>
                        <li>Provide a replacement order or full refund</li>
                        <li>Initiate a new shipment at no additional cost</li>
                    </ul>
                    <p class="mt-3">
                        Please report lost orders within <strong>15 days</strong> of the original delivery date.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">12. Weather and Force Majeure</h5>
                    <p>
                        We are not liable for delays or delivery failures caused by unforeseen circumstances including but not limited to:
                    </p>
                    <ul>
                        <li>Natural disasters or extreme weather</li>
                        <li>Government restrictions or lockdowns</li>
                        <li>Courier service disruptions</li>
                        <li>Road blockages or transportation issues</li>
                        <li>Public holidays or strikes</li>
                    </ul>

                    <h5 class="mt-5 mb-3 fw-bold">13. Customs and Import Duties</h5>
                    <p>
                        Currently, we deliver within India only, so customs duties do not apply. If future international shipping is offered, customers will be responsible for any applicable customs charges.
                    </p>

                    <h5 class="mt-5 mb-3 fw-bold">14. Contact Us for Shipping Issues</h5>
                    <p>
                        If you have any questions or concerns about your shipment:
                    </p>
                    <ul>
                        <li><strong>Email:</strong> support@kalpakonline.co.in</li>
                        <li><strong>Phone:</strong> +91-XXXXXXXXXX</li>
                        <li><strong>Hours:</strong> Monday - Friday, 10 AM - 6 PM IST</li>
                    </ul>

                    <h5 class="mt-5 mb-3 fw-bold">15. Changes to Shipping Policy</h5>
                    <p>
                        We reserve the right to update this shipping policy at any time. Changes will be effective immediately upon posting to our website. Your continued use of our services constitutes acceptance of the updated policy.
                    </p>
                </div>
            </div>
    </div>
</div>
@endsection
