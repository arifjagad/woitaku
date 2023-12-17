<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\DetailEvent;
use DOMDocument;
use Illuminate\Support\Str;


class EventEOController extends Controller
{
    public function indexEventEO()
    {
        $data = DB::table('detail_event')
            ->join('users', 'detail_event.id_eo', '=', 'users.id')
            ->where('users.id', auth()->id())
            ->get();

        return view('event_organizer.event.event-eo', ['type_menu' => 'event-eo'], compact('data'));
    }

    public function createEventEO(Request $request)
    {
        $indonesiaCities = [
            'Ambon', 'Banda Aceh', 'Bandar Lampung', 'Bandung', 'Banjar', 'Banjarmasin', 'Batam', 'Batu', 'Bekasi', 'Bengkulu', 'Bima', 'Binjai', 'Bitung', 'Blitar', 'Bogor', 'Bondowoso', 'Bukittinggi', 'Cilegon', 'Cimahi', 'Cirebon', 'Denpasar', 'Depok', 'Dumai', 'Gorontalo', 'Jakarta', 'Jambi', 'Jayapura', 'Kediri', 'Kendari', 'Kotamobagu', 'Kupang', 'Langsa', 'Lhokseumawe', 'Lubuklinggau', 'Madiun', 'Magelang', 'Makassar', 'Malang', 'Manado', 'Mataram', 'Medan', 'Mojokerto', 'Padang', 'Palangkaraya', 'Palembang', 'Palopo', 'Palu', 'Pamekasan', 'Pangkal Pinang', 'Pekalongan', 'Pekanbaru', 'Pematangsiantar', 'Pontianak', 'Probolinggo', 'Samarinda', 'Sawahlunto', 'Semarang', 'Serang', 'Singkawang', 'Solo (Surakarta)', 'Sorong', 'Subang', 'Sukabumi', 'Sungai Penuh', 'Surabaya', 'Surakarta (Solo)', 'Tangerang', 'Tanjungbalai', 'Tanjung Pinang', 'Tarakan', 'Tasikmalaya', 'Tegal', 'Ternate', 'Tidore', 'Tomohon', 'Tual', 'Yogyakarta', 'Parepare', 'Palopo', 'Raba', 'Ruteng', 'Sabang', 'Salatiga', 'Samarinda', 'Sampit', 'Sibolga', 'Singaraja', 'Sinjai', 'Singkawang', 'Situbondo', 'Solok', 'Soppeng', 'Sorong', 'Subang', 'Sukabumi', 'Sungai Penuh', 'Surabaya', 'Tabanan'
        ];
        
        return view('event_organizer.event.create-event-eo', ['type_menu' => 'create-event-eo'], compact('indonesiaCities'));
    }

    public function storeEventEO(Request $request)
    {
        $indonesiaCities = [
            'Ambon', 'Banda Aceh', 'Bandar Lampung', 'Bandung', 'Banjar', 'Banjarmasin', 'Batam', 'Batu', 'Bekasi', 'Bengkulu', 'Bima', 'Binjai', 'Bitung', 'Blitar', 'Bogor', 'Bondowoso', 'Bukittinggi', 'Cilegon', 'Cimahi', 'Cirebon', 'Denpasar', 'Depok', 'Dumai', 'Gorontalo', 'Jakarta', 'Jambi', 'Jayapura', 'Kediri', 'Kendari', 'Kotamobagu', 'Kupang', 'Langsa', 'Lhokseumawe', 'Lubuklinggau', 'Madiun', 'Magelang', 'Makassar', 'Malang', 'Manado', 'Mataram', 'Medan', 'Mojokerto', 'Padang', 'Palangkaraya', 'Palembang', 'Palopo', 'Palu', 'Pamekasan', 'Pangkal Pinang', 'Pekalongan', 'Pekanbaru', 'Pematangsiantar', 'Pontianak', 'Probolinggo', 'Samarinda', 'Sawahlunto', 'Semarang', 'Serang', 'Singkawang', 'Solo (Surakarta)', 'Sorong', 'Subang', 'Sukabumi', 'Sungai Penuh', 'Surabaya', 'Surakarta (Solo)', 'Tangerang', 'Tanjungbalai', 'Tanjung Pinang', 'Tarakan', 'Tasikmalaya', 'Tegal', 'Ternate', 'Tidore', 'Tomohon', 'Tual', 'Yogyakarta', 'Parepare', 'Palopo', 'Raba', 'Ruteng', 'Sabang', 'Salatiga', 'Samarinda', 'Sampit', 'Sibolga', 'Singaraja', 'Sinjai', 'Singkawang', 'Situbondo', 'Solok', 'Soppeng', 'Sorong', 'Subang', 'Sukabumi', 'Sungai Penuh', 'Surabaya', 'Tabanan'
        ];

        try {
            // Validasi
            $request->validate([
                'event_name' => 'required|string|max:50',
                'city' => 'required|string',
                'event_address' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|after:start_date',
                'ticket_price' => 'nullable',
                'ticket_qty' => 'nullable',
                'document' => 'required|string',
                'featured_image' => 'image|mimes:jpeg,png,jpg|max:3000',
            ]);
            
            // Upload data dari summernote untuk deskripsi event
            $event_description = $request->event_description;
            $dom = new DOMDocument();
            if (!empty($event_description)) {
                $dom->loadHTML($event_description, 9);
            }

            $images = $dom->getElementsByTagName('img');

            foreach ($images as $key => $img) {
                $data = base64_decode(explode(',',explode(';',$img->getAttribute('src'))[1])[1]);
                $image_name = "/upload/" . time(). $key.'.png';
                file_put_contents(public_path().$image_name,$data);

                $img->removeAttribute('src');
                $img->setAttribute('src',$image_name);
            }

            $event_description = $dom->saveHTML();

            // Upload featured image
            if ($request->hasFile('featured_image')) {
                $file = $request->file('featured_image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'event_organizer/detail_event/' . $fileName;

                Storage::disk('public')->put($filePath, File::get($file));

                /* // Resize gambar menggunakan Intervention Image
                $resizedImage = Image::make($file)->resize(300, 200)->encode($extension);

                // Simpan gambar yang diresize ke penyimpanan
                Storage::disk('public')->put($filePath, $resizedImage); */
            }

            // Post ke database
            DetailEvent::create([
                'id_eo' => auth()->user()->id,
                'event_name' => $request->event_name,
                'featured_image' => $filePath,
                'event_description' => $event_description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'city' => $request->city,
                'address' => $request->event_address,
                'ticket_price' => $request->ticket_price,
                'ticket_qty' => $request->ticket_qty,
                'document' => $request->document,
                'verification' => 'pending',
                'id_category' => '1',
                'reason_verification' => 'event kamu sedang dicek terlebih dahulu'
            ]);


            toast('Event Successfully Created!', 'success');
            return redirect()->route('event-eo');

        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors(), $request->all());

            toast('Validation Failed!', 'error');
            return redirect()->back()->withErrors($e->errors())->withInput($request->all());
        }
        
        return view('event_organizer.event.create-event-eo', ['type_menu' => 'create-event-eo'], compact('indonesiaCities'));
    }
}