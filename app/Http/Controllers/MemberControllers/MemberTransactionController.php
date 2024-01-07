<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\DetailEvent;

class MemberTransactionController extends Controller
{
    public function indexMemberTransaction()
    {
        $event_id = session('event_id');
        $dataEvent = DetailEvent::find($event_id);

        return view ('member.transaction', compact('dataEvent'));
    }
}