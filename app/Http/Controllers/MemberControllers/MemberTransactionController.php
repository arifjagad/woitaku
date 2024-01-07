<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;

class MemberTransactionController extends Controller
{
    public function indexMemberTransaction()
    {
        return view ('member.transaction');
    }
}