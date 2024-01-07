<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\DetailEvent;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class DetailEventController extends Controller
{
    public function indexDetailEvent($id)
    {
        $detailEvent = DB::table('users')
            ->join('event_organizer', 'users.id', 'event_organizer.id_user')
            ->join('detail_event', 'users.id', 'detail_event.id_eo')
            ->where('detail_event.id', '=', $id)
            ->first();

        $detailCompetition = DB::table('detail_event')
            ->join('detail_competition', 'detail_event.id', '=', 'detail_competition.id_event')
            ->where('detail_competition.id_event', '=', $id)
            ->get();

        $modalDetailCompetition = DB::table('detail_event')
            ->join('detail_competition', 'detail_event.id', '=', 'detail_competition.id_event')
            ->where('detail_competition.id_event', '=', $id)
            ->first();

        $detailBooth = DB::table('detail_event')
            ->join('booth_rental', 'detail_event.id', '=', 'booth_rental.id_event')
            ->where('booth_rental.id_event', '=', $id)
            ->get();

        $detailPaymentMethod = DB::table('payment_methods')
            ->join('detail_event', 'payment_methods.id_eo', '=', 'detail_event.id_eo')
            ->where('detail_event.id', '=', $id)
            ->get();
            
        // 
        $start_date_event = Carbon::parse($detailEvent->start_date);
        $end_date_event = Carbon::parse($detailEvent->end_date);
        $daysDifference = $end_date_event->diffInDays($start_date_event);


        
        return view('member.detail-event', compact('detailEvent', 'detailCompetition', 'modalDetailCompetition', 'detailBooth', 'detailPaymentMethod', 'start_date_event', 'daysDifference'), ['type_menu' => 'detail-event']);
    }
}