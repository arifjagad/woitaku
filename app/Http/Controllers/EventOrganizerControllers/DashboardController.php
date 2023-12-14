<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\EventOrganizer;

class DashboardController extends Controller
{
    public function indexDashboard_EventOrganizer(){
        $data = EventOrganizer::where('id_user', auth()->id())->first();

        return view('event_organizer.dashboard-eo', ['type_menu' => 'event_organizer.dashboard-eo'], compact('data'));
    }
}