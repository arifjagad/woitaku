<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use App\Models\DetailEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function homeMember()
    {
        /* $dataEvent = DB::table('detail_event')
            ->join('event_organizer', 'detail_event.id_eo', '=', 'event_organizer.id_user')
            ->join('users', 'event_organizer.id_user', '=', 'users.id')
            ->where('detail_event.verification', '=', 'accepted')
            ->get(); */

        $dataEvent = DB::table('users')
            ->join('event_organizer', 'users.id', 'event_organizer.id_user')
            ->join('detail_event', 'users.id', 'detail_event.id_eo')
            ->where('detail_event.verification', '=', 'accepted')
            ->select('event_organizer.id as event_organizer_id', 'detail_event.id as detail_event_id', 'users.*', 'event_organizer.*', 'detail_event.*')
            ->get();

        return view('member.home', compact('dataEvent'), ['type_menu' => 'home']);
    }
}