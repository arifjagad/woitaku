<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function indexDashboard(){
        return view('event_organizer.dashboard');
    }
}