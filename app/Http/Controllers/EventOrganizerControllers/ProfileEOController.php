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
        $indonesiaCities = [
            'Ambon', 'Banda Aceh', 'Bandar Lampung', 'Bandung', 'Banjar', 'Banjarmasin', 'Batam', 'Batu', 'Bekasi', 'Bengkulu', 'Bima', 'Binjai', 'Bitung', 'Blitar', 'Bogor', 'Bondowoso', 'Bukittinggi', 'Cilegon', 'Cimahi', 'Cirebon', 'Denpasar', 'Depok', 'Dumai', 'Gorontalo', 'Jakarta', 'Jambi', 'Jayapura', 'Kediri', 'Kendari', 'Kotamobagu', 'Kupang', 'Langsa', 'Lhokseumawe', 'Lubuklinggau', 'Madiun', 'Magelang', 'Makassar', 'Malang', 'Manado', 'Mataram', 'Medan', 'Mojokerto', 'Padang', 'Palangkaraya', 'Palembang', 'Palopo', 'Palu', 'Pamekasan', 'Pangkal Pinang', 'Pekalongan', 'Pekanbaru', 'Pematangsiantar', 'Pontianak', 'Probolinggo', 'Samarinda', 'Sawahlunto', 'Semarang', 'Serang', 'Singkawang', 'Solo (Surakarta)', 'Sorong', 'Subang', 'Sukabumi', 'Sungai Penuh', 'Surabaya', 'Surakarta (Solo)', 'Tangerang', 'Tanjungbalai', 'Tanjung Pinang', 'Tarakan', 'Tasikmalaya', 'Tegal', 'Ternate', 'Tidore', 'Tomohon', 'Tual', 'Yogyakarta', 'Parepare', 'Palopo', 'Raba', 'Ruteng', 'Sabang', 'Salatiga', 'Samarinda', 'Sampit', 'Sibolga', 'Singaraja', 'Sinjai', 'Singkawang', 'Situbondo', 'Solok', 'Soppeng', 'Sorong', 'Subang', 'Sukabumi', 'Sungai Penuh', 'Surabaya', 'Tabanan'
        ];

        $data = User::where('users.id', auth()->user()->id)
            ->join('event_organizer', 'users.id', '=', 'event_organizer.id_user')
            ->first();

        return view('event_organizer.profile-eo', compact('data', 'indonesiaCities'));
    }

    public function updateProfileEO(Request $request, $id){
        $indonesiaCities = [
            'Ambon', 'Banda Aceh', 'Bandar Lampung', 'Bandung', 'Banjar', 'Banjarmasin', 'Batam', 'Batu', 'Bekasi', 'Bengkulu', 'Bima', 'Binjai', 'Bitung', 'Blitar', 'Bogor', 'Bondowoso', 'Bukittinggi', 'Cilegon', 'Cimahi', 'Cirebon', 'Denpasar', 'Depok', 'Dumai', 'Gorontalo', 'Jakarta', 'Jambi', 'Jayapura', 'Kediri', 'Kendari', 'Kotamobagu', 'Kupang', 'Langsa', 'Lhokseumawe', 'Lubuklinggau', 'Madiun', 'Magelang', 'Makassar', 'Malang', 'Manado', 'Mataram', 'Medan', 'Mojokerto', 'Padang', 'Palangkaraya', 'Palembang', 'Palopo', 'Palu', 'Pamekasan', 'Pangkal Pinang', 'Pekalongan', 'Pekanbaru', 'Pematangsiantar', 'Pontianak', 'Probolinggo', 'Samarinda', 'Sawahlunto', 'Semarang', 'Serang', 'Singkawang', 'Solo (Surakarta)', 'Sorong', 'Subang', 'Sukabumi', 'Sungai Penuh', 'Surabaya', 'Surakarta (Solo)', 'Tangerang', 'Tanjungbalai', 'Tanjung Pinang', 'Tarakan', 'Tasikmalaya', 'Tegal', 'Ternate', 'Tidore', 'Tomohon', 'Tual', 'Yogyakarta', 'Parepare', 'Palopo', 'Raba', 'Ruteng', 'Sabang', 'Salatiga', 'Samarinda', 'Sampit', 'Sibolga', 'Singaraja', 'Sinjai', 'Singkawang', 'Situbondo', 'Solok', 'Soppeng', 'Sorong', 'Subang', 'Sukabumi', 'Sungai Penuh', 'Surabaya', 'Tabanan'
        ];

        try {
            // Validasi
            $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|max:100',
                'description' => 'required|string',
                'address' => 'required|string|max:150',
                'city' => 'required|string',
                'whatsappNumber' => ['required', 'string', 'min:9', 'max:15', 'regex:/^628[0-9]+$/'],
                'foto_profile' => 'required|image|mimes:jpeg,png,jpg|max:3000',
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
            return view ('profile-eo', compact('indonesiaCities'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            toast('Validation Failed!', 'error');
            return redirect()->back()->withErrors($e->errors())->withInput($request->all());
        }
    }
    

    public function updatePasswordEO(Request $request, $id){
        // Validasi
        $request->validate([
            'password' => 'required|string|min:8|max:100',
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