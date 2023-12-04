<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function indexAdmin(){
        $admins = User::where('usertype', 'admin')->get();
        $status = $admins->pluck('status')->toArray();
        return view('pages.list-admin', ['users' => $admins], compact('status'));
    }

    public function createAdmin()
    {
        return view('pages.create-admin');
    }

    public function storeAdmin(Request $request)
    {
        $userType = 'admin';

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => $userType,
            'status' => 'active',
        ]);

        Session::flash('success', 'Admin berhasil ditambahkan.');
        return redirect()->route('list-admin');
    }
}
