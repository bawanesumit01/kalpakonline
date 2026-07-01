<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'categories';

    /**
     * Primary key
     */
    protected $primaryKey = 'category_id';

    /**
     * Disable timestamps
     */
    public $timestamps = false;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'vendor_id',
        'category_name',
        'cat_image',
        'slug',
    ];

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = \Illuminate\Support\Str::slug($category->category_name);
            }
        });

        static::updating(function ($category) {
            if (empty($category->slug) || $category->isDirty('category_name')) {
                $category->slug = \Illuminate\Support\Str::slug($category->category_name);
            }
        });
    }

    /**
     * Vendor belongs to Category
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    /**
     * Category has many products
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
