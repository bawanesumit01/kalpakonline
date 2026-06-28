<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryLocation extends Model
{
    protected $fillable = [
        'delivery_assignment_id',
        'latitude',
        'longitude',
        'speed',
        'accuracy',
        'location_timestamp',
    ];

    protected $casts = [
        'location_timestamp' => 'datetime',
    ];

    /**
     * Relationship: Delivery Location belongs to Delivery Assignment
     */
    public function deliveryAssignment()
    {
        return $this->belongsTo(DeliveryAssignment::class);
    }
}
