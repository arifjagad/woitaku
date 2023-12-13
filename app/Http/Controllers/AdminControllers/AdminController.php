<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function indexAdmin(){
        $admins = User::where('usertype', 'admin')->get();
        $status = $admins->pluck('status')->toArray();
        return view('admin.list-admin', ['users' => $admins], compact('status'));
    }

    public function createAdmin()
    {
        return view('admin.create-admin');
    }

    public function storeAdmin(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => 'admin',
            'status' => 'active',
        ]);

        Session::flash('success', 'Admin berhasil ditambahkan.');
        return redirect()->route('list-admin');
    }

    public function profileAdmin()
    {
        $id = auth()->user()->id;
        $data = User::find($id);
        return view('admin.profile-admin', compact('data'), ['user' => $data]);
    }

    public function updateAdmin(Request $request, $id){
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        
        if($request->password != null){
            $data->password = Hash::make($request->password);
        }

        $data->save();

        Session::flash('success', 'Profile berhasil diupdate.');
        return redirect()->route('profile-admin');
    }
}