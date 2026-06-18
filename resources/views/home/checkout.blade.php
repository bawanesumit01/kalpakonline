@extends('home.app')

@section('content')
<section class="py-5">
    <div class="container-lg">
        <h2 class="mb-4">Checkout</h2>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="mb-3">Delivery Details</h5>
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->mobile ?? '' }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Delivery Address</label>
                                <textarea class="form-control" rows="4"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pincode</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        <div class="alert alert-info mt-4 mb-0">
                            Payment method: Cash on Delivery
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="mb-3">Order Summary</h5>
                    @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span>{{ $item->product->product_name }} x {{ $item->quantity }}</span>
                            <strong>&#8377; {{ number_format($item->product->final_price * $item->quantity, 2) }}</strong>
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-between mt-3">
                        <span>Total</span>
                        <strong>&#8377; {{ number_format($total, 2) }}</strong>
                    </div>

                    <button type="button" class="btn btn-primary w-100 mt-4" disabled>
                        Place COD Order
                    </button>
                    <small class="text-muted d-block mt-2">
                        Local checkout page is ready; order saving is not connected yet.
                    </small>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
