<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlider extends Model
{
    protected $table = 'hero_sliders';
    
    protected $fillable = [
        'image_path',
        'video_url',
        'title',
        'description',
        'button_text',
        'button_link',
        'order',
        'is_active',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
    
    /**
     * Get active hero sliders ordered for display
     */
    public static function getActiveSliders()
    {
        return self::where('is_active', true)
                   ->orderBy('order', 'asc')
                   ->get();
    }
}

