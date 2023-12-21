<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoothRental extends Model
{
    use HasFactory;

    protected $table = 'booth_rental';

    protected $fillable = [
        'id_event',
        'booth_code',
        'booth_size',
        'provided_facilities',
        'terms_and_conditions',
        'rental_price',
        'rental_time_limit',
        'availability_status',
        'id_category'
    ];

    protected $attributes = [
        'availability_status' => 'available',
        'id_category' => '3'
    ];
    
    protected $casts = [
        'provided_facilities' => 'json'
    ];
}