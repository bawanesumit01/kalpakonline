<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'id';
    public $timestamps = false;
    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'product_name',
        'product_sku',
        'vendor_id',
        'category_id',
        'short_description',
        'description',
        'cost_price',
        'selling_price',
        'discount_percent',
        'final_price',
        'stock_quantity',
        'min_stock_alert',
        'stock_status',
        'unit',
        'main_image',
        'status',
    ];

    /**
     * Type casting
     */
    protected $casts = [
        'cost_price'        => 'decimal:2',
        'selling_price'     => 'decimal:2',
        'discount_percent'  => 'decimal:2',
        'final_price'       => 'decimal:2',
        'tax_rate'          => 'decimal:2',
        'stock_quantity'    => 'integer',
        'min_stock_alert'   => 'integer',
    ];

    /**
     * Relationships
     */

    // Product has many gallery images
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    /**
     * Boot method to auto-calculate final price
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            // final_price = cost_price (what customer pays)
            $product->final_price = $product->cost_price;

            // Auto stock status
            if ($product->stock_quantity <= 0) {
                $product->stock_status = 'out_of_stock';
            }
        });
    }

    /**
     * Scopes (Optional but useful)
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_status', 'in_stock');
    }
}