<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'image_path',
    ];

    /**
     * Relationship
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}