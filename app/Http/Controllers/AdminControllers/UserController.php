<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\EventOrganizer;
use App\Models\DetailEvent;
use App\Models\DetailCompetition;
use App\Models\BoothRental;

class UserController extends Controller
{
    public function indexMember()
    {
        $data = User::join('detail_member', 'users.id', '=', 'detail_member.id_member')
        ->where('users.usertype', 'member')
        ->get();

        return view('admin.member', compact('data'), ['type_menu' => 'member']);
    }

    public function indexEventOrganizer(){
        $data = DB::table('users')
            ->join('event_organizer', 'event_organizer.id_user', '=', 'users.id')
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

        $dataBooth = DB::table('detail_event')
            ->join('booth_rental', 'booth_rental.id_event', '=', 'detail_event.id')
            ->get();

        $eventCount = DetailEvent::join('users', 'users.id', '=', 'detail_event.id_eo')
            ->count();
        $competitionCount = DetailCompetition::join('event_organizer', 'detail_competition.id_event', '=', 'event_organizer.id')
            ->count();
        $boothCount = DetailEvent::join('booth_rental', 'booth_rental.id_event', '=', 'detail_event.id')
            ->count();

        return view('admin.detail-event-organizer', compact('boothCount', 'dataProfile', 'dataEvent', 'dataCompetition', 'dataBooth', 'eventCount', 'competitionCount'), ['type_menu' => 'event-organizer']);
    }
}