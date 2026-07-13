<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarqueeMessage extends Model
{
    protected $table = 'marquee_messages';
    
    protected $fillable = [
        'message',
        'icon',
        'order',
        'is_active',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
    
    /**
     * Get all active marquee messages ordered for display
     */
    public static function getActiveMessages()
    {
        return self::where('is_active', true)
                   ->orderBy('order', 'asc')
                   ->get();
    }
    
    /**
     * Get messages as array with icons for homepage display
     */
    public static function getMessages()
    {
        $messages = self::getActiveMessages();
        
        if ($messages->isEmpty()) {
            // Return defaults if no messages exist
            return [
                [
                    'text' => 'Free Delivery on orders above ₹499',
                    'icon' => 'fas fa-shipping-fast'
                ],
                [
                    'text' => 'Flash Sale — Up to 50% OFF on selected items!',
                    'icon' => 'fas fa-bolt'
                ],
                [
                    'text' => 'Use code KALPAK10 for 10% off your first order',
                    'icon' => 'fas fa-gift'
                ],
            ];
        }
        
        return $messages->map(function($msg) {
            return [
                'text' => $msg->message,
                'icon' => $msg->icon,
            ];
        })->toArray();
    }
}
