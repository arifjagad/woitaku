<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HeaderController extends Controller
{
    public function headerEventOrganizer(){
        $data = DB::table('users')
            ->join('event_organizer', 'users.id', '=', 'event_organizer.id_user')
            ->select('users.*', 'event_organizer.*')
            ->where('users.id', auth()->id())
            ->first();

        return $data;
    }
}