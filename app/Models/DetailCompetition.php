<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DetailCompetition extends Model
{
    use HasFactory;

    protected $table = 'detail_competition';

    protected $fillable = [
        'id_event',
        'competition_name',
        'thumbnail_competition',
        'competition_description',
        'competition_start_date',
        'competition_end_date',
        'competition_fee',
        'participant_qty',
        'id_category',
    ];

    protected $attributes = [
        'id_category' => '2',
    ];

}