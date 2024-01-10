<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DetailEvent extends Model
{
    use HasFactory;

    protected $table = 'detail_event';

    protected $fillable = [
        'id_eo',
        'event_name',
        'featured_image',
        'event_description',
        'start_date',
        'end_date',
        'city',
        'address',
        'ticket_price',
        'ticket_qty',
        'booth_layout',
        'document',
        'verification',
        'id_category',
        'reason_verification'
    ];

    protected $attributes = [
        'verification' => 'pending',
        'reason_verification' => 'event kamu sedang dicek terlebih dahulu',
        'id_category' => '1',
        'city' => 'Indonesia'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            // Set the 'id_eo' attribute to the ID of the currently authenticated user
            $event->id_eo = Auth::id();
        });
    }
}
