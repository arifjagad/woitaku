<?php

namespace App\Http\Controllers\AdminControllers\Activities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Activities\Event;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{
    public function indexEvent()
    {
        $datas = DB::table('detail_event')
            ->join('event_organizer', 'detail_event.id_eo', '=', 'event_organizer.id_user')
            ->join('users', 'detail_event.id_eo', '=', 'users.id')
            ->select('detail_event.id', 
                    'users.name',
                    'detail_event.event_name', 
                    'detail_event.featured_image', 
                    'detail_event.event_category', 
                    'detail_event.event_description', 
                    'detail_event.start_date', 
                    'detail_event.end_date', 
                    'detail_event.city', 
                    'detail_event.address', 
                    'detail_event.ticket_price', 
                    'detail_event.ticket_qty', 
                    'detail_event.document', 
                    'detail_event.verification', 
                    )
            ->get();

        return view('admin.activities.event', ['datas' => $datas], ['type_menu' => 'event']);
    }

    public function acceptEvent($id){
        $datas = Event::find($id);
        $datas->verification = 'accepted';
        $datas->reason_verification = 'Event anda diterima tanpa ada kendala';
        $datas->save();

        Session::flash('success', 'Event telah diterima dan kini sudah terpampang di halaman depan.');
        return redirect()->back();
    }

    public function reviewEvent(Request $request, $id){
        $datas = Event::find($id);
        $datas->verification = 'revision';
        $datas->reason_verification = $request->reason_verification;
        $datas->save();

        Session::flash('success', "Event kembali ditinjau, pesan akan dikirim ke Event Organizer.");
        return redirect()->back();
    }

    public function rejectEvent(Request $request, $id){
        $datas = Event::find($id);
        $datas->verification = 'rejected';
        $datas->reason_verification = $request->reason_verification;
        $datas->save();

        Session::flash('success', "Event telah ditolak, pesan akan dikirim ke Event Organizer");
        return redirect()->back();
    }
}