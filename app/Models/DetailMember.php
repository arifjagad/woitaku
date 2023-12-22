<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DetailMember extends Model
{
    use HasFactory;

    protected $table = 'detail_member';

    protected $fillable = [
        'id_member',
        'foto_profile',
        'kota',
        'nomor_wahtsapp',
    ];
}