<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'session_id',
        'name',
        'email',
        'phone',
        'address',
        'address_line2',
        'city',
        'state',
        'pincode',
        'country',
        'payment_method',
        'payment_status',
        'order_notes',
        'promo_code',
        'subtotal',
        'shipping',
        'tax',
        'discount',
        'total',
        'status',
        'confirmed_at',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'shipping' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items for this order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . date('YmdHis') . '-' . strtoupper(substr(uniqid(), -6));
        } while (self::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    /**
     * Get the full name of the order status
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Get the full name of the payment status
     */
    public function getPaymentStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Pending',
            'paid' => 'Paid',
            'failed' => 'Failed',
            'cancelled' => 'Cancelled',
        ];

        return $labels[$this->payment_status] ?? $this->payment_status;
    }
}
