<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProfileEOController extends Controller
{
    public function indexProfileEO(){
        $data = User::where('id', auth()->user()->id)
        ->first();

        return view('event_organizer.profile-eo', compact('data'));
    }

    public function updatePasswordEO(Request $request, $id){
        $data = User::find($id);
        if($request->password != null){
            $data->password = Hash::make($request->password);
        }

        $data->save();

        toast('Password Successfully Updated!','success');
        return redirect()->route('profile-eo');
    }
}