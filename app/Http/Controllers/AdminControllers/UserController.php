<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function indexMember()
    {
        $datas = DB::table('detail_member')
            ->join('users', 'detail_member.id', '=', 'users.id')
            ->get();

        return view('admin.users.member', ['datas' => $datas], ['type_menu' => 'member']);
    }

    public function indexEventOrganizer(){
        $datas = DB::table('event_organizer')
            ->join('users', 'event_organizer.id_user', '=', 'users.id')
            ->get();

        return view('admin.users.event-organizer', ['datas' => $datas], ['type_menu' => 'event-organizer']);
    }

    public function indexEventOrganizerDetail($id){
        $datas = DB::table('event_organizer')
            ->join('users', 'event_organizer.id_user', '=', 'users.id')
            ->join('detail_event', 'event_organizer.id_user', '=', 'detail_event.id_eo')
            ->join('detail_competition', 'detail_competition.id_event', '=', 'detail_event.id')
            ->where('users.id', $id)
            ->get();
            
        $eventCount = DB::table('detail_event')
            ->where('id_eo', $id)
            ->count();

        $competitionCount = DB::table('detail_competition')
            ->join('detail_event', 'detail_competition.id_event', '=', 'detail_event.id')
            ->where('id_eo', $id)
            ->count();

        return view('admin.users.detail-event-organizer', compact('eventCount', 'competitionCount'), ['datas' => $datas], ['type_menu' => 'event-organizer']);
    }
}