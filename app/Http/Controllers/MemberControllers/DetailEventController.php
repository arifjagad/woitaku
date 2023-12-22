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

        $detailCompetition = DB::table('detail_event')
            ->join('detail_competition', 'detail_event.id', '=', 'detail_competition.id_event')
            ->where('detail_competition.id_event', '=', $id)
            ->get();
        
        return view('member.detail-event', compact('detailEvent', 'detailCompetition'), ['type_menu' => 'detail-event']);
    }
}