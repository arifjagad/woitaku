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
        try {
            // Validasi
            $request->validate([
                'name' => 'required|string|max:30',
                'email' => 'required|email|max:50',
                'description' => 'nullable|string',
                'address' => 'nullable|string',
                'city' => 'nullable|string',
                'whatsappNumber' => ['nullable', 'string', 'min:10', 'regex:/^628[0-9]+$/'],
                'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:3000',
            ]);
    
            DB::beginTransaction();
    
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
    
            // Verifikasi Upload Foto Profile
            if ($request->hasFile('foto_profile')) {
                $file = $request->file('foto_profile');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'event_organizer/profile_photos/' . $fileName;
    
                Storage::disk('public')->put($filePath, File::get($file));
    
                $detailEventOrganizer->foto_profile = $filePath;
            }
    
            // Kondisi update jika ada atau tidaknya foto profile baru
            if ($request->hasFile('foto_profile') || $detailEventOrganizer->isDirty('foto_profile')) {
                $detailEventOrganizer->save();
            } else {
                $detailEventOrganizer->save();
            }
    
            DB::commit();
    
            toast('Profile Successfully Updated!', 'success');
            return redirect()->route('profile-eo');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            toast('Validation Failed!', 'error');
            return redirect()->back()->withErrors($e->errors())->withInput($request->all());
        }
    }
    

    public function updatePasswordEO(Request $request, $id){
        // Validasi
        $request->validate([
            'password' => 'required|string|min:8|max:30',
        ]);

        $data = User::find(auth()->user()->id);
        if($request->password != null){
            $data->password = Hash::make($request->password);
        }

        $data->save();

        toast('Password Successfully Updated!','success');
        return redirect()->route('profile-eo');
    }
}