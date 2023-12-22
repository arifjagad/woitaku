<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CompetitionController extends Controller
{
    public function indexCompetition()
    {
        $datas = DB::table('detail_competition')
            ->join('detail_event', 'detail_competition.id_event', '=', 'detail_event.id')
            ->join('competition_category', 'detail_competition.id_competition_category', '=', 'competition_category.id')
            ->join('users', 'detail_event.id_eo', '=', 'users.id')
            ->get();
            
        return view('admin.competition', compact('datas'), ['type_menu' => 'competition']);
    }
}