<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'vendors';

    /**
     * Primary key
     */
    protected $primaryKey = 'vendor_id';

    /**
     * Disable timestamps
     */
    public $timestamps = false;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'user_id',
        'vendor_name',
    ];

    /**
     * Vendor belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
