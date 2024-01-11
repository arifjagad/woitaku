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

        /* $listBooth = DB::table('detail_event')
            ->join('booth_rental', 'booth_rental.id_event', '=', 'detail_event.id')
            ->join('detail_booth', 'detail_booth.id_booth_rental', '=', 'booth_rental.id')
            ->where('booth_rental.id_event', '=', $id)
            ->get(); */

        $listBooth = DB::table('transaction')
            ->join('booth_rental', 'booth_rental.id', '=', 'transaction.id_booth_rental')
            ->join('detail_booth', 'detail_booth.id_booth_rental', '=', 'booth_rental.id')
            ->where('transaction.transaction_status', '=', 'success')
            ->whereNotNull('detail_booth.booth_name')
            ->whereNotNull('detail_booth.booth_description')
            ->whereNotNull('detail_booth.booth_image')
            ->get();
        
            

        $detailPaymentMethod = DB::table('detail_event')
            ->join('payment_methods', 'detail_event.id_eo', '=', 'payment_methods.id_eo')
            ->where('detail_event.id', '=', $id)
            ->get();
            
        $start_date_event = Carbon::parse($detailEvent->start_date);
        $end_date_event = Carbon::parse($detailEvent->end_date);
        $daysDifference = $end_date_event->diffInDays($start_date_event);
        
        return view('member.detail-event', compact('detailEvent', 'listCompetition', 'detailBooth', 'listBooth', 'detailPaymentMethod', 'start_date_event', 'daysDifference'), ['type_menu' => 'detail-event']);
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
        $transaction->id_booth_rental = null;
        $transaction->preferred_date = $selectedDate;
        $transaction->qty = $ticketQuantity;
        $transaction->id_category = 1;
        $transaction->transaction_amout = $detailEvent->ticket_price * $ticketQuantity;
        $transaction->transaction_status = 'pending';
        $transaction->id_payment_methods = $paymentMethodId;
        $transaction->expiration_time = Carbon::now()->addDay();
        
        $transaction->save();
        // Redirect ke route payment dengan membawa ID transaksi
        return redirect()->route('invoice', ['id' => $transaction->id]);
    }

    public function transactionTiketFree(Request $request) {
        $event_id = session('event_id');
        $competitionId = $request->input('competition_id');

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
        $transaction->id_competition = $competitionId;
        $transaction->preferred_date = now();
        $transaction->id_category = 1;
        $transaction->qty = 1;
        $transaction->transaction_amout = '0';
        $transaction->transaction_status = 'success';
        $transaction->id_payment_methods = null;
        $transaction->expiration_time = null;

    
        $transaction->save();

        $ticket = new Ticket();
        $ticket->id_transaction = $transaction->id;
        $ticket->ticket_identifier = strtoupper(Str::random(6));
        $ticket->save();
    
        toast('Selamat, kamu sudah terdaftar!', 'success');
        return redirect()->back();
    }

    public function transactionCompetition(Request $request){
        $userId = auth()->user()->id;
        $event_id = session('event_id');

        $competitionId = $request->input('competition_id');
        $detailCompetition = DB::table('detail_event')
            ->join('detail_competition', 'detail_event.id', '=', 'detail_competition.id_event')
            ->where('detail_competition.id', '=', $competitionId)
            ->first();

        $checkTransactionEvent = DB::table('transaction')
            ->join('detail_event', 'detail_event.id', '=', 'transaction.id_event')
            ->where('transaction.id_category', '=', '1')
            ->where('transaction.id_member', '=', $userId)
            ->where('transaction.transaction_status', '=', 'success')
            ->first();
            
        if(!$checkTransactionEvent){
            toast('Anda belum terdaftar untuk event ini.', 'info');
            return redirect()->back();
        }else{
            // Cek apakah pengguna sudah mendaftar untuk event atau kompetisi tertentu
            $existingTransaction = Transaction::where('id_member', $userId)
            ->where(function ($query) use ($competitionId) {
                $query->where('id_competition', $competitionId);
            })
            ->first();

            // Jika transaksi sudah ada, berikan pesan kesalahan atau ambil tindakan lain
            if (!$existingTransaction) {
                if($detailCompetition->competition_fee != 0 || $detailCompetition->competition_fee != null){
                    $paymentMethodId = $request->input('payment_method');
        
                    // Simpan data transaksi ke database
                    $transaction = new Transaction();
                    $transaction->id_member = auth()->user()->id;
                    $transaction->id_event = $event_id;
                    $transaction->id_competition = $competitionId;
                    $transaction->preferred_date = null;
                    $transaction->qty = 1;
                    $transaction->id_category = 2;
                    $transaction->transaction_amout = $detailCompetition->competition_fee;
                    $transaction->transaction_status = 'pending';
                    $transaction->id_payment_methods = $paymentMethodId;
                    $transaction->expiration_time = Carbon::now()->addDay();
        
                    
                    $transaction->save();
                    // Redirect ke route payment dengan membawa ID transaksi
                    return redirect()->route('invoice', ['id' => $transaction->id]);
                }else{
                    // Cek apakah pengguna sudah terdaftar untuk perlombaan ini
                    $existingTransaction = Transaction::join('detail_competition', 'transaction.id_event', '=', 'detail_competition.id_event')
                        ->where('transaction.id_member', auth()->user()->id)
                        ->where('transaction.id_event', $event_id)
                        ->where('transaction.transaction_amout', 0)
                        ->first();
        
                    if ($existingTransaction) {
                        // Jika pengguna sudah terdaftar, berikan pesan atau tindakan sesuai kebutuhan Anda
                        toast('Anda sudah terdaftar untuk perlombaan ini.', 'info');
                        return redirect()->back();
                    }
        
                    // Simpan data transaksi ke database
                    $transaction = new Transaction();
                    $transaction->id_member = auth()->user()->id;
                    $transaction->id_event = $event_id;
                    $transaction->preferred_date = null;
                    $transaction->qty = 1;
                    $transaction->id_category = 2;
                    $transaction->transaction_amout = null;
                    $transaction->transaction_status = 'success';
                    $transaction->id_payment_methods = null;
                    $transaction->expiration_time = null;
        
                    
                    $transaction->save();
            
                    // Simpan data transaksi ke database
                    $ticket = new Ticket();
                    $ticket->id_transaction = $transaction->id;
                    $ticket->ticket_identifier = strtoupper(Str::random(6));
            
                    $ticket->save();
                
                    toast('Selamat, kamu sudah terdaftar!', 'success');
                    return redirect()->route('history-transaction');
                }
            }else{
                toast('Anda sudah terdaftar untuk perlombaan ini.', 'info');
                return redirect()->back();
            }
        }
    }

    public function transactionBooth(Request $request){
        $event_id = session('event_id');
        $rentalBoothId = $request->input('rentalBooth_id');

        $detailEvent = DB::table('detail_event')
            ->join('event_organizer', 'detail_event.id_eo', '=', 'event_organizer.id_user')
            ->join('booth_rental', 'booth_rental.id_event', '=', 'detail_event.id')
            ->where('booth_rental.id', '=', $rentalBoothId)
            ->first();
        
        $paymentMethodId = $request->input('payment_method');

        // Simpan data transaksi ke database
        $transaction = new Transaction();
        $transaction->id_member = auth()->user()->id;
        $transaction->id_event = $event_id;
        $transaction->id_competition = null;
        $transaction->id_booth_rental = $rentalBoothId;
        $transaction->preferred_date = null;
        $transaction->qty = 1;
        $transaction->id_category = 3;
        $transaction->transaction_amout = $detailEvent->rental_price;
        $transaction->transaction_status = 'pending';
        $transaction->id_payment_methods = $paymentMethodId;
        $transaction->expiration_time = Carbon::now()->addDay();

        
        $transaction->save();
        // Redirect ke route payment dengan membawa ID transaksi
        return redirect()->route('invoice', ['id' => $transaction->id]);
    }
}