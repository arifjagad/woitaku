<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function homeMember()
    {
        $dataEvent = DB::table('detail_event')
            ->join('event_organizer', 'detail_event.id_eo', '=', 'event_organizer.id_user')
            ->join('users', 'event_organizer.id_user', '=', 'users.id')
            ->where('detail_event.verification', '=', 'accepted')
            ->get();

        return view('member.home', compact('dataEvent'), ['type_menu' => 'home']);
    }
}