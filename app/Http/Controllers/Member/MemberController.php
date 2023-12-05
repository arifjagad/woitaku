<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function indexMember()
    {
        $datas = DB::table('detail_member')
            ->join('users', 'detail_member.id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.email', 'detail_member.foto_profile', 'detail_member.kota', 'detail_member.nomor_whatsapp', 'detail_member.created_at')
            ->get();

        return view('pages.member.member', ['datas' => $datas], ['type_menu' => 'member']);
    }

    public function indexEventOrganizer(){
        $datas = DB::table('event_organizer')
            ->join('users', 'event_organizer.id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.email', 'event_organizer.description', 'event_organizer.foto_profile', 'event_organizer.alamat', 'event_organizer.kota', 'event_organizer.nomor_whatsapp', 'event_organizer.created_at')
            ->get();

        return view('pages.member.event-organizer', ['datas' => $datas], ['type_menu' => 'event-organizer']);
    }
}