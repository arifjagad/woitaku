<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\BoothRental;
use DOMDocument;
use HTMLPurifier_Config;
use HTMLPurifier;

class BoothEOController extends Controller
{
    public function indexBoothEO(){
        $userId = Auth::id();

        $dataBooth = DB::table('booth_rental')
            ->join('detail_event', 'booth_rental.id_event', '=', 'detail_event.id')
            ->where('detail_event.id_eo', '=', $userId)
            ->select('booth_rental.*', 'detail_event.event_name')
            ->get();

        return view('event_organizer.booth.booth-eo', compact('dataBooth'), ['type_menu' => 'booth-eo']);
    }

    public function createBoothEO(){
        $userId = Auth::id();

        $dataEvent = DB::table('detail_event')
            ->where('id_eo', '=', $userId)
            ->get();

            
        return view('event_organizer.booth.create-booth-eo', compact('dataEvent'), ['type_menu' => 'booth-eo']);
    }

    public function storeBoothEO(Request $request){
        $selectedEventId = $request->input('event_name');
        $providedFacilities = explode(', ', $request->provided_facilities);

        try {
            $this->validate($request, [
                'event_name' => 'required',
                'booth_code' => 'required',
                'booth_size' => 'required',
                'rental_price' => 'required',
                'provided_facilities' => 'required',
                'terms_and_conditions' => 'required',
            ]);

            // Upload data dari summernote untuk deskripsi event
            $providedFacilities = $request->providedFacilities;

            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);
            $providedFacilities = $purifier->purify($providedFacilities);

            $dom = new DOMDocument();
            if (!empty($providedFacilities)) {
                $dom->loadHTML($providedFacilities, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            }

            $images = $dom->getElementsByTagName('img');

            foreach ($images as $key => $img) {
                if (strpos($img->getAttribute('src'),'data:image/') === 0) {
                    $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                    $image_name = "/upload/" . time() . $key . '.png';
                    file_put_contents(public_path() . $image_name, $data);

                    $img->removeAttribute('src');
                    $img->setAttribute('src', $image_name);
                }
            }

            $providedFacilities = $dom->saveHTML();

            // Post ke database
            BoothRental::create([
                'id_event' => $selectedEventId,
                'booth_code' => $request->booth_code,
                'booth_size' => $request->booth_size,
                'rental_price' => $request->rental_price,
                'provided_facilities' => $providedFacilities,
                'terms_and_conditions' => $request->terms_and_conditions,
            ]);

            toast('Booth Successfully Created!', 'success');
            return redirect()->route('booth-eo');

        } catch (\Illuminate\Validation\ValidationException $e) {
            toast('Validation Failed!', 'error');
            return redirect()->back()->withErrors($e->errors())->withInput($request->all());
        }
    }

    public function editBoothEO($id){
        $userId = Auth::id();

        $dataEvent = DB::table('detail_event')
            ->where('id_eo', '=', $userId)
            ->get();

        $dataBooth = BoothRental::find($id);

        $providedFacilities = $dataBooth->provided_facilities;

        return view('event_organizer.booth.edit-booth-eo', compact('dataEvent', 'dataBooth', 'providedFacilities'), ['type_menu' => 'booth-eo']);
    }

    public function updateBoothEO(Request $request){
        $selectedEventId = $request->input('event_name');
        $providedFacilities = explode(', ', $request->provided_facilities);

        try {
            $this->validate($request, [
                'event_name' => 'required',
                'booth_code' => 'required',
                'booth_size' => 'required',
                'rental_price' => 'required',
                'provided_facilities' => 'required',
                'terms_and_conditions' => 'required',
            ]);

            // Upload data dari summernote untuk deskripsi event
            $providedFacilities = $request->providedFacilities;

            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);
            $providedFacilities = $purifier->purify($providedFacilities);

            $dom = new DOMDocument();
            if (!empty($providedFacilities)) {
                $dom->loadHTML($providedFacilities, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            }

            $images = $dom->getElementsByTagName('img');

            foreach ($images as $key => $img) {
                if (strpos($img->getAttribute('src'),'data:image/') === 0) {
                    $data = base64_decode(explode(',', explode(';', $img->getAttribute('src'))[1])[1]);
                    $image_name = "/upload/" . time() . $key . '.png';
                    file_put_contents(public_path() . $image_name, $data);

                    $img->removeAttribute('src');
                    $img->setAttribute('src', $image_name);
                }
            }

            $providedFacilities = $dom->saveHTML();

            // Post ke database
            BoothRental::create([
                'id_event' => $selectedEventId,
                'booth_code' => $request->booth_code,
                'booth_size' => $request->booth_size,
                'rental_price' => $request->rental_price,
                'provided_facilities' => $providedFacilities,
                'terms_and_conditions' => $request->terms_and_conditions,
            ]);

            toast('Booth Successfully Update!', 'success');
            return redirect()->route('booth-eo');

        } catch (\Illuminate\Validation\ValidationException $e) {
            toast('Validation Failed!', 'error');
            return redirect()->back()->withErrors($e->errors())->withInput($request->all());
        }
    }

    public function deleteBoothEO($id){
        $dataBooth = BoothRental::find($id);
        $dataBooth->delete();

        toast('Booth Successfully Deleted!', 'success');
        return redirect()->route('booth-eo');
    }
}