@extends('home.app')

@section('content')
<section class="order-success-section">
    <div class="container-lg">
        <!-- Success Header -->
        <div class="success-header" data-aos="fade-down">
            <div class="success-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <h1 class="success-title">Order Confirmed!</h1>
            <p class="success-subtitle">Thank you for your order. We'll keep you updated with shipping status.</p>
        </div>

        <div class="row g-4 mt-4">
            <!-- Left Column: Order Details -->
            <div class="col-lg-8">
                <!-- Order Number Card -->
                <div class="order-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="order-card-header">
                        <h5>Order Details</h5>
                        <span class="order-badge-success">
                            <i class="bi bi-check"></i>
                            {{ $order->getStatusLabelAttribute() }}
                        </span>
                    </div>
                    <div class="order-card-body">
                        <div class="order-number-box">
                            <label>Order Number</label>
                            <div class="order-number-display">
                                {{ $order->order_number }}
                                <button type="button" class="btn-copy-order" onclick="copyOrderNumber()">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                        </div>

                        <div class="order-info-grid">
                            <div class="order-info-item">
                                <label>Order Date</label>
                                <p>{{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                            <div class="order-info-item">
                                <label>Payment Method</label>
                                <p>
                                    @switch($order->payment_method)
                                        @case('cod')
                                            Cash on Delivery
                                            @break
                                        @case('online')
                                            Online Payment
                                            @break
                                        @case('wallet')
                                            Digital Wallet
                                            @break
                                    @endswitch
                                </p>
                            </div>
                            <div class="order-info-item">
                                <label>Status</label>
                                <p>{{ $order->getStatusLabelAttribute() }}</p>
                            </div>
                            <div class="order-info-item">
                                <label>Total Amount</label>
                                <p class="amount">₹ {{ number_format($order->total, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items Card -->
                <div class="order-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="order-card-header">
                        <h5>Order Items ({{ $order->items->count() }})</h5>
                    </div>
                    <div class="order-card-body">
                        <div class="order-items-list">
                            @foreach($order->items as $item)
                            <div class="order-item-row">
                                <div class="order-item-image">
                                    <img src="{{ asset('/' . $item->product->main_image) }}" 
                                         alt="{{ $item->product->product_name }}">
                                </div>
                                <div class="order-item-info">
                                    <h6 class="item-name">{{ $item->product->product_name }}</h6>
                                    <p class="item-details">
                                        Qty: <span>{{ $item->quantity }}</span> × 
                                        ₹<span>{{ number_format($item->price, 2) }}</span>
                                    </p>
                                </div>
                                <div class="order-item-price">
                                    ₹ {{ number_format($item->subtotal, 2) }}
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <hr class="my-3">

                        <!-- Order Summary -->
                        <div class="order-summary-box">
                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span>₹ {{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="summary-row">
                                <span>Shipping</span>
                                <span>
                                    @if($order->shipping == 0)
                                        <span class="badge bg-success">FREE</span>
                                    @else
                                        ₹ {{ number_format($order->shipping, 2) }}
                                    @endif
                                </span>
                            </div>
                            <div class="summary-row">
                                <span>Tax (GST)</span>
                                <span>₹ {{ number_format($order->tax, 2) }}</span>
                            </div>
                            @if($order->discount > 0)
                            <div class="summary-row text-success">
                                <span>Discount</span>
                                <span>-₹ {{ number_format($order->discount, 2) }}</span>
                            </div>
                            @endif
                            <div class="summary-row total">
                                <span>Total</span>
                                <span>₹ {{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address Card -->
                <div class="order-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="order-card-header">
                        <h5>Shipping Address</h5>
                    </div>
                    <div class="order-card-body">
                        <div class="address-info">
                            <p class="address-name">
                                <strong>{{ $order->name }}</strong>
                            </p>
                            <p class="address-text">{{ $order->address }}</p>
                            @if($order->address_line2)
                            <p class="address-text">{{ $order->address_line2 }}</p>
                            @endif
                            <p class="address-text">
                                {{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}
                            </p>
                            <p class="address-text">{{ $order->country }}</p>
                            <hr class="my-3">
                            <p class="address-contact">
                                <i class="bi bi-telephone"></i> {{ $order->phone }}
                            </p>
                            <p class="address-contact">
                                <i class="bi bi-envelope"></i> {{ $order->email }}
                            </p>
                        </div>
                    </div>
                </div>

                @if($order->order_notes)
                <!-- Order Notes Card -->
                <div class="order-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="order-card-header">
                        <h5>Special Instructions</h5>
                    </div>
                    <div class="order-card-body">
                        <p class="order-notes">{{ $order->order_notes }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column: What's Next -->
            <div class="col-lg-4">
                <div class="whats-next-section" data-aos="fade-up" data-aos-delay="200">
                    <h5 class="section-title">What's Next?</h5>

                    <!-- Step 1 -->
                    <div class="next-step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h6>Order Confirmation</h6>
                            <p>Check your email for order confirmation and receipt.</p>
                        </div>
                        <div class="step-check">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="next-step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h6>Order Processing</h6>
                            <p>We're preparing your order for shipment.</p>
                        </div>
                        <div class="step-check">
                            <i class="bi bi-circle"></i>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="next-step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h6>Shipment</h6>
                            <p>Your package will be shipped soon with tracking details.</p>
                        </div>
                        <div class="step-check">
                            <i class="bi bi-circle"></i>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="next-step">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h6>Delivery</h6>
                            <p>Receive your order at your doorstep.</p>
                        </div>
                        <div class="step-check">
                            <i class="bi bi-circle"></i>
                        </div>
                    </div>

                    <!-- Help Box -->
                    <div class="help-box">
                        <h6><i class="bi bi-question-circle"></i> Need Help?</h6>
                        <p>If you have any questions, feel free to contact us.</p>
                        <div class="help-links">
                            <a href="#" class="help-link">
                                <i class="bi bi-chat"></i> Chat Support
                            </a>
                            <a href="#" class="help-link">
                                <i class="bi bi-telephone"></i> Call Us
                            </a>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="{{ route('home.index') }}" class="btn-continue-shopping">
                            <i class="bi bi-arrow-left"></i>
                            Continue Shopping
                        </a>
                        <a href="#" class="btn-print-order">
                            <i class="bi bi-printer"></i>
                            Print Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.order-success-section {
    padding: 60px 0;
    background: var(--bg-light, #F9FAFB);
    min-height: 100vh;
}

.success-header {
    text-align: center;
    margin-bottom: 48px;
}

.success-icon {
    width: 120px;
    height: 120px;
    margin: 0 auto 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #10B981 0%, #34D399 100%);
    border-radius: 50%;
    font-size: 60px;
    color: white;
    animation: scaleIn 0.6s ease-out;
}

@keyframes scaleIn {
    from {
        transform: scale(0);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.success-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--text-dark, #1F2937);
    margin-bottom: 12px;
}

.success-subtitle {
    font-size: 1.125rem;
    color: var(--text-gray, #6B7280);
}

.order-card {
    background: white;
    border-radius: 16px;
    border: 1px solid var(--border-color, #E5E7EB);
    margin-bottom: 24px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.order-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.order-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    background: var(--bg-light, #F9FAFB);
    border-bottom: 1px solid var(--border-color, #E5E7EB);
}

.order-card-header h5 {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text-dark, #1F2937);
    margin: 0;
}

.order-badge-success {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(16, 185, 129, 0.1);
    color: #10B981;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
}

.order-card-body {
    padding: 24px;
}

.order-number-box {
    margin-bottom: 24px;
}

.order-number-box label {
    display: block;
    font-weight: 600;
    color: var(--text-gray, #6B7280);
    margin-bottom: 8px;
    font-size: 14px;
}

.order-number-display {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px;
    background: var(--bg-light, #F9FAFB);
    border: 2px solid var(--border-color, #E5E7EB);
    border-radius: 10px;
    font-weight: 700;
    font-size: 18px;
    color: var(--text-dark, #1F2937);
}

.btn-copy-order {
    background: transparent;
    border: none;
    cursor: pointer;
    color: var(--primary-color, #4F46E5);
    font-size: 18px;
    transition: all 0.3s ease;
}

.btn-copy-order:hover {
    transform: scale(1.1);
}

.order-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 24px;
}

.order-info-item label {
    display: block;
    font-weight: 600;
    color: var(--text-gray, #6B7280);
    margin-bottom: 8px;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.order-info-item p {
    font-size: 16px;
    color: var(--text-dark, #1F2937);
    margin: 0;
}

.order-info-item p.amount {
    font-weight: 700;
    color: var(--primary-color, #4F46E5);
    font-size: 20px;
}

.order-items-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.order-item-row {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    background: var(--bg-light, #F9FAFB);
    border-radius: 10px;
}

.order-item-image {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    overflow: hidden;
    flex-shrink: 0;
}

.order-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.order-item-info {
    flex: 1;
}

.item-name {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-dark, #1F2937);
    margin: 0 0 8px 0;
}

.item-details {
    font-size: 13px;
    color: var(--text-gray, #6B7280);
    margin: 0;
}

.order-item-price {
    font-weight: 700;
    font-size: 16px;
    color: var(--text-dark, #1F2937);
    white-space: nowrap;
}

.order-summary-box {
    background: var(--bg-light, #F9FAFB);
    padding: 16px;
    border-radius: 10px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    font-size: 14px;
}

.summary-row span:first-child {
    color: var(--text-gray, #6B7280);
}

.summary-row span:last-child {
    color: var(--text-dark, #1F2937);
    font-weight: 600;
}

.summary-row.total {
    border-top: 2px solid var(--border-color, #E5E7EB);
    padding-top: 12px;
    margin-top: 12px;
    font-size: 16px;
    font-weight: 700;
}

.address-info {
    color: var(--text-dark, #1F2937);
}

.address-name {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 12px;
}

.address-text {
    font-size: 15px;
    line-height: 1.6;
    margin: 8px 0;
    color: var(--text-gray, #6B7280);
}

.address-contact {
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 8px 0;
}

.whats-next-section {
    background: white;
    border-radius: 16px;
    border: 1px solid var(--border-color, #E5E7EB);
    padding: 24px;
    height: fit-content;
    position: sticky;
    top: 20px;
}

.section-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text-dark, #1F2937);
    margin-bottom: 24px;
}

.next-step {
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
    position: relative;
}

.next-step::before {
    content: '';
    position: absolute;
    left: 18px;
    top: 60px;
    width: 2px;
    height: calc(100% - 20px);
    background: var(--border-color, #E5E7EB);
}

.next-step:last-of-type::before {
    display: none;
}

.step-number {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-color, #4F46E5);
    color: white;
    border-radius: 50%;
    font-weight: 700;
    font-size: 14px;
    flex-shrink: 0;
    z-index: 1;
}

.step-content h6 {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-dark, #1F2937);
    margin: 0 0 4px 0;
}

.step-content p {
    font-size: 13px;
    color: var(--text-gray, #6B7280);
    margin: 0;
}

.step-check {
    position: absolute;
    right: 0;
    top: -2px;
    font-size: 18px;
    color: var(--text-light, #9CA3AF);
}

.help-box {
    background: var(--bg-light, #F9FAFB);
    border: 1px solid var(--border-color, #E5E7EB);
    border-radius: 10px;
    padding: 16px;
    margin-bottom: 20px;
}

.help-box h6 {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-dark, #1F2937);
    margin: 0 0 8px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.help-box p {
    font-size: 13px;
    color: var(--text-gray, #6B7280);
    margin: 0 0 12px 0;
}

.help-links {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.help-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: white;
    border: 1px solid var(--border-color, #E5E7EB);
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    color: var(--primary-color, #4F46E5);
    text-decoration: none;
    transition: all 0.3s ease;
}

.help-link:hover {
    background: rgba(79, 70, 229, 0.05);
    border-color: var(--primary-color, #4F46E5);
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.btn-continue-shopping,
.btn-print-order {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 24px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-continue-shopping {
    background: var(--primary-color, #4F46E5);
    color: white;
}

.btn-continue-shopping:hover {
    background: var(--primary-dark, #4338CA);
}

.btn-print-order {
    background: white;
    color: var(--primary-color, #4F46E5);
    border: 2px solid var(--primary-color, #4F46E5);
}

.btn-print-order:hover {
    background: rgba(79, 70, 229, 0.05);
}

@media (max-width: 768px) {
    .order-success-section {
        padding: 40px 0;
    }

    .success-title {
        font-size: 1.875rem;
    }

    .whats-next-section {
        position: static;
        margin-top: 24px;
    }

    .order-info-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
}
</style>

@push('scripts')
<script>
function copyOrderNumber() {
    const orderNumber = document.querySelector('.order-number-display').textContent.trim().split('\n')[0];
    navigator.clipboard.writeText(orderNumber).then(() => {
        alert('Order number copied to clipboard!');
    });
}

document.querySelector('.btn-print-order').addEventListener('click', function(e) {
    e.preventDefault();
    window.print();
});
</script>
@endpush
@endsection
