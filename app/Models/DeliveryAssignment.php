<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryAssignment extends Model
{
    protected $fillable = [
        'order_id',
        'delivery_boy_id',
        'status',
        'delivery_address',
        'delivery_latitude',
        'delivery_longitude',
        'assigned_at',
        'picked_up_at',
        'delivery_started_at',
        'delivered_at',
        'delivery_notes',
        'delivery_photo_url',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'picked_up_at' => 'datetime',
        'delivery_started_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    /**
     * Relationship: Delivery Assignment belongs to Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relationship: Delivery Assignment belongs to Delivery Boy
     */
    public function deliveryBoy()
    {
        return $this->belongsTo(DeliveryBoy::class);
    }

    /**
     * Relationship: Delivery Assignment has many Delivery Locations
     */
    public function locations()
    {
        return $this->hasMany(DeliveryLocation::class);
    }

    /**
     * Get latest location
     */
    public function latestLocation()
    {
        return $this->hasOne(DeliveryLocation::class)->latestOfMany();
    }

    /**
     * Get all locations sorted by timestamp (for route visualization)
     */
    public function getLocationTrail()
    {
        return $this->locations()
                    ->orderBy('location_timestamp', 'asc')
                    ->get();
    }

    /**
     * Check if delivery is in progress
     */
    public function isInProgress()
    {
        return in_array($this->status, ['picked_up', 'on_way']);
    }

    /**
     * Check if delivery is completed
     */
    public function isCompleted()
    {
        return $this->status === 'delivered';
    }
}
