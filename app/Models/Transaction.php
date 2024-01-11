<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';

    protected $fillable = [
        'id_member',
        'id_event',
        'id_competition',
        'id_booth_rental',
        'transaction_date',
        'id_category',
        'qty',
        'transaction_amout',
        'transaction_status',
        'id_payment_methods',
    ];
}