@extends('home.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                {{-- Order Header --}}
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="fw-bold mb-1">Order #{{ $order->id }}</h4>
                                <p class="text-muted mb-0">
                                    <small>Placed on {{ $order->created_at->format('d M Y, h:i A') }}</small>
                                </p>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success px-3 py-2 fs-6">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($tracking_available)
                    {{-- Live Tracking Map --}}
                    <div class="card border-0 shadow-sm rounded-3 mb-4">
                        <div class="card-body p-0">
                            <div id="map" style="height: 500px; border-radius: 1rem; overflow: hidden;"></div>
                        </div>
                    </div>

                    {{-- Tracking Info --}}
                    <div class="row mb-4">
                        {{-- Delivery Boy Info --}}
                        <div class="col-lg-6 mb-3">
                            <div class="card border-0 shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-3">Delivery Boy</h5>
                                    <div id="deliveryBoyInfo">
                                        <p class="text-muted">Loading...</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ETA & Distance --}}
                        <div class="col-lg-6 mb-3">
                            <div class="card border-0 shadow-sm rounded-3">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-3">Estimated Time</h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-muted mb-1">Arriving in</p>
                                            <h3 class="fw-bold text-success mb-0" id="etaMinutes">--</h3>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1">Distance</p>
                                            <h3 class="fw-bold text-primary mb-0" id="distance">--</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status Timeline --}}
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Delivery Status</h5>
                            <div class="timeline">
                                <div class="timeline-item {{ $assignment && $assignment->status !== 'pending' ? 'active' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <p class="fw-bold mb-0">Order Confirmed</p>
                                        <small class="text-muted">{{ $order->created_at->format('d M Y, h:i A') }}</small>
                                    </div>
                                </div>

                                <div class="timeline-item {{ $assignment && in_array($assignment->status, ['picked_up', 'on_way', 'delivered']) ? 'active' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <p class="fw-bold mb-0">Picked Up</p>
                                        <small class="text-muted" id="pickedUpTime">
                                            {{ $assignment && $assignment->picked_up_at ? $assignment->picked_up_at->format('d M Y, h:i A') : 'Pending' }}
                                        </small>
                                    </div>
                                </div>

                                <div class="timeline-item {{ $assignment && in_array($assignment->status, ['on_way', 'delivered']) ? 'active' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <p class="fw-bold mb-0">Out for Delivery</p>
                                        <small class="text-muted" id="outForDeliveryTime">
                                            {{ $assignment && $assignment->delivery_started_at ? $assignment->delivery_started_at->format('d M Y, h:i A') : 'Pending' }}
                                        </small>
                                    </div>
                                </div>

                                <div class="timeline-item {{ $assignment && $assignment->status === 'delivered' ? 'active' : '' }}">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <p class="fw-bold mb-0">Delivered</p>
                                        <small class="text-muted" id="deliveredTime">
                                            {{ $assignment && $assignment->delivered_at ? $assignment->delivered_at->format('d M Y, h:i A') : 'Pending' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @else
                    <div class="alert alert-info text-center py-5">
                        <h5 class="fw-bold mb-2">Tracking Coming Soon</h5>
                        <p class="mb-0">Live tracking will be available once your order is picked up for delivery.</p>
                    </div>
                @endif

                {{-- Back Button --}}
                <div class="mt-4">
                    <a href="{{ route('client.orders') }}" class="btn btn-outline-primary">
                        ← Back to Orders
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

@if($tracking_available)
<style>
    .timeline {
        position: relative;
        padding: 0 0 0 30px;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 30px;
        opacity: 0.5;
    }

    .timeline-item.active {
        opacity: 1;
    }

    .timeline-marker {
        position: absolute;
        left: -25px;
        top: 5px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: #e9ecef;
        border: 2px solid #dee2e6;
    }

    .timeline-item.active .timeline-marker {
        background-color: #28a745;
        border-color: #28a745;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: -18px;
        top: 15px;
        bottom: 0;
        width: 2px;
        background-color: #dee2e6;
    }

    .timeline-item.active ~ .timeline-item .timeline-marker {
        background-color: #e9ecef;
    }

    #map {
        width: 100%;
        height: 500px;
    }
</style>

<script src="https://maps.googleapis.com/maps/api/js?key={{ $google_maps_key }}"></script>
<script>
    let map;
    let currentLocationMarker;
    let destinationMarker;
    let deliveryBoyMarker;
    let polyline;
    const orderId = {{ $order->id }};
    const assignmentId = {{ $assignment ? $assignment->id : 'null' }};

    // Initialize map
    function initMap() {
        // Default center
        const defaultCenter = { lat: 19.0760, lng: 72.8777 }; // Mumbai

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: defaultCenter,
            mapTypeId: 'roadmap',
        });

        // Fetch initial tracking data
        updateTracking();

        // Update every 5 seconds
        setInterval(updateTracking, 5000);
    }

    // Update tracking information
    async function updateTracking() {
        try {
            const response = await fetch(`/api/delivery/order/${orderId}/live`);
            const data = await response.json();

            if (data.success) {
                const trackingData = data.data;
                
                // Update current location marker
                if (trackingData.current_location.lat && trackingData.current_location.lng) {
                    const currentPos = {
                        lat: parseFloat(trackingData.current_location.lat),
                        lng: parseFloat(trackingData.current_location.lng)
                    };

                    if (!deliveryBoyMarker) {
                        deliveryBoyMarker = new google.maps.Marker({
                            position: currentPos,
                            map: map,
                            icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                            title: 'Delivery Boy Location'
                        });
                    } else {
                        deliveryBoyMarker.setPosition(currentPos);
                    }

                    map.setCenter(currentPos);
                }

                // Update destination marker
                if (trackingData.destination.lat && trackingData.destination.lng) {
                    const destPos = {
                        lat: parseFloat(trackingData.destination.lat),
                        lng: parseFloat(trackingData.destination.lng)
                    };

                    if (!destinationMarker) {
                        destinationMarker = new google.maps.Marker({
                            position: destPos,
                            map: map,
                            icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
                            title: 'Delivery Address'
                        });
                    }
                }

                // Update ETA
                document.getElementById('etaMinutes').textContent = trackingData.eta_minutes ? `${trackingData.eta_minutes} min` : '--';

                // Update delivery boy info
                updateDeliveryBoyInfo(trackingData.delivery_boy);
            }
        } catch (error) {
            console.error('Error updating tracking:', error);
        }
    }

    // Update delivery boy information
    function updateDeliveryBoyInfo(deliveryBoy) {
        const html = `
            <div class="d-flex align-items-center mb-3">
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1">${deliveryBoy.name}</h6>
                    <p class="text-muted mb-1">
                        <i class="fas fa-star text-warning"></i> ${deliveryBoy.rating}
                    </p>
                    <p class="text-muted mb-0">
                        <i class="fas fa-phone"></i> ${deliveryBoy.phone}
                    </p>
                </div>
            </div>
            <p class="text-muted mb-1">
                <strong>Vehicle:</strong> ${deliveryBoy.vehicle}
            </p>
        `;
        document.getElementById('deliveryBoyInfo').innerHTML = html;
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        initMap();
    });
</script>
@endif

@endsection
