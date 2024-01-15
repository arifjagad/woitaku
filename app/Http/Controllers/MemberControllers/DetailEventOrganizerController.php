<?php

namespace App\Http\Controllers\MemberControllers;

use App\Http\Controllers\Controller;
use App\Models\EventOrganizer;
use App\Models\User;
use Illuminate\Support\Str;

class DetailEventOrganizerController extends Controller
{
    public function indexDetailEventOrganizer($eoName)
    {
        $slug = Str::slug($eoName);
        $eventOrganizer = User::whereRaw("LOWER(REPLACE(name, ' ', '-')) = ?", $slug)->first();

        return view ('member.detail-event-organizer', compact('eventOrganizer'), ['type_menu' => 'detail-event-organizer']);
    }
}