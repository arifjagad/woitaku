<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

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

    /* public static function validateEventOrganizer($data)
    {
        $rules = [
            'description' => 'nullable|string',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:300',
            'alamat' => 'nullable|string',
            'kota' => 'nullable|string',
            'nomor_whatsapp' => 'nullable|string|min:10',
        ];

        $validator = Validator::make($data, $rules);

        return $validator;
    } */

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
