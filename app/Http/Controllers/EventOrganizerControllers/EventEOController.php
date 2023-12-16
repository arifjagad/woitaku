<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EventEOController extends Controller
{
    public function indexEventEO()
    {
        $data = DB::table('detail_event')
            ->join('users', 'detail_event.id_eo', '=', 'users.id')
            ->where('users.id', auth()->id())
            ->get();

        return view('event_organizer.event.event-eo', ['type_menu' => 'event-eo'], compact('data'));
    }

    public function createEventEO()
    {
        return view('event_organizer.event.create-event-eo', ['type_menu' => 'create-event-eo']);
    }
}