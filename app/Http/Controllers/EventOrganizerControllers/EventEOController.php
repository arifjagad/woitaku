<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\EventOrganizer;

class EventEOController extends Controller
{
    public function indexEventEO()
    {
        $data = DB::table('detail_event')
            ->join('event_organizer', 'detail_event.id_eo', '=', 'event_organizer.id')
            ->get();

        return view('event_organizer.event-eo', ['type_menu' => 'event_organizer.event-eo'], compact('data'));
    }
}