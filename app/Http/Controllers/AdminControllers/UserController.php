<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\EventOrganizer;
use App\Models\DetailEvent;
use App\Models\DetailCompetition;

class UserController extends Controller
{
    public function indexMember()
    {
        $data = User::where('usertype', 'member')->get();

        return view('admin.member', compact('data'), ['type_menu' => 'member']);
    }

    public function indexEventOrganizer(){
        $data = DB::table('event_organizer')
            ->join('users', 'event_organizer.id_user', '=', 'users.id')
            ->get();
            
        return view('admin.event-organizer', compact('data'), ['type_menu' => 'event-organizer']);
    }

    public function indexEventOrganizerDetail(){
        $dataProfile = DB::table('event_organizer')
            ->join('users', 'event_organizer.id_user', '=', 'users.id')
            ->get();
            
        $dataEvent = DB::table('detail_event')
            ->join('event_organizer', 'detail_event.id_eo', '=', 'event_organizer.id_user')
            ->get();

        $dataCompetition = DB::table('detail_competition')
            ->join('event_organizer', 'detail_competition.id_event', '=', 'event_organizer.id')
            ->get();

        $eventCount = DetailEvent::count();
        $competitionCount = DetailCompetition::count();

        return view('admin.detail-event-organizer', compact('dataProfile', 'dataEvent', 'dataCompetition', 'eventCount', 'competitionCount'), ['type_menu' => 'event-organizer']);
    }
}