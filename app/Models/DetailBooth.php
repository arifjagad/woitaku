<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBooth extends Model
{
    use HasFactory;

    protected $table = 'detail_booth';

    protected $fillable = [
        'booth_name',
        'id_booth_rental',
        'id_member',
        'booth_image',
        'booth_description'
    ];
}