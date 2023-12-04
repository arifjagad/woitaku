<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;

class AdminController extends Controller
{
    public function Add_CreateAdmin(Request $request)
    {
        $userType = 'admin';

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => $userType,
        ]);

        return redirect(RouteServiceProvider::HOME);
    }
}
