<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\Ticket;
use App\Models\BoothRental;
use App\Models\DetailEvent;
use App\Models\DetailCompetition;
use App\Models\DetailBooth;


class DetailEventController extends Controller
{
    public function indexDetailEvent($eventName)
    {
        $slug = Str::slug($eventName);
        $eventName = DetailEvent::whereRaw("LOWER(REPLACE(event_name, ' ', '-')) = ?", $slug)->first();

        $id = $eventName->id;

        $detailEvent = DB::table('users')
            ->join('event_organizer', 'users.id', 'event_organizer.id_user')
            ->join('detail_event', 'users.id', 'detail_event.id_eo')
            ->where('detail_event.id', '=', $id)
            ->first();

        $listCompetition = DB::table('detail_event')
            ->join('detail_competition', 'detail_event.id', '=', 'detail_competition.id_event')
            ->where('detail_competition.id_event', '=', $id)
            ->orderBy('detail_competition.competition_name', 'asc')
            ->get();

        $boothCode = DB::table('detail_event')
            ->join('booth_rental', 'detail_event.id', '=', 'booth_rental.id_event')
            ->where('booth_rental.id_event', '=', $id)
            ->where('booth_rental.availability_status', '=', 'available')
            ->orderBy('booth_rental.booth_code', 'asc')
            ->get();

        $listBooth = DB::table('transaction')
            ->join('booth_rental', 'booth_rental.id', '=', 'transaction.id_booth_rental')
            ->join('detail_booth', 'detail_booth.id_booth_rental', '=', 'booth_rental.id')
            ->where('transaction.transaction_status', '=', 'success')
            ->whereNotNull('detail_booth.booth_name')
            ->whereNotNull('detail_booth.booth_description')
            ->whereNotNull('detail_booth.booth_image')
            ->where('booth_rental.id_event', '=', $id)
            ->orderBy('booth_rental.booth_code', 'asc')
            ->get();

        $detailPaymentMethod = DB::table('detail_event')
            ->join('payment_methods', 'detail_event.id_eo', '=', 'payment_methods.id_eo')
            ->where('detail_event.id', '=', $id)
            ->orderBy('payment_methods.bank_name', 'asc')
            ->get();

        $dataBooth = DB::table('detail_event')
            ->join('booth_rental', 'booth_rental.id_event', 'detail_event.id')
            ->where('booth_rental.id_event', '=', $id)
            ->where('booth_rental.booth_code', 'asc')
            ->get();

        $detailBooth = null; 
        
        // Periksa apakah permintaan datang melalui AJAX
        if (request()->ajax()) {
            $idBooth = request()->input('booth_code');
            $detailBooth = $this->getBoothInfo($idBooth);
            return response()->json(['detailBooth' => $detailBooth]);
        }

        $start_date_event = Carbon::parse($detailEvent->start_date);
        $end_date_event = Carbon::parse($detailEvent->end_date);
        $daysDifference = $end_date_event->diffInDays($start_date_event);
        
        return view('member.detail-event', compact('dataBooth', 'detailEvent', 'listCompetition', 'detailBooth', 'boothCode', 'listBooth', 'detailPaymentMethod', 'start_date_event', 'daysDifference'), ['type_menu' => 'detail-event']);
    }

    public function getBoothInfo($boothCode){
        $detailBooth = DB::table('detail_event')
            ->join('booth_rental', 'detail_event.id', '=', 'booth_rental.id_event')
            ->where('booth_rental.id', '=', $boothCode)
            ->where('booth_rental.availability_status', '=', 'available')
            ->first();

        // Menggunakan event_id yang sesuai dengan boothCode
        $event_id = $detailBooth->id_event;

        $detailPaymentMethod = DB::table('detail_event')
        ->join('payment_methods', 'detail_event.id_eo', '=', 'payment_methods.id_eo')
        ->where('detail_event.id', '=', $event_id)
        ->get(); 

        return response()->view('booth_info', ['detailBooth' => $detailBooth, 'detailPaymentMethod' => $detailPaymentMethod]);
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
        $transaction->transaction_amout = ($detailEvent->ticket_price * $ticketQuantity)+(mt_rand(1, 99));
        $transaction->transaction_status = 'pending';
        $transaction->id_payment_methods = $paymentMethodId;
        $transaction->expiration_time = Carbon::now()->addDay();
        
        $transaction->save();
        // Redirect ke route payment dengan membawa ID transaksi
        return redirect()->route('invoice', ['id' => $transaction->id]);
    }

    public function transactionTiketFree(Request $request) {
        $event_id = session('event_id');

        $dataEvent = DB::table('detail_event')
            ->where('detail_event.id', '=', $event_id)
            ->first();

        // Cek apakah pengguna sudah terdaftar untuk event gratis ini
        $checkTransactionEvent = Transaction::where('id_member', auth()->user()->id)
            ->where('id_event', $event_id)
            ->where('transaction_amout', '0')
            ->where('transaction.transaction_status', '=', 'success')
            ->first();
    
        if ($checkTransactionEvent) {
            // Jika pengguna sudah terdaftar, berikan pesan atau tindakan sesuai kebutuhan
            toast('Anda sudah terdaftar untuk event ini.', 'info');
            return redirect()->back();
        }
    
        // Simpan data transaksi ke database
        $transaction = new Transaction();
        $transaction->id_member = auth()->user()->id;
        $transaction->id_event = $event_id;
        $transaction->id_competition = null;
        $transaction->preferred_date = $dataEvent->start_date;
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
            ->where('id_event', $event_id)
            ->where('transaction.id_member', '=', $userId)
            ->where('transaction.transaction_status', '=', 'success')
            ->first();

        /* dd($checkTransactionEvent); */
            
        if(!$checkTransactionEvent){
            toast('Anda belum terdaftar untuk event ini.', 'info');
            return redirect()->back();
        }else{
            // Cek apakah pengguna sudah mendaftar untuk kompetisi tertentu
            $existingTransaction = Transaction::where('id_member', $userId)
            ->where(function ($query) use ($competitionId) {
                $query->where('id_competition', $competitionId);
            })
            ->first();

            // Jika transaksi sudah ada, berikan pesan kesalahan atau ambil tindakan lain
            if (!$existingTransaction) {
                if($detailCompetition->competition_fee != 0){
                    $paymentMethodId = $request->input('payment_method');
        
                    // Simpan data transaksi ke database
                    $transaction = new Transaction();
                    $transaction->id_member = auth()->user()->id;
                    $transaction->id_event = $event_id;
                    $transaction->id_competition = $competitionId;
                    $transaction->preferred_date = $detailCompetition->competition_start_date;
                    $transaction->qty = 1;
                    $transaction->id_category = 2;
                    $transaction->transaction_amout = ($detailCompetition->competition_fee)+(mt_rand(1, 99));;
                    $transaction->transaction_status = 'pending';
                    $transaction->id_payment_methods = $paymentMethodId;
                    $transaction->expiration_time = Carbon::now()->addDay();
        
                    
                    $transaction->save();
                    // Redirect ke route payment dengan membawa ID transaksi
                    return redirect()->route('invoice', ['id' => $transaction->id]);
                }else{
                    // Simpan data transaksi ke database
                    $transaction = new Transaction();
                    $transaction->id_member = auth()->user()->id;
                    $transaction->id_event = $event_id;
                    $transaction->id_competition = $competitionId;
                    $transaction->preferred_date = $detailCompetition->competition_start_date;
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
        $userId = auth()->user()->id;
        $event_id = session('event_id');
        $rentalBoothId = $request->input('rentalBooth_id');

        $detailEvent = DB::table('detail_event')
            ->join('event_organizer', 'detail_event.id_eo', '=', 'event_organizer.id_user')
            ->join('booth_rental', 'booth_rental.id_event', '=', 'detail_event.id')
            ->where('booth_rental.id', '=', $rentalBoothId)
            ->first();

        $paymentMethodId = $request->input('payment_method');

        // Cek apakah pengguna sudah mendaftar untuk booth tertentu
        $existingTransaction = DB::table('transaction')
            ->join('users', 'users.id', '=', 'transaction.id_member')
            ->join('detail_event', 'detail_event.id', '=', 'transaction.id_event')
            ->join('booth_rental', 'booth_rental.id', '=', 'transaction.id_booth_rental')
            ->where('transaction.id_member', '=', $userId)
            ->where('transaction.id_event', '=', $event_id)
            ->where('transaction.id_category', '=', '3')
            ->where(function ($query) {
                $query->where('transaction.transaction_status', '=', 'success')
                    ->orWhere('transaction.transaction_status', '=', 'pending');
            })
            ->count();
        
        // Jika transaksi sudah ada, berikan pesan kesalahan atau ambil tindakan lain
        if ($existingTransaction > 0) {
            toast('Anda sudah memiliki booth di event ini.', 'info');
            return redirect()->back();
        }elseif ($existingTransaction == 0){
            // Simpan data transaksi ke database
            $transaction = new Transaction();
            $transaction->id_member = auth()->user()->id;
            $transaction->id_event = $event_id;
            $transaction->id_competition = null;
            $transaction->id_booth_rental = $rentalBoothId;
            $transaction->preferred_date = $detailEvent->start_date;
            $transaction->qty = 1;
            $transaction->id_category = 3;
            $transaction->transaction_amout = ($detailEvent->rental_price)+(mt_rand(1, 99));;
            $transaction->transaction_status = 'pending';
            $transaction->id_payment_methods = $paymentMethodId;
            $transaction->expiration_time = Carbon::now()->addDay();


            $transaction->save();
            // Redirect ke route payment dengan membawa ID transaksi
            return redirect()->route('invoice', ['id' => $transaction->id]);
        }
    }
}