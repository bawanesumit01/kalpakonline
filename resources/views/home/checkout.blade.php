@extends('home.app')

@section('content')
<section class="checkout-section-modern">
    <div class="container-lg">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cart.view') }}">Cart</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>

        @if($cartItems->isEmpty())
            <div class="empty-cart-checkout">
                <div class="empty-cart-icon">
                    <i class="bi bi-cart-x"></i>
                </div>
                <h4>Your cart is empty</h4>
                <p>Add items to your cart before proceeding to checkout</p>
                <a href="{{ route('home.index') }}" class="btn-primary-modern">
                    <i class="bi bi-arrow-left"></i>
                    Continue Shopping
                </a>
            </div>
        @else
        <!-- Display Error Messages -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5 class="alert-heading">
                    <i class="bi bi-exclamation-circle"></i>
                    Oops! There are some errors:
                </h5>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            <div class="row g-4">
                <!-- Left Column: Checkout Form -->
                <div class="col-lg-7">
                    <!-- Customer Information -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <div class="step-number">1</div>
                            <h5 class="checkout-card-title">Customer Information</h5>
                        </div>
                        <div class="checkout-card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-modern">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control-modern @error('name') is-invalid @enderror" 
                                           name="name" 
                                           value="{{ old('name', auth()->user()->name ?? '') }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-modern">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control-modern @error('email') is-invalid @enderror" 
                                           name="email" 
                                           value="{{ old('email', auth()->user()->email ?? '') }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-modern">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" 
                                           class="form-control-modern @error('phone') is-invalid @enderror" 
                                           name="phone" 
                                           value="{{ old('phone') }}" 
                                           placeholder="+91 XXXXX XXXXX"
                                           required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <div class="step-number">2</div>
                            <h5 class="checkout-card-title">Shipping Address</h5>
                        </div>
                        <div class="checkout-card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label-modern">Street Address <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control-modern @error('address') is-invalid @enderror" 
                                           name="address" 
                                           value="{{ old('address') }}"
                                           placeholder="House no., Building name, Street"
                                           required>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label-modern">Apartment, Suite, etc. (Optional)</label>
                                    <input type="text" 
                                           class="form-control-modern" 
                                           name="address_line2" 
                                           value="{{ old('address_line2') }}"
                                           placeholder="Apartment, suite, unit, floor, etc.">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-modern">City <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control-modern @error('city') is-invalid @enderror" 
                                           name="city" 
                                           value="{{ old('city') }}" 
                                           required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-modern">State <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control-modern @error('state') is-invalid @enderror" 
                                           name="state" 
                                           value="{{ old('state') }}" 
                                           required>
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-modern">PIN Code <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control-modern @error('pincode') is-invalid @enderror" 
                                           name="pincode" 
                                           value="{{ old('pincode') }}"
                                           placeholder="000000"
                                           maxlength="6"
                                           required>
                                    @error('pincode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-modern">Country</label>
                                    <input type="text" 
                                           class="form-control-modern" 
                                           name="country" 
                                           value="India" 
                                           readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <div class="step-number">3</div>
                            <h5 class="checkout-card-title">Payment Method</h5>
                        </div>
                        <div class="checkout-card-body">
                            <div class="payment-methods">
                                <div class="payment-method-item">
                                    <input type="radio" 
                                           class="payment-radio" 
                                           name="payment_method" 
                                           value="cod" 
                                           id="payment-cod" 
                                           checked>
                                    <label for="payment-cod" class="payment-label">
                                        <div class="payment-icon">
                                            <i class="bi bi-cash-coin"></i>
                                        </div>
                                        <div class="payment-details">
                                            <strong>Cash on Delivery</strong>
                                            <span>Pay when you receive your order</span>
                                        </div>
                                        <div class="payment-check">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <h5 class="checkout-card-title">Order Notes (Optional)</h5>
                        </div>
                        <div class="checkout-card-body">
                            <label class="form-label-modern">Add delivery instructions or special requests</label>
                            <textarea class="form-control-modern" 
                                      name="order_notes" 
                                      rows="3" 
                                      placeholder="E.g., Please call before delivery, Leave at door, etc.">{{ old('order_notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="col-lg-5">
                    <div class="order-summary-sticky">
                        <div class="checkout-card order-summary-card">
                            <div class="checkout-card-header">
                                <h5 class="checkout-card-title">Order Summary</h5>
                            </div>
                            <div class="checkout-card-body">
                                <!-- Cart Items -->
                                <div class="order-items">
                                    @foreach($cartItems as $item)
                                    <div class="order-item">
                                        <div class="order-item-image">
                                            <img src="{{ asset('/' . $item->product->main_image) }}" 
                                                 alt="{{ $item->product->product_name }}">
                                            <span class="order-item-qty">{{ $item->quantity }}</span>
                                        </div>
                                        <div class="order-item-details">
                                            <h6>{{ $item->product->product_name }}</h6>
                                            <p>Qty: {{ $item->quantity }}</p>
                                        </div>
                                        <div class="order-item-price">
                                            &#8377; {{ number_format($item->product->final_price * $item->quantity, 2) }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <hr class="my-3">

                                <!-- Pricing Details -->
                                <div class="pricing-details">
                                    <div class="pricing-row">
                                        <span>Subtotal</span>
                                        <span>&#8377; {{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    <div class="pricing-row">
                                        <span>Shipping</span>
                                        <span class="text-success">
                                            @if($subtotal >= 499)
                                                FREE
                                            @else
                                                &#8377; 00.00
                                            @endif
                                        </span>
                                    </div>
                                    <div class="pricing-row">
                                        <span>Tax (GST)</span>
                                        <span>&#8377; {{ number_format($tax, 2) }}</span>
                                    </div>
                                </div>

                                <hr class="my-3">

                                <!-- Total -->
                                <div class="order-total">
                                    <span>Total</span>
                                    <span>&#8377; {{ number_format($total, 2) }}</span>
                                </div>

                                <!-- Promo Code -->
                                <div class="promo-code-section">
                                    <div class="input-group-modern">
                                        <input type="text" 
                                               class="form-control-modern" 
                                               name="promo_code"
                                               placeholder="Enter promo code">
                                        <button type="button" class="btn-apply-promo">
                                            Apply
                                        </button>
                                    </div>
                                </div>

                                <!-- Place Order Button -->
                                <button type="submit" class="btn-place-order">
                                    <i class="bi bi-lock-fill"></i>
                                    Place Order
                                </button>

                                <!-- Security Badge -->
                                <div class="security-badge">
                                    <i class="bi bi-shield-check"></i>
                                    <span>Secure checkout - Your data is protected</span>
                                </div>
                            </div>
                        </div>

                        <!-- Trust Badges -->
                        <div class="trust-badges">
                            <div class="trust-badge-item">
                                <i class="bi bi-truck"></i>
                                <span>Fast Delivery</span>
                            </div>
                            <div class="trust-badge-item">
                                <i class="bi bi-arrow-repeat"></i>
                                <span>Easy Returns</span>
                            </div>
                            <div class="trust-badge-item">
                                <i class="bi bi-shield-check"></i>
                                <span>Secure Payment</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endif
    </div>
</section>

@push('scripts')
<script>
$(document).ready(function() {
    // Form validation
    $('#checkout-form').on('submit', function(e) {
        e.preventDefault();
        
        // Basic validation
        let isValid = true;
        const requiredFields = $(this).find('[required]');
        
        requiredFields.each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            alert('Please fill all required fields');
            return false;
        }
        
        // Submit form
        this.submit();
    });

    // Remove validation error on input
    $('.form-control-modern').on('input', function() {
        $(this).removeClass('is-invalid');
    });

    // PIN code validation
    $('input[name="pincode"]').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
    });

    // Phone number validation
    $('input[name="phone"]').on('input', function() {
        this.value = this.value.replace(/[^0-9+\s]/g, '');
    });
});
</script>
@endpush
@endsection
