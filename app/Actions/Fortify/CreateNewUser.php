<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Models\EventOrganizer;
use App\Models\Member;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'user_type' => ['required', 'string', 'max:255'],
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'usertype' => $input['user_type'],
        ]);

        if($input['user_type'] === 'event organizer'){
            $detailEventOrganizer = EventOrganizer::create([
                'id_user' => $user->id,
            ]);
            $detailEventOrganizer->save();
        }elseif($input['user_type'] === 'member'){
            $detailMember = Member::create([
                'id_member' => $user->id,
            ]);
            $detailMember->save();
        }

        $user->save();

        return $user;
    }
}
