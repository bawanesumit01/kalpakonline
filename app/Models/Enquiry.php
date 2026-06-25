<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'admin_response',
        'responded_at',
        'admin_id',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the admin who responded to this enquiry
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get the status label for display
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'new' => '<span class="badge bg-danger">New</span>',
            'read' => '<span class="badge bg-info">Read</span>',
            'responded' => '<span class="badge bg-success">Responded</span>',
            'closed' => '<span class="badge bg-secondary">Closed</span>',
        ];
        
        return $labels[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }
}
