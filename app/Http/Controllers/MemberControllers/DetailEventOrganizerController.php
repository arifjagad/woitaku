<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\Ticket;
use RealRashid\SweetAlert\Facades\Alert;

class DetailEventOrganizerController extends Controller
{
    public function indexDetailEventOrganizer($id)
    {
        $detailEventOrganizer = DB::table('users')
            ->join('event_organizer', 'users.id', 'event_organizer.id_user')
            ->join('detail_event', 'users.id', 'detail_event.id_eo')
            ->where('detail_event.id', '=', $id)
            ->first();

        $listEvent = DB::table('users')
            ->join('event_organizer', 'users.id', 'event_organizer.id_user')
            ->join('detail_event', 'users.id', 'detail_event.id_eo')
            ->where('detail_event.id', '=', $id)
            ->get();

        return view ('detail-event-organizer', compact('detailEventOrganizer'), ['type_menu' => 'detail-event-organizer']);
    }
}