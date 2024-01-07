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
        'transaction_date',
        'id_category',
        'transaction_amout',
        'transaction_status',
        'id_payment_methods',
    ];
}