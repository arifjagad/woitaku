<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventOrganizer extends Model
{
    use HasFactory;

    protected $table = 'event_organizer';

    protected $fillable = [
        'id_user',
        'description',
        'foto_profile',
        'alamat',
        'kota',
        'nomor_whatsapp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
