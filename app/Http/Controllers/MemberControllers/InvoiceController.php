<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\DetailEvent;

class InvoiceController extends Controller
{
    public function indexInvoice()
    {
        $event_id = session('event_id');
        $dataEvent = DetailEvent::find($event_id);
        $dataTransaction = DB::table('transaction')
            ->join('users', 'transaction.id_member', '=', 'users.id')
            ->join('detail_event', 'transaction.id_event', '=', 'detail_event.id')
            ->join('payment_methods', 'transaction.id_payment_methods', '=', 'payment_methods.id')
            ->select('transaction.*', 'users.name', 'detail_event.event_name', 'payment_methods.*')
            ->where('transaction.id_event', '=', $event_id)
            ->first();

        return view ('member.invoice', compact('dataEvent', 'dataTransaction'));
    }
}