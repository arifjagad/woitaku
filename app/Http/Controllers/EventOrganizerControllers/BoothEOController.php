<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\BoothRental;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

        if($dataEvent->isEmpty()){
            toast('Harus memiliki event terlebih dahulu', 'error');
            return redirect()->route('event-eo');
        }else{
            return view('event_organizer.booth.create-booth-eo', compact('dataEvent'), ['type_menu' => 'booth-eo']);
        }
    }

    public function storeBoothEO(Request $request){
        $selectedEventId = $request->input('event_name');

        try {
            $this->validate($request, [
                'event_name' => 'required',
                'booth_code' => 'required|string|max:8',
                'booth_size' => 'required|string|max:30',
                'rental_price' => 'required|string|max:9',
                'provided_facilities' => 'required',
            ]);

            // Post ke database
            BoothRental::create([
                'id_event' => $selectedEventId,
                'booth_code' => $request->booth_code,
                'booth_size' => $request->booth_size,
                'rental_price' => $request->rental_price,
                'provided_facilities' => $request->provided_facilities,
            ]);

            toast('Booth berhasil dibuat', 'success');
            return redirect()->route('booth-eo');

        } catch (\Illuminate\Validation\ValidationException $e) {
            toast('Validasi gagal', 'error');
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

    public function updateBoothEO(Request $request, $boothId){
        $selectedEventId = $request->input('event_name');

        try {
            $this->validate($request, [
                'event_name' => 'required',
                'booth_code' => 'required',
                'booth_size' => 'required',
                'rental_price' => 'required',
                'provided_facilities' => 'required',
            ]);

            $booth = BoothRental::find($boothId);
            $booth->update([
                'id_event' => $selectedEventId,
                'booth_code' => $request->booth_code,
                'booth_size' => $request->booth_size,
                'rental_price' => $request->rental_price,
                'provided_facilities' => $request->provided_facilities,
            ]);

            toast('Booth berhasil diupdate', 'success');
            return redirect()->route('booth-eo');

        } catch (\Illuminate\Validation\ValidationException $e) {
            toast('Validasi gagal', 'error');
            return redirect()->back()->withErrors($e->errors())->withInput($request->all());
        }
    }

    public function deleteBoothEO($id){
        $dataBooth = BoothRental::find($id);
        $dataBooth->delete();

        toast('Booth berhasil dihapus', 'success');
        return redirect()->route('booth-eo');
    }
}