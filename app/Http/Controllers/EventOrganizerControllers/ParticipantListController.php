<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;
use App\Models\BoothRental;
use App\Models\DetailEvent;
use App\Models\DetailCompetition;

class ParticipantListController extends Controller
{
    public function indexParticipantList(Request $request){
        $authId = auth()->id();
        $selectedEventId = request('event_id');

        Log::info('Event ID: ' . $selectedEventId);

        $dataEvent = DB::table('detail_event')
            ->where('detail_event.id_eo', $authId)
            ->get();
        
        $dataTicket = DB::table('users')
            ->join('detail_event', 'detail_event.id_eo', '=', 'users.id')
            ->join('transaction', 'transaction.id_event', '=', 'detail_event.id')
            ->join('payment_methods', 'payment_methods.id', '=', 'transaction.id_payment_methods')
            ->join('ticket', 'ticket.id_transaction', '=', 'transaction.id')
            ->where('detail_event.id_eo', $authId)
            ->when($selectedEventId, function ($query) use ($selectedEventId) {
                $query->where('detail_event.id', $selectedEventId);
            })
            ->select('users.*', 'detail_event.*', 'payment_methods.*', 'transaction.*', 'ticket.*')
            ->orderBy('ticket.updated_at', 'desc')
            ->get();

        if($dataEvent->isEmpty()){
            toast('You must create an event first', 'error');
            return redirect()->route('event-eo');
        }else{
            return view ('event_organizer.participant-list', compact('dataEvent', 'dataTicket'), ['type_menu' => 'participant-list']);
        }
    }
}