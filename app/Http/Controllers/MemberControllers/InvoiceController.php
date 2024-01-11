<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\DetailEvent;

class InvoiceController extends Controller
{
    public function indexInvoice($id)
    {
        $dataTransaction = DB::table('transaction')
            ->join('payment_methods', 'payment_methods.id', '=', 'transaction.id_payment_methods')
            ->where('transaction.id', '=', $id)
            ->first();

        $dataTransactionEvent = DB::table('transaction')
            ->join('detail_event', 'detail_event.id', '=', 'transaction.id_event')
            ->join('payment_methods', 'payment_methods.id', '=', 'transaction.id_payment_methods')
            ->where('transaction.id', '=', $id)
            ->first();

        $dataTransactionCompetition = DB::table('transaction')
            ->join('detail_competition', 'detail_competition.id', 'transaction.id_competition')
            ->join('payment_methods', 'payment_methods.id', '=', 'transaction.id_payment_methods')
            ->where('transaction.id', '=', $id)
            ->first();

        $dataTransactionBooth = DB::table('transaction')
            ->join('booth_rental', 'booth_rental.id', 'transaction.id_booth_rental')
            ->join('payment_methods', 'payment_methods.id', '=', 'transaction.id_payment_methods')
            ->where('transaction.id', '=', $id)
            ->first();

        return view ('member.invoice', compact('dataTransaction', 'dataTransactionEvent', 'dataTransactionCompetition', 'dataTransactionBooth'));
    }
}