<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function indexMember()
    {
        return view('member.index', ['type_menu' => 'index']);
    }
}