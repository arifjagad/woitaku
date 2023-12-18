<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethods extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';

    protected $fillable = [
        'id_eo',
        'bank_name',
        'account_number',
        'account_holder_name',
        'status'
    ];

    

}