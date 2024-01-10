<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\Ticket;

class DetailEventController extends Controller
{
    public function indexDetailEvent($id)
    {
        $detailEvent = DB::table('users')
            ->join('event_organizer', 'users.id', 'event_organizer.id_user')
            ->join('detail_event', 'users.id', 'detail_event.id_eo')
            ->where('detail_event.id', '=', $id)
            ->first();

        $listCompetition = DB::table('detail_event')
            ->join('detail_competition', 'detail_event.id', '=', 'detail_competition.id_event')
            ->where('detail_competition.id_event', '=', $id)
            ->get();

        $detailBooth = DB::table('detail_event')
            ->join('booth_rental', 'detail_event.id', '=', 'booth_rental.id_event')
            ->where('booth_rental.id_event', '=', $id)
            ->get();

        $detailPaymentMethod = DB::table('detail_event')
            ->join('payment_methods', 'detail_event.id_eo', '=', 'payment_methods.id_eo')
            ->where('detail_event.id', '=', $id)
            ->get();
            
        // 
        $start_date_event = Carbon::parse($detailEvent->start_date);
        $end_date_event = Carbon::parse($detailEvent->end_date);
        $daysDifference = $end_date_event->diffInDays($start_date_event);
        
        return view('member.detail-event', compact('detailEvent', 'detailCompetition', 'listCompetition', 'detailBooth', 'detailPaymentMethod', 'start_date_event', 'daysDifference'), ['type_menu' => 'detail-event']);
    }
    
    public function transactionTiket(Request $request){
        $event_id = session('event_id');

        $detailEvent = DB::table('detail_event')
            ->join('event_organizer', 'detail_event.id_eo', '=', 'event_organizer.id_user')
            ->where('detail_event.id', '=', $event_id)
            ->first();

        $selectedDate = $request->input('selected_date');
        $paymentMethodId = $request->input('payment_method');
        $ticketQuantity = $request->input('ticket_quantity');

        // Simpan data transaksi ke database
        $transaction = new Transaction();
        $transaction->id_member = auth()->user()->id;
        $transaction->id_event = $event_id;
        $transaction->preferred_date = $selectedDate;
        $transaction->qty = $ticketQuantity;
        $transaction->id_category = 1;
        $transaction->transaction_amout = $detailEvent->ticket_price * $ticketQuantity;
        $transaction->transaction_status = 'pending';
        $transaction->id_payment_methods = $paymentMethodId;
        
        $transaction->save();
        // Redirect ke route payment dengan membawa ID transaksi
        return redirect()->route('invoice', ['id' => $transaction->id]);
    }

    public function transactionTiketFree() {
        $event_id = session('event_id');
    
        // Cek apakah pengguna sudah terdaftar untuk event gratis ini
        $existingTransaction = Transaction::where('id_member', auth()->user()->id)
            ->where('id_event', $event_id)
            ->where('transaction_amout', '0')
            ->first();
    
        if ($existingTransaction) {
            // Jika pengguna sudah terdaftar, berikan pesan atau tindakan sesuai kebutuhan Anda
            toast('Anda sudah terdaftar untuk event ini.', 'info');
            return redirect()->back();
        }
    
        // Simpan data transaksi ke database
        $transaction = new Transaction();
        $transaction->id_member = auth()->user()->id;
        $transaction->id_event = $event_id;
        $transaction->preferred_date = now();
        $transaction->id_category = 1;
        $transaction->qty = 1;
        $transaction->transaction_amout = '0';
        $transaction->transaction_status = 'success';
        $transaction->id_payment_methods = null;
    
        $transaction->save();

        $ticket = new Ticket();
        $ticket->id_transaction = $transaction->id;
        $ticket->ticket_identifier = strtoupper(Str::random(6));
        $ticket->save();
    
        toast('Selamat, kamu sudah terdaftar!', 'success');
        return redirect()->back();
    }
    
}