<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'detail_member';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'foto_profile',
        'kota',
        'nomor_whatsapp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
