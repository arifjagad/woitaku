<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\EventOrganizer;

class CompetitionEOController extends Controller
{
    public function indexCompetitionEO(){
        

        return view('event_organizer.competition.competition-eo', ['type_menu' => 'competition-eo']);
    }
}