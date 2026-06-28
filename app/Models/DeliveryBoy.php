<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryBoy extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'photo_url',
        'vehicle_type',
        'vehicle_number',
        'status',
        'rating',
        'total_deliveries',
        'current_latitude',
        'current_longitude',
        'last_location_update',
    ];

    protected $casts = [
        'last_location_update' => 'datetime',
    ];

    /**
     * Relationship: Delivery Boy has many Delivery Assignments
     */
    public function deliveryAssignments()
    {
        return $this->hasMany(DeliveryAssignment::class);
    }

    /**
     * Get active deliveries for this boy
     */
    public function activeDeliveries()
    {
        return $this->hasMany(DeliveryAssignment::class)
                    ->whereIn('status', ['picked_up', 'on_way']);
    }

    /**
     * Get completed deliveries
     */
    public function completedDeliveries()
    {
        return $this->hasMany(DeliveryAssignment::class)
                    ->where('status', 'delivered');
    }
}
