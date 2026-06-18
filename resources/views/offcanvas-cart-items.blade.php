@forelse($cartItems as $item)
<div class="cart-item d-flex align-items-center gap-3 border-bottom py-3" id="offcanvas-item-{{ $item->id }}">
    <img src="{{ asset('/' . $item->product->main_image) }}"
         width="60" height="60" class="rounded object-fit-cover"
         alt="{{ $item->product->product_name }}">
    <div class="flex-grow-1">
        <h6 class="mb-1 fs-6">{{ $item->product->product_name }}</h6>
        <small class="text-muted">&#8377; {{ $item->product->final_price }} each</small>
        <div class="d-flex align-items-center gap-2 mt-2">
            <button class="btn btn-outline-secondary btn-sm px-2 py-0 offcanvas-qty-decrease" data-cart-id="{{ $item->id }}">−</button>
            <span class="offcanvas-qty fw-semibold" data-cart-id="{{ $item->id }}">{{ $item->quantity }}</span>
            <button class="btn btn-outline-secondary btn-sm px-2 py-0 offcanvas-qty-increase" data-cart-id="{{ $item->id }}">+</button>
        </div>
    </div>
    <div class="text-end">
        <div class="fw-semibold offcanvas-subtotal" data-cart-id="{{ $item->id }}">
            &#8377; {{ number_format($item->product->final_price * $item->quantity, 2) }}
        </div>
        <button class="btn btn-link text-danger p-0 mt-1 offcanvas-remove" data-cart-id="{{ $item->id }}">
            <small>Remove</small>
        </button>
    </div>
</div>
@empty
<div class="text-center py-5">
    <p class="mt-3 text-muted">Your cart is empty</p>
    <a href="/" class="btn btn-primary btn-sm mt-2" data-bs-dismiss="offcanvas">Start Shopping</a>
</div>
@endforelse