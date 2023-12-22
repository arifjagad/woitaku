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

    public function headerMember(){
        $data = DB::table('users')
            ->join('detail_member', 'users.id', '=', 'detail_member.id_member')
            ->select('users.*', 'detail_member.*')
            ->where('users.id', auth()->id())
            ->first();

        return $data;
    }
}