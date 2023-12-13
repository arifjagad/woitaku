<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth; // Add this line

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        if (Auth::check()) { // Fix the problem by importing the Auth class
            $usertype = Auth::user()->usertype;

            if ($usertype == 'admin') {
                return view('admin.dashboard');
            } elseif ($usertype == 'event organizer') {
                return view('event_organizer.dashboard');
            } elseif ($usertype == 'member') {
                return view('member.index');
            } else {
                return redirect()->back()->with('error', 'Tipe pengguna tidak dikenali.');
            }
        } else {
            return redirect()->back()->with('error', 'Anda belum login.');
        }
    }
}
