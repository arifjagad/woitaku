<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use Intervention\Image\Facades\Image;


class DownloadTicketController extends Controller
{
    public function indexDownloadTicket()
    {
        /* $dataTicket = DB::table('users') */
        $dataTicket = DB::table('ticket')
            ->join('transaction', 'ticket.id_transaction', '=', 'transaction.id')
            ->join('category_transaction', 'transaction.id_category', '=', 'category_transaction.id')
            ->join('detail_event', 'transaction.id_event', '=', 'detail_event.id')
            ->get();

        $checkTransaction = DB::table('ticket')
            ->join('transaction', 'ticket.id_transaction', '=', 'transaction.id')
            ->where('transaction.id_member', '=', auth()->user()->id)
            ->get();

        return view ('member.detail.download-ticket', compact('dataTicket'), ['type_menu' => 'download-ticket']);
    }
}