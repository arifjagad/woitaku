<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticket';

    protected $fillable = [
        'id_transaction',
        'ticket_identifier',
        'active_date',
        'status',
    ];

    protected $attributes = [
        'status' => 'unused',
    ];
}