<?php

namespace App\Http\Controllers\Activities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Activities\Event;
use Illuminate\Support\Facades\Session;

class BoothController extends Controller
{
    public function indexBooth()
    {
        $datas = DB::table('booth_rental')
            ->join('detail_event', 'booth_rental.id_event', '=', 'detail_event.id')
            ->join('users', 'detail_event.id_eo', '=', 'users.id')
            ->get();

        return view('pages.activities.booth', ['datas' => $datas], ['type_menu' => 'booth']);
    }

}