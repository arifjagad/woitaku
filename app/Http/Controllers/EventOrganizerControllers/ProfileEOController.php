<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use App\Http\Controllers\Controller;
use App\Models\EventOrganizer;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProfileEOController extends Controller
{
    public function indexProfileEO(){
        $data = User::where('users.id', auth()->user()->id)
            ->join('event_organizer', 'users.id', '=', 'event_organizer.id_user')
            ->first();

        return view('event_organizer.profile-eo', compact('data'));
    }

    public function updateProfileEO(Request $request, $id){
        DB::beginTransaction();

        $request->validate([
            'foto_profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:300',
        ]);

        // Update users table
        $user = User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $detailEventOrganizer = EventOrganizer::where('id_user', auth()->user()->id)->first();
        $detailEventOrganizer->description = $request->description;
        $detailEventOrganizer->alamat = $request->address;
        $detailEventOrganizer->kota = $request->city;
        $detailEventOrganizer->nomor_whatsapp = $request->whatsappNumber;

        if ($request->hasFile('foto_profile')) {
            $file = $request->file('foto_profile');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'event_organizer/profile_photos/' . $fileName;

            Storage::disk('public')->put($filePath, File::get($file));

            $detailEventOrganizer->foto_profile = $filePath;
        }

        $detailEventOrganizer->save();

        

        DB::commit();

        toast('Profile Successfully Updated!','success');
        return redirect()->route('profile-eo');
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