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

class ListTransactionController extends Controller
{
    public function indexListTransaction(Request $request){
        $authId = auth()->id();
        $selectedEventId = request('event_id');

        Log::info('Event ID: ' . $selectedEventId);

        $dataEvent = DB::table('detail_event')
            ->where('detail_event.id_eo', $authId)
            ->get();
        
        $dataTransaction = DB::table('transaction')
            ->join('detail_event', 'detail_event.id', '=', 'transaction.id_event')
            ->join('users as eo', 'eo.id', '=', 'detail_event.id_eo')
            ->join('users as member', 'member.id', '=', 'transaction.id_member')
            ->join('payment_methods', 'payment_methods.id', '=', 'transaction.id_payment_methods')
            ->where('eo.id', $authId)
            ->when($selectedEventId, function ($query) use ($selectedEventId) {
                $query->where('detail_event.id', $selectedEventId);
            })
            ->select(
                'eo.name as eo_name',
                'member.name as member_name',
                'detail_event.*',
                'payment_methods.*',
                'transaction.*'
            )
            ->orderBy('transaction.updated_at', 'desc')
            ->get();

        if($dataEvent->isEmpty()){
            toast('You must create an event first', 'error');
            return redirect()->route('event-eo');
        }else{
            return view ('event_organizer.list-transaction', compact('dataEvent', 'dataTransaction'), ['type_menu' => 'participant-list']);
        }
    }

    public function acceptTransaction($id){
        $transactionId = Transaction::find($id);
        $transactionId->transaction_status = 'success';
        $transactionId->save();
        
        toast('Transaksi kamu terima.', 'success');
        return redirect()->back();
    }

    public function rejectTransaction($id){
        $transactionId = Transaction::find($id);
        $transactionId->transaction_status = 'failed';
        $transactionId->save();
        
        // Memeriksa apakah id_category adalah 3
        if ($transactionId->id_category == 1){
            $detailEvent = DetailEvent::find($transactionId->id_event);

            // Memperbarui status booth_rental menjadi 'available'
            $detailEvent->ticket_qty = $detailEvent->ticket_qty + $transactionId->qty;
            $detailEvent->save();

        } elseif ($transactionId->id_category == 2) {
            $detailCompetition = DetailCompetition::find($transactionId->id_competition);

            $detailCompetition->ticket_qty = $detailCompetition->participant_qty + $transactionId->qty;
            $detailCompetition->save();
        
        }elseif ($transactionId->id_category == 3) {
            $boothRental = BoothRental::find($transactionId->id_booth_rental);

            $boothRental->availability_status = 'available';
            $boothRental->save();
        }

        toast('Transaksi kamu tolak.', 'success');
        return redirect()->back();
    }
}