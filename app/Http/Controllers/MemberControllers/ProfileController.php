<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\DetailMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function indexProfile()
    {
        $indonesiaCities = [
            'Ambon', 'Banda Aceh', 'Bandar Lampung', 'Bandung', 'Banjar', 'Banjarmasin', 'Batam', 'Batu', 'Bekasi', 'Bengkulu', 'Bima', 'Binjai', 'Bitung', 'Blitar', 'Bogor', 'Bondowoso', 'Bukittinggi', 'Cilegon', 'Cimahi', 'Cirebon', 'Denpasar', 'Depok', 'Dumai', 'Gorontalo', 'Jakarta', 'Jambi', 'Jayapura', 'Kediri', 'Kendari', 'Kotamobagu', 'Kupang', 'Langsa', 'Lhokseumawe', 'Lubuklinggau', 'Madiun', 'Magelang', 'Makassar', 'Malang', 'Manado', 'Mataram', 'Medan', 'Mojokerto', 'Padang', 'Palangkaraya', 'Palembang', 'Palopo', 'Palu', 'Pamekasan', 'Pangkal Pinang', 'Pekalongan', 'Pekanbaru', 'Pematangsiantar', 'Pontianak', 'Probolinggo', 'Samarinda', 'Sawahlunto', 'Semarang', 'Serang', 'Singkawang', 'Solo (Surakarta)', 'Sorong', 'Subang', 'Sukabumi', 'Sungai Penuh', 'Surabaya', 'Surakarta (Solo)', 'Tangerang', 'Tanjungbalai', 'Tanjung Pinang', 'Tarakan', 'Tasikmalaya', 'Tegal', 'Ternate', 'Tidore', 'Tomohon', 'Tual', 'Yogyakarta', 'Parepare', 'Palopo', 'Raba', 'Ruteng', 'Sabang', 'Salatiga', 'Samarinda', 'Sampit', 'Sibolga', 'Singaraja', 'Sinjai', 'Singkawang', 'Situbondo', 'Solok', 'Soppeng', 'Sorong', 'Subang', 'Sukabumi', 'Sungai Penuh', 'Surabaya', 'Tabanan'
        ];

        $authId = auth()->user()->id;

        $dataMember = DetailMember::where('id_member', $authId)->first();
        /* $dataDetail = DB::table('detail_member')
            ->join('users', 'detail_member.id_member', '=', 'users.id')
            ->get(); */

        return view('member.detail.profile', compact('dataMember', 'indonesiaCities'), ['type_menu' => 'profile']);
    }

    public function updateProfile(Request $request){
        $indonesiaCities = [
            'Ambon', 'Banda Aceh', 'Bandar Lampung', 'Bandung', 'Banjar', 'Banjarmasin', 'Batam', 'Batu', 'Bekasi', 'Bengkulu', 'Bima', 'Binjai', 'Bitung', 'Blitar', 'Bogor', 'Bondowoso', 'Bukittinggi', 'Cilegon', 'Cimahi', 'Cirebon', 'Denpasar', 'Depok', 'Dumai', 'Gorontalo', 'Jakarta', 'Jambi', 'Jayapura', 'Kediri', 'Kendari', 'Kotamobagu', 'Kupang', 'Langsa', 'Lhokseumawe', 'Lubuklinggau', 'Madiun', 'Magelang', 'Makassar', 'Malang', 'Manado', 'Mataram', 'Medan', 'Mojokerto', 'Padang', 'Palangkaraya', 'Palembang', 'Palopo', 'Palu', 'Pamekasan', 'Pangkal Pinang', 'Pekalongan', 'Pekanbaru', 'Pematangsiantar', 'Pontianak', 'Probolinggo', 'Samarinda', 'Sawahlunto', 'Semarang', 'Serang', 'Singkawang', 'Solo (Surakarta)', 'Sorong', 'Subang', 'Sukabumi', 'Sungai Penuh', 'Surabaya', 'Surakarta (Solo)', 'Tangerang', 'Tanjungbalai', 'Tanjung Pinang', 'Tarakan', 'Tasikmalaya', 'Tegal', 'Ternate', 'Tidore', 'Tomohon', 'Tual', 'Yogyakarta', 'Parepare', 'Palopo', 'Raba', 'Ruteng', 'Sabang', 'Salatiga', 'Samarinda', 'Sampit', 'Sibolga', 'Singaraja', 'Sinjai', 'Singkawang', 'Situbondo', 'Solok', 'Soppeng', 'Sorong', 'Subang', 'Sukabumi', 'Sungai Penuh', 'Surabaya', 'Tabanan'
        ];

        try {
            // Validasi
            $request->validate([
                'name' => 'required|string|max:30',
                'email' => 'required|email|max:50',
                'address' => 'nullable|string',
                'city' => 'nullable|string',
                'whatsappNumber' => ['nullable', 'string', 'min:10', 'regex:/^628[0-9]+$/'],
                'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:3000',
            ]);

            // Post ke database
            $dataUsers = User::where('id', auth()->user()->id)->first();
            $dataUsers->name = $request->name;
            $dataUsers->email = $request->email;
            $dataUsers->save();

            $dataMember = DetailMember::where('id_member', auth()->user()->id)->first();
            $dataMember->address = $request->address;
            $dataMember->kota = $request->city;
            $dataMember->nomor_whatsapp = $request->whatsappNumber;

            if ($request->hasFile('foto_profile')) {
                $file = $request->file('foto_profile');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'detail_member/' . $fileName;
    
                Storage::disk('public')->put($filePath, File::get($file));
    
                $dataMember->foto_profile = $filePath;
            }
    
            $dataMember->save();

            toast('Profile Successfully Updated!', 'success');
            return redirect()->route('profile');

        } catch (\Illuminate\Validation\ValidationException $e) {
            toast('Validation Failed!', 'error');
            return redirect()->back()->withErrors($e->errors())->withInput($request->all());
        }

        return view('member.profile',
            ['type_menu' => 'edit-event-eo'],
            compact('indonesiaCities')
        );
    }

    public function updatePasswordProfile(Request $request){
        try {
            // Validasi
            $request->validate([
                'password' => 'required|string|min:8|max:30',
            ]);

            $dataMember = User::find(auth()->user()->id);
            
            if($request->password != null){
                $dataMember->password = Hash::make($request->password);
            }

            $dataMember->save();

            toast('Password Successfully Updated!','success');
            return redirect()->route('profile');
        } catch (\Illuminate\Validation\ValidationException $e) {
            toast('Validation Failed!','error');
            return redirect()->back()->withErrors($e->errors())->withInput($request->all());
        }
    }
}