<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use App\Models\EventOrganizer;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\DetailEvent;

class DetailEventOrganizerController extends Controller
{
    public function indexDetailEventOrganizer($eoName)
    {
        $slug = Str::slug($eoName);
        $eventOrganizer = User::whereRaw("LOWER(REPLACE(name, ' ', '-')) = ?", $slug)->first();

        $id = $eventOrganizer->id;

        $eventOrganizer = DB::table('users')
            ->join('event_organizer', 'event_organizer.id_user', '=', 'users.id')
            ->join('detail_event', 'detail_event.id_eo', '=', 'event_organizer.id_user')
            ->where('users.id', '=', $id)
            ->first();

        $eventCount = DetailEvent::where('id_eo', $id)
            ->where('verification', '=', 'accepted')
            ->count();

        $dataEvent = DB::table('users')
            ->join('event_organizer', 'users.id', 'event_organizer.id_user')
            ->join('detail_event', 'users.id', 'detail_event.id_eo')
            ->where('detail_event.verification', '=', 'accepted')
            ->where('detail_event.id_eo', '=', $id)
            ->select(
                '*',
                DB::raw('(CASE WHEN detail_event.start_date >= NOW() - INTERVAL 1 DAY THEN 0 ELSE 1 END) AS has_expired')
            )
            ->orderBy('has_expired', 'asc')
            ->orderBy('detail_event.start_date', 'asc')
            ->paginate(3);

        return view ('member.detail-event-organizer', compact('eventOrganizer', 'eventCount', 'dataEvent'), ['type_menu' => 'detail-event-organizer']);
    }
}