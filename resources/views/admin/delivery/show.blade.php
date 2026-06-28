@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3 fw-bold">Delivery Details - Order #{{ $delivery->order_id }}</h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.delivery.index') }}" class="btn btn-outline-primary">
                ← Back to Deliveries
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Left Column: Information --}}
        <div class="col-lg-4 mb-4">
            {{-- Delivery Boy Info --}}
            <div class="card border-0 shadow-sm rounded-3 mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Delivery Boy</h5>
                </div>
                <div class="card-body">
                    @if($delivery->deliveryBoy)
                        <div class="mb-3">
                            <h6 class="fw-bold">{{ $delivery->deliveryBoy->name }}</h6>
                            <p class="text-muted mb-0">
                                <i class="fa fa-star text-warning"></i> {{ $delivery->deliveryBoy->rating }}
                            </p>
                        </div>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Phone</strong></td>
                                <td>{{ $delivery->deliveryBoy->phone }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>{{ $delivery->deliveryBoy->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Vehicle</strong></td>
                                <td>{{ ucfirst($delivery->deliveryBoy->vehicle_type) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Number</strong></td>
                                <td>{{ $delivery->deliveryBoy->vehicle_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>Deliveries</strong></td>
                                <td>{{ $delivery->deliveryBoy->total_deliveries }}</td>
                            </tr>
                        </table>
                    @else
                        <p class="text-muted mb-0">Not assigned yet</p>
                    @endif
                </div>
            </div>

            {{-- Delivery Status --}}
            <div class="card border-0 shadow-sm rounded-3 mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Status</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Current Status</small>
                        <p class="mb-0">
                            <span class="badge bg-{{ $delivery->status === 'delivered' ? 'success' : ($delivery->status === 'failed' ? 'danger' : 'info') }} px-3 py-2">
                                {{ ucfirst(str_replace('_', ' ', $delivery->status)) }}
                            </span>
                        </p>
                    </div>
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Assigned</strong></td>
                            <td>{{ $delivery->assigned_at ? $delivery->assigned_at->format('d M h:i A') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Picked Up</strong></td>
                            <td>{{ $delivery->picked_up_at ? $delivery->picked_up_at->format('d M h:i A') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Started</strong></td>
                            <td>{{ $delivery->delivery_started_at ? $delivery->delivery_started_at->format('d M h:i A') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Delivered</strong></td>
                            <td>{{ $delivery->delivered_at ? $delivery->delivered_at->format('d M h:i A') : '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Order Info --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Order Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Order ID</strong></td>
                            <td>#{{ $delivery->order_id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Customer</strong></td>
                            <td>{{ $delivery->order->customer_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Phone</strong></td>
                            <td>{{ $delivery->order->customer_phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td>₹{{ number_format($delivery->order->total ?? 0, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right Column: Map and Route --}}
        <div class="col-lg-8">
            {{-- Live Map --}}
            <div class="card border-0 shadow-sm rounded-3 mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Live Tracking Map</h5>
                </div>
                <div class="card-body p-0">
                    <div id="map" style="height: 500px; border-radius: 0 0 1rem 1rem;"></div>
                </div>
            </div>

            {{-- Location History --}}
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header">
                    <h5 class="mb-0">Location History</h5>
                </div>
                <div class="card-body">
                    @if($locations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Time</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Speed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($locations->reverse() as $loc)
                                        <tr>
                                            <td>{{ $loc->location_timestamp->format('d M h:i A') }}</td>
                                            <td>{{ number_format($loc->latitude, 6) }}</td>
                                            <td>{{ number_format($loc->longitude, 6) }}</td>
                                            <td>{{ $loc->speed ? $loc->speed . ' km/h' : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-3">No location data yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key={{ $google_maps_key }}"></script>
<script>
    let map;
    let markers = [];
    let polyline;

    function initMap() {
        const defaultCenter = { lat: 19.0760, lng: 72.8777 };

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 14,
            center: defaultCenter,
            mapTypeId: 'roadmap',
        });

        // Add delivery location marker
        @if($delivery->delivery_latitude && $delivery->delivery_longitude)
            const destMarker = new google.maps.Marker({
                position: {
                    lat: {{ $delivery->delivery_latitude }},
                    lng: {{ $delivery->delivery_longitude }}
                },
                map: map,
                icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',
                title: 'Delivery Address'
            });
        @endif

        // Add location history points
        const locations = [];
        @foreach($locations as $loc)
            locations.push({
                lat: {{ $loc->latitude }},
                lng: {{ $loc->longitude }}
            });
        @endforeach

        if (locations.length > 0) {
            // Draw polyline
            polyline = new google.maps.Polyline({
                path: locations,
                geodesic: true,
                strokeColor: '#4285F4',
                strokeOpacity: 0.7,
                strokeWeight: 3,
                map: map
            });

            // Current location marker (last point)
            const currentLoc = locations[locations.length - 1];
            const currentMarker = new google.maps.Marker({
                position: currentLoc,
                map: map,
                icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                title: 'Current Location'
            });

            // Fit bounds
            const bounds = new google.maps.LatLngBounds();
            locations.forEach(loc => bounds.extend(loc));
            map.fitBounds(bounds);
        }
    }

    window.addEventListener('DOMContentLoaded', initMap);
</script>
@endsection
