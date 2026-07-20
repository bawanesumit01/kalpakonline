<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'logo_path',
        'site_name',
        'site_description',
        'phone',
        'email',
        'address',
    ];

    /**
     * Get the single site setting (only one record in DB)
     */
    public static function getSetting()
    {
        return self::first() ?? self::create([
            'logo_path' => 'assets/images/kalpak-logo.png',
            'site_name' => 'Kalpak Online',
            'site_description' => 'Your trusted destination for quality products',
            'phone' => '+91-8669988077',
            'email' => 'support@kalpakonline.co.in',
            'address' => 'Kalpak, Pipla - 440034',
        ]);
    }
}

