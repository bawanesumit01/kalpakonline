<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'address_line2',
        'city',
        'state',
        'pincode',
        'country',
        'is_default',
        'address_type',
    ];

    /**
     * Get the user that owns the address.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the orders using this address.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
