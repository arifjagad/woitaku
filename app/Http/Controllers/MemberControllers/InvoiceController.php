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
            ->select('payment_methods.*', 'transaction.*')
            ->where('transaction.id', '=', $id)
            ->first();

        return view ('member.invoice', compact('dataTransaction'));
    }
}