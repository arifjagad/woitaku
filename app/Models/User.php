<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Validator;

use App\Models\EventOrganizer;

class User extends Authenticatable implements MustVerifyEmail // Add MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'usertype',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   /*  public static function validateUsers($data)
    {
        $rules = [
            'name' => 'required|string|max:30',
            'email' => 'required|email|max:50',
            'password' => 'required|password|min:8|max:50',
        ];

        $validator = Validator::make($data, $rules);

        return $validator;
    } */


    public function eventOrganizer()
    {
        return $this->hasOne(EventOrganizer::class, 'id_user');
    }


    public function member()
    {
        return $this->hasOne(Member::class, 'id_member');
    }
}
