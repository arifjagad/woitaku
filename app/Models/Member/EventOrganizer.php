<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'event_organizer';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'description',
        'foto_profile',
        'alamat',
        'kota',
        'nomor_whatsapp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
