<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HistoryTransactionController extends Controller
{
    public function indexHistoryTransaction()
    {
        $dataTransaction = DB::table('transaction')
            ->join('category_transaction', 'transaction.id_category', '=', 'category_transaction.id')
            ->join('detail_event', 'transaction.id_event', '=', 'detail_event.id')
            ->join('event_organizer', 'detail_event.id_eo', '=', 'event_organizer.id_user')
            ->join('users', 'event_organizer.id_user', '=', 'users.id')
            ->where('transaction.id_member', '=', auth()->user()->id)
            ->get();

        return view('member.detail.history-transaction', compact('dataTransaction'), ['type_menu' => 'history-transaction']);
    }
}