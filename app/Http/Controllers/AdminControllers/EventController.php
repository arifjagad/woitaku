<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\DetailEvent;


class EventController extends Controller
{
    public function indexEvent()
    {
        $datas = DB::table('detail_event')
            ->join('event_organizer', 'detail_event.id_eo', '=', 'event_organizer.id_user')
            ->join('users', 'detail_event.id_eo', '=', 'users.id')
            ->get();

        return view('admin.event', ['datas' => $datas], ['type_menu' => 'event']);
    }

    public function acceptEvent($id){
        $datas = DetailEvent::find($id);
        $datas->verification = 'accepted';
        $datas->reason_verification = 'Event anda diterima tanpa ada kendala';
        $datas->save();

        Session::flash('success', 'Event telah diterima dan kini sudah terpampang di halaman depan.');
        return redirect()->back();
    }

    public function reviewEvent(Request $request, $id){
        $datas = DetailEvent::find($id);
        $datas->verification = 'revision';
        $datas->reason_verification = $request->reason_verification;
        $datas->save();

        Session::flash('success', "Event kembali ditinjau, pesan akan dikirim ke Event Organizer.");
        return redirect()->back();
    }

    public function rejectEvent(Request $request, $id){
        $datas = DetailEvent::find($id);
        $datas->verification = 'rejected';
        $datas->reason_verification = $request->reason_verification;
        $datas->save();

        Session::flash('success', "Event telah ditolak, pesan akan dikirim ke Event Organizer");
        return redirect()->back();
    }
}