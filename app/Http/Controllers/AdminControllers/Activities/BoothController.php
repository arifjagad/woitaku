<?php

namespace App\Http\Controllers\AdminControllers\Activities;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BoothController extends Controller
{
    public function indexBooth()
    {
        $datas = DB::table('booth_rental')
            ->join('detail_event', 'booth_rental.id_event', '=', 'detail_event.id')
            ->join('users', 'detail_event.id_eo', '=', 'users.id')
            ->get();

        return view('admin.activities.booth', ['datas' => $datas], ['type_menu' => 'booth']);
    }

}