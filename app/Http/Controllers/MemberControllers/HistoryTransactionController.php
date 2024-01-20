<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class HistoryTransactionController extends Controller
{
    public function indexHistoryTransaction()
    {
        $authId = auth()->user()->id;

        $dataTransaction = DB::table('users')
            ->join('event_organizer', 'event_organizer.id_user', '=', 'users.id')
            ->join('detail_event', 'detail_event.id_eo', '=', 'event_organizer.id_user')
            ->join('transaction', 'transaction. ', '=', 'detail_event.id')
            ->join('category_transaction', 'transaction.id_category', '=', 'category_transaction.id')
            ->select('detail_event.*', 'category_transaction.*', 'users.*', 'transaction.*')
            ->where('transaction.id_member', '=', $authId)
            ->orderBy('transaction.updated_at', 'desc')
            ->get();
            
        return view('member.detail.history-transaction', compact('dataTransaction'), ['type_menu' => 'history-transaction']);
    }
}