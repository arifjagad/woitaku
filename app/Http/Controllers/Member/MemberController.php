<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member\Member;
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
}