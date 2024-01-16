<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'detail_member';

    protected $fillable = [
        'id_member',
        'foto_profile',
        'address',
        'kota',
        'nomor_whatsapp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
