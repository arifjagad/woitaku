<?php

namespace App\Models\Activities;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'detail_event';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_eo',
        'event_name',
        'featured_image',
        'event_category',
        'event_description',
        'start_date',
        'end_date',
        'city',
        'address',
        'ticket_price',
        'ticket_qty',
        'document',
        'verification',
        'reaction_verification',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        // other casts...
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
