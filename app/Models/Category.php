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
    ];

       /**
     * Vendor belongs to Category
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
