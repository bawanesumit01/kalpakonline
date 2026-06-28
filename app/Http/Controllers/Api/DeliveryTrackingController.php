<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryAssignment;
use App\Models\DeliveryLocation;
use App\Models\DeliveryBoy;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DeliveryTrackingController extends Controller
{
    /**
     * Delivery boy sends live location
     * POST /api/delivery/location
     */
    public function updateLocation(Request $request)
    {
        $validated = $request->validate([
            'delivery_assignment_id' => 'required|exists:delivery_assignments,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'speed' => 'nullable|numeric',
            'accuracy' => 'nullable|numeric',
        ]);

        try {
            // Create location record
            $location = DeliveryLocation::create([
                'delivery_assignment_id' => $validated['delivery_assignment_id'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'speed' => $validated['speed'] ?? null,
                'accuracy' => $validated['accuracy'] ?? null,
                'location_timestamp' => now(),
            ]);

            // Update delivery boy's current location
            $assignment = DeliveryAssignment::findOrFail($validated['delivery_assignment_id']);
            $assignment->deliveryBoy()->update([
                'current_latitude' => $validated['latitude'],
                'current_longitude' => $validated['longitude'],
                'last_location_update' => now(),
            ]);

            // Update assignment delivery location (for final address)
            if ($assignment->status === 'on_way') {
                $assignment->update([
                    'delivery_latitude' => $validated['latitude'],
                    'delivery_longitude' => $validated['longitude'],
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Location updated successfully',
                'data' => [
                    'location_id' => $location->id,
                    'timestamp' => $location->created_at,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update location: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Customer views delivery tracking
     * GET /api/order/{orderId}/tracking
     */
    public function getOrderTracking($orderId)
    {
        try {
            $assignment = DeliveryAssignment::where('order_id', $orderId)
                                            ->with('deliveryBoy')
                                            ->firstOrFail();

            if (!$assignment->isInProgress()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Delivery not in progress',
                ], 404);
            }

            $latestLocation = $assignment->latestLocation;

            return response()->json([
                'success' => true,
                'data' => [
                    'assignment_id' => $assignment->id,
                    'order_id' => $assignment->order_id,
                    'status' => $assignment->status,
                    'delivery_boy' => [
                        'id' => $assignment->deliveryBoy->id,
                        'name' => $assignment->deliveryBoy->name,
                        'phone' => $assignment->deliveryBoy->phone,
                        'photo_url' => $assignment->deliveryBoy->photo_url,
                        'vehicle_type' => $assignment->deliveryBoy->vehicle_type,
                        'vehicle_number' => $assignment->deliveryBoy->vehicle_number,
                        'rating' => $assignment->deliveryBoy->rating,
                        'total_deliveries' => $assignment->deliveryBoy->total_deliveries,
                    ],
                    'current_location' => $latestLocation ? [
                        'latitude' => (float)$latestLocation->latitude,
                        'longitude' => (float)$latestLocation->longitude,
                        'timestamp' => $latestLocation->location_timestamp,
                    ] : null,
                    'delivery_address' => [
                        'latitude' => (float)$assignment->delivery_latitude,
                        'longitude' => (float)$assignment->delivery_longitude,
                        'address' => $assignment->delivery_address,
                    ],
                    'started_at' => $assignment->delivery_started_at,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tracking data not found',
            ], 404);
        }
    }

    /**
     * Get location history for route visualization
     * GET /api/delivery/{assignmentId}/route
     */
    public function getDeliveryRoute($assignmentId)
    {
        try {
            $assignment = DeliveryAssignment::findOrFail($assignmentId);

            $locations = $assignment->locations()
                                    ->orderBy('location_timestamp', 'asc')
                                    ->get()
                                    ->map(function ($loc) {
                                        return [
                                            'latitude' => (float)$loc->latitude,
                                            'longitude' => (float)$loc->longitude,
                                            'timestamp' => $loc->location_timestamp,
                                        ];
                                    });

            return response()->json([
                'success' => true,
                'data' => [
                    'locations' => $locations,
                    'total_points' => count($locations),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Route not found',
            ], 404);
        }
    }

    /**
     * Delivery boy starts delivery
     * POST /api/delivery/start
     */
    public function startDelivery(Request $request)
    {
        $validated = $request->validate([
            'assignment_id' => 'required|exists:delivery_assignments,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        try {
            $assignment = DeliveryAssignment::findOrFail($validated['assignment_id']);

            // Update status to picked_up
            $assignment->update([
                'status' => 'picked_up',
                'picked_up_at' => now(),
            ]);

            // Record initial location
            DeliveryLocation::create([
                'delivery_assignment_id' => $assignment->id,
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'location_timestamp' => now(),
            ]);

            // Update delivery boy status
            $assignment->deliveryBoy()->update([
                'status' => 'busy',
                'current_latitude' => $validated['latitude'],
                'current_longitude' => $validated['longitude'],
                'last_location_update' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Delivery started',
                'data' => ['assignment_id' => $assignment->id]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to start delivery: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delivery boy marks delivery as complete
     * POST /api/delivery/complete
     */
    public function completeDelivery(Request $request)
    {
        $validated = $request->validate([
            'assignment_id' => 'required|exists:delivery_assignments,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        try {
            $assignment = DeliveryAssignment::findOrFail($validated['assignment_id']);

            // Record final location
            DeliveryLocation::create([
                'delivery_assignment_id' => $assignment->id,
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'location_timestamp' => now(),
            ]);

            // Update assignment
            $assignment->update([
                'status' => 'delivered',
                'delivered_at' => now(),
                'delivery_notes' => $validated['notes'] ?? null,
                'delivery_latitude' => $validated['latitude'],
                'delivery_longitude' => $validated['longitude'],
            ]);

            // Update delivery boy
            $deliveryBoy = $assignment->deliveryBoy;
            $deliveryBoy->update([
                'status' => 'available',
                'total_deliveries' => $deliveryBoy->total_deliveries + 1,
            ]);

            // Update order status to delivered
            $assignment->order()->update([
                'status' => 'delivered',
                'delivered_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Delivery completed successfully',
                'data' => ['assignment_id' => $assignment->id]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to complete delivery: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get live tracking data for customer dashboard
     * GET /api/customer/order/{orderId}/live
     */
    public function getLiveTracking($orderId)
    {
        try {
            $assignment = DeliveryAssignment::where('order_id', $orderId)
                                            ->with(['deliveryBoy', 'order'])
                                            ->firstOrFail();

            if (!$assignment->isInProgress()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Delivery not in progress',
                ], 404);
            }

            $latestLocation = $assignment->latestLocation;

            // Calculate simple ETA (assuming 30 km/h average)
            $eta = null;
            if ($latestLocation) {
                $distance = $this->calculateDistance(
                    $latestLocation->latitude,
                    $latestLocation->longitude,
                    $assignment->delivery_latitude,
                    $assignment->delivery_longitude
                );
                
                // 30 km/h = 0.5 km/minute
                $eta = ceil($distance / 0.5);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'current_location' => [
                        'lat' => $latestLocation ? (float)$latestLocation->latitude : null,
                        'lng' => $latestLocation ? (float)$latestLocation->longitude : null,
                    ],
                    'destination' => [
                        'lat' => (float)$assignment->delivery_latitude,
                        'lng' => (float)$assignment->delivery_longitude,
                    ],
                    'delivery_boy' => [
                        'name' => $assignment->deliveryBoy->name,
                        'phone' => $assignment->deliveryBoy->phone,
                        'vehicle' => $assignment->deliveryBoy->vehicle_type,
                        'rating' => $assignment->deliveryBoy->rating,
                    ],
                    'eta_minutes' => $eta,
                    'status' => $assignment->status,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Calculate distance between two coordinates using Haversine formula
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }
}
