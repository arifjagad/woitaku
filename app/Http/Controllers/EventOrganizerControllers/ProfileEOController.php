<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileEOController extends Controller
{
    public function indexProfileEO(){
        $data = auth()->user();
        return view('event_organizer.profile-eo', ['type_menu' => 'event_organizer.profile-eo'], compact('data'));
    }

    public function updateEO(Request $request, $id){
        $data = User::find($id);
        if($request->password != null){
            $data->password = Hash::make($request->password);
        }

        $data->save();

        Session::flash('success', 'Profile berhasil diupdate.');
        return redirect()->route('profile-eo');
    }
}