<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use App\Models\DetailEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SettingBoothController extends Controller
{
    public function indexSettingBooth()
    {
        $authId = auth()->user()->id;
        dd($authId);
        $dataBooth = DB::table('users')
            ->join('event_organizer', 'event_organizer.id_user', '=', 'users.id')
            ->join('detail_event', 'detail_event.id_eo', '=', 'event_organizer.id_user')
            ->join('transaction', 'transaction.id_event', '=', 'detail_event.id')
            ->join('booth_rental', 'booth_rental.id_event', '=', 'detail_event.id')
            ->select('detail_event.*', 'users.*', 'booth_rental.*')
            ->where('users.id', '=', $authId)
            ->get();
            
        dd($dataBooth);

        return view ('member.detail.setting-booth', compact('dataBooth'), ['type_menu' => 'setting-booth']);
    }
}