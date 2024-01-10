<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class DownloadTicketController extends Controller
{
    public function indexDownloadTicket()
    {
        $dataTicket = DB::table('users')
            ->join('detail_event', 'detail_event.id_eo', '=', 'users.id')
            ->join('transaction', 'transaction.id_event', '=', 'detail_event.id')
            ->join('category_transaction', 'category_transaction.id', '=', 'transaction.id_category')
            ->join('ticket', 'ticket.id_transaction', '=', 'transaction.id')
            ->get();

        return view ('member.detail.download-ticket', compact('dataTicket'), ['type_menu' => 'download-ticket']);
    }

    public function downloadTicket($id){
        $authId = Auth::id();

        $dataUser = DB::table('users')
            ->where('users.id', '=', $authId)
            ->select('users.*')
            ->first();
        
        $dataTicket = DB::table('users')
            ->join('detail_event', 'detail_event.id_eo', '=', 'users.id')
            ->join('transaction', 'transaction.id_event', '=', 'detail_event.id')
            ->join('category_transaction', 'category_transaction.id', '=', 'transaction.id_category')
            ->join('ticket', 'ticket.id_transaction', '=', 'transaction.id')
            ->where('ticket.id', $id)
            ->select('users.*', 'detail_event.*', 'category_transaction.*', 'transaction.*', 'ticket.*')
            ->first();

        $dataTicketBuy = DB::table('transaction')
            ->join('ticket', 'ticket.id_transaction', '=', 'transaction.id')
            ->where('ticket.id', $id)
            ->select('transaction.*')
            ->first();

        $pdfContent = view('layouts.ticket-event', compact('dataTicket', 'dataUser', 'dataTicketBuy'))->render();
        // Set up Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($pdfContent);

        // Set paper size (optional)
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (output)
        $dompdf->render();

        // Stream PDF file to the browser
        return $dompdf->stream('Tiket Event - ' . $dataTicket->event_name . '.pdf', compact('dataTicket'));
    }

    public function downloadTicketCompetition($id){
        $authId = Auth::id();

        $dataUser = DB::table('users')
            ->where('users.id', '=', $authId)
            ->select('users.*')
            ->first();
        
        $dataTicket = DB::table('users')
            ->join('detail_event', 'detail_event.id_eo', '=', 'users.id')
            ->join('detail_competition', 'detail_competition.id_event', '=', 'detail_event.id')
            ->join('transaction', 'transaction.id_event', '=', 'detail_event.id')
            ->join('category_transaction', 'category_transaction.id', '=', 'transaction.id_category')
            ->join('ticket', 'ticket.id_transaction', '=', 'transaction.id')
            ->where('ticket.id', $id)
            ->select('users.*', 'detail_event.*', 'detail_competition.*', 'category_transaction.*', 'transaction.*', 'ticket.*')
            ->first();

        $dataTicketBuy = DB::table('transaction')
            ->join('ticket', 'ticket.id_transaction', '=', 'transaction.id')
            ->where('ticket.id', $id)
            ->select('transaction.*')
            ->first();

        $pdfContent = view('layouts.ticket-competition', compact('dataTicket', 'dataUser', 'dataTicketBuy'))->render();
        // Set up Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($pdfContent);

        // Set paper size (optional)
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (output)
        $dompdf->render();

        // Stream PDF file to the browser
        return $dompdf->stream('Tiket Competition - ' . $dataTicket->event_name . '.pdf', compact('dataTicket'));
    }

    public function downloadTicketBooth($id){
        $authId = Auth::id();

        $dataUser = DB::table('users')
            ->where('users.id', '=', $authId)
            ->select('users.*')
            ->first();
        
        $dataTicket = DB::table('users')
            ->join('detail_event', 'detail_event.id_eo', '=', 'users.id')
            ->join('booth_rental', 'booth_rental.id_event', '=', 'detail_event.id')
            ->join('transaction', 'transaction.id_event', '=', 'detail_event.id')
            ->join('category_transaction', 'category_transaction.id', '=', 'transaction.id_category')
            ->join('ticket', 'ticket.id_transaction', '=', 'transaction.id')
            ->where('ticket.id', $id)
            ->select('users.*', 'detail_event.*', 'booth_rental.*', 'category_transaction.*', 'transaction.*', 'ticket.*')
            ->first();

        $dataTicketBuy = DB::table('transaction')
            ->join('ticket', 'ticket.id_transaction', '=', 'transaction.id')
            ->where('ticket.id', $id)
            ->select('transaction.*')
            ->first();

        $pdfContent = view('layouts.ticket-booth', compact('dataTicket', 'dataUser', 'dataTicketBuy'))->render();
        // Set up Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($pdfContent);

        // Set paper size (optional)
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (output)
        $dompdf->render();

        // Stream PDF file to the browser
        return $dompdf->stream('Tiket Booth - ' . $dataTicket->event_name . '.pdf', compact('dataTicket'));
    }
}