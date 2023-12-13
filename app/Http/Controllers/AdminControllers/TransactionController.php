<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function indexTransaction()
    {
        $datas = DB::table('transaction')
            ->join('detail_member', 'transaction.id_member', '=', 'detail_member.id')
            ->join('users', 'detail_member.id', '=', 'users.id')
            ->join('detail_event', 'transaction.id_event', '=', 'detail_event.id')
            ->get();

        return view('admin.transaction', ['datas' => $datas], ['type_menu' => 'transaction']);
    }
}