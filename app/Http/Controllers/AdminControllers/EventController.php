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
        /* $eventId = DetailEvent::all();
        dd($eventId->id);

        $datas = DB::table('users')
            ->join('event_organizer', 'users.id = event_organizer.id_user')
            ->join('detail_event', 'event_organizer.id_user', '=', 'detail_event.id_eo')
            ->get(); */

        $datas = DB::table('detail_event')
            ->join('event_organizer', 'detail_event.id_eo', '=', 'event_organizer.id_user')
            ->join('users', 'detail_event.id_eo', '=', 'users.id')
            ->select('detail_event.*', 'users.name')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.event', compact('datas'), ['type_menu' => 'event']);
    }

    public function acceptEvent($id){
        $datas = DetailEvent::find($id);
        $datas->verification = 'accepted';
        $datas->reason_verification = 'Event anda diterima tanpa ada kendala';
        $datas->save();
        
        toast('Event telah diterima dan kini sudah terpampang di halaman depan.', 'success');
        return redirect()->back();
    }

    public function reviewEvent(Request $request, $id){
        $datas = DetailEvent::find($id);
        $datas->verification = 'revision';
        $datas->reason_verification = $request->reason_verification;
        $datas->save();

        toast('Event telah ditinjau dan akan dikirimkan pesan ke Event Organizer.', 'success');
        return redirect()->back();
    }

    public function rejectEvent(Request $request, $id){
        $datas = DetailEvent::find($id);
        $datas->verification = 'rejected';
        $datas->reason_verification = $request->reason_verification;
        $datas->save();

        toast('Event telah ditolak, pesan akan dikirim ke Event Organizer.', 'success');
        return redirect()->back();
    }
}