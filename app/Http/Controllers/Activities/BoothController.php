<?php

namespace App\Http\Controllers\Activities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Activities\Event;
use Illuminate\Support\Facades\Session;

class BoothController extends Controller
{
    public function indexBooth()
    {
        return view('pages.activities.booth', ['type_menu' => 'booth']);
    }
}