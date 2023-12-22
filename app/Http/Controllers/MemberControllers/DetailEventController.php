<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\DetailEvent;
use Illuminate\Support\Str;

class DetailEventController extends Controller
{
    public function indexDetailEvent($id)
    {

        $detailEvent = DB::table('users')
            ->join('event_organizer', 'users.id', 'event_organizer.id_user')
            ->join('detail_event', 'users.id', 'detail_event.id_eo')
            ->where('detail_event.id', '=', $id)
            ->first();
        
        
        /* $detailEvent = DetailEvent::findorFail($id); */

        // dd($detailEvent->id, $detailEvent->event_name, $detailEvent->city, $id);


        return view('member.detail-event', compact('detailEvent'), ['type_menu' => 'detail-event']);
    }
}