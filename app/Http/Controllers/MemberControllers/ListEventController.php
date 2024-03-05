<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ListEventController extends Controller
{
    public function indexListEvent()
    {
        $dataEventCity = DB::table('detail_event')
            ->select('city')
            ->where('detail_event.verification', '=', 'accepted')
            ->get();

        $dataEvent = DB::table('users')
            ->join('event_organizer', 'users.id', 'event_organizer.id_user')
            ->join('detail_event', 'users.id', 'detail_event.id_eo')
            ->where('detail_event.verification', '=', 'accepted')
            ->select(
                '*',
                DB::raw('(CASE WHEN detail_event.start_date >= NOW() - INTERVAL 1 DAY THEN 0 ELSE 1 END) AS has_expired')
            )
            ->orderBy('has_expired', 'asc')
            ->orderBy('detail_event.start_date', 'asc')
            ->paginate(8);

        return view('member.list-event', compact('dataEvent', 'dataEventCity'), ['type_menu' => 'list-event']);
    }

    public function searchEvent(Request $request){
        $search = $request->search;
        $dataEvent = DB::table('users')
            ->join('event_organizer', 'users.id', 'event_organizer.id_user')
            ->join('detail_event', 'users.id', 'detail_event.id_eo')
            ->where('detail_event.verification', '=', 'accepted')
            ->where('detail_event.event_name', 'like', "%".$search."%")
            ->select(
                '*',
                DB::raw('(CASE WHEN detail_event.start_date >= NOW() - INTERVAL 1 DAY THEN 0 ELSE 1 END) AS has_expired')
            )
            ->orderBy('has_expired', 'asc')
            ->orderBy('detail_event.start_date', 'asc')
            ->paginate(8);

        $dataEventCity = DB::table('detail_event')
            ->select('city')
            ->where('detail_event.verification', '=', 'accepted')
            ->get();

        return view('member.list-event', compact('dataEvent', 'dataEventCity'), ['type_menu' => 'list-event']);
    }

    public function filterEvent(Request $request)
    {
        $search = $request->search;
        $priceRange = $request->price_range;
        $city = $request->city;

        $dataEventCity = DB::table('detail_event')
            ->select('city')
            ->where('detail_event.verification', '=', 'accepted')
            ->get();

        $dataEvent = DB::table('users')
            ->join('event_organizer', 'users.id', 'event_organizer.id_user')
            ->join('detail_event', 'users.id', 'detail_event.id_eo')
            ->where('detail_event.verification', '=', 'accepted')
            ->where('detail_event.event_name', 'like', "%".$search."%")
            ->select(
                '*',
                DB::raw('(CASE WHEN detail_event.start_date >= NOW() - INTERVAL 1 DAY THEN 0 ELSE 1 END) AS has_expired')
            )
            ->orderBy('has_expired', 'asc')
            ->orderBy('detail_event.start_date', 'asc');

        if ($priceRange === 'free') {
            $dataEvent = $dataEvent->where(function ($query) {
                $query->where('detail_event.ticket_price', '=', 0)
                    ->orWhereNull('detail_event.ticket_price');
            });
        } elseif ($priceRange === 'paid') {
            $dataEvent = $dataEvent->where('detail_event.ticket_price', '>', 0);
        }

        if (!empty($city)) {
            $dataEvent = $dataEvent->where('detail_event.city', '=', $city);
        }

        $dataEvent = $dataEvent->orderBy('detail_event.created_at', 'desc')
            ->paginate(8);

        return view('member.list-event', compact('dataEvent', 'dataEventCity'), ['type_menu' => 'list-event']);
    }
}