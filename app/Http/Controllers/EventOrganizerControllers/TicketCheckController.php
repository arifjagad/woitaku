<?php

namespace App\Http\Controllers\EventOrganizerControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TicketCheckController extends Controller
{
    public function indexTicketCheck(){
        $user = Auth::user();

        $currentDate = Carbon::now()->toDateString();
        $dataEvent = DB::table('detail_event')
            ->where('detail_event.id_eo', $user->id)
            ->whereDate('detail_event.start_date', '<=', $currentDate)
            ->whereDate('detail_event.end_date', '>=', $currentDate)
            ->get();

        return view ('event_organizer.ticket-check', compact('dataEvent'), ['type_menu' => 'ticket-check']);
    }

    public function checkTicket(Request $request){
        $eventId = $request->input('event_name');
        $ticketId = $request->input('ticket_identifier');

        if($ticketId == null){
            alert()->warning('Silahkan isi ID tiket');
            return redirect()->back();
        }

        $checkTicket = DB::table('ticket')
            ->join('transaction', 'transaction.id', '=', 'ticket.id_transaction')
            ->join('detail_event', 'detail_event.id', '=', 'transaction.id_event')
            ->join('users', 'users.id', '=', 'transaction.id_member')
            ->where('ticket_identifier', $ticketId)
            ->where('detail_event.id', $eventId)
            ->select('ticket.*', 'transaction.*', 'detail_event.*', 'users.*', 'detail_event.id as detail_event_id')
            ->first();

        if($checkTicket && $checkTicket->status == 'used'){
            alert()->warning('Tiket sudah digunakan', "Silakan periksa kembali ID-nya");
        } elseif ($checkTicket && $checkTicket->detail_event_id != $eventId){
            alert()->warning('Tiket tidak asdasdas', "Silakan periksa kembali ID-nya");
        } elseif ($checkTicket && $checkTicket->preferred_date != date('Y-m-d')) {
            $preferredDate = Carbon::parse($checkTicket->preferred_date)->translatedFormat('l, d F Y');
            
            alert()->warning('Tanggal kedatangan tidak sesuai', "Harap datang pada tanggal $preferredDate");
        } elseif ($checkTicket) {
            DB::table('ticket')
                ->where('ticket_identifier', $ticketId)
                ->update(['status' => 'used']);

            alert()->success('Tiket ditemukan', "Dengan nama pengguna $checkTicket->name");
        }else{
            alert()->warning('Tiket tidak ditemukan', "Silakan periksa kembali ID-nya");
        }

        return redirect()->back();

    }
}