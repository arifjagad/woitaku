<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function indexDashboard_EventOrganizer(){
        $data = DB::table('users')
            ->join('event_organizer', 'users.id', '=', 'event_organizer.id_user')
            ->select('users.*', 'event_organizer.*')
            ->where('users.id', auth()->id())
            ->first();

        return view('event_organizer.dashboard-eo', ['type_menu' => 'event_organizer.dashboard-eo'], compact('data'));
    }
}