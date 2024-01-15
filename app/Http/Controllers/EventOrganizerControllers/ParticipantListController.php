<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
USE App\Models\Transaction;

class ParticipantListController extends Controller
{
    public function indexParticipantList(Request $request){
        $authId = auth()->id();
        $selectedEventId = request('event_id');

        Log::info('Event ID: ' . $selectedEventId);

        $dataEvent = DB::table('detail_event')
            ->where('detail_event.id_eo', $authId)
            ->get();
        
        $dataTransaction = DB::table('users')
            ->join('detail_event', 'detail_event.id_eo', '=', 'users.id')
            ->join('transaction', 'transaction.id_event', '=', 'detail_event.id')
            ->join('payment_methods', 'payment_methods.id', '=', 'transaction.id_payment_methods')
            ->where('detail_event.id_eo', $authId)
            ->when($selectedEventId, function ($query) use ($selectedEventId) {
                $query->where('detail_event.id', $selectedEventId);
            })
            ->orderByDesc('transaction.created_at')
            ->select('users.*', 'detail_event.*', 'payment_methods.*', 'transaction.*')
            ->get();

        if($dataEvent->isEmpty()){
            toast('You must create an event first!', 'error');
            return redirect()->route('event-eo');
        }else{
            return view ('event_organizer.participant-list', compact('dataEvent', 'dataTransaction'), ['type_menu' => 'participant-list']);
        }
    }

    public function acceptTransaction($id){
        $datas = Transaction::find($id);
        $datas->transaction_status = 'success';
        $datas->save();
        
        toast('Transaksi kamu terima.', 'success');
        return redirect()->back();
    }

    public function rejectTransaction($id){
        $transactionId = Transaction::find($id);
        $transactionId->transaction_status = 'failed';
        $transactionId->save();
        
        toast('Transaksi kamu tolak.', 'success');
        return redirect()->back();
    }
}