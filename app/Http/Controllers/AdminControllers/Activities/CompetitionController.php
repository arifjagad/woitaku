<?php

namespace App\Http\Controllers\AdminControllers\Activities;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CompetitionController extends Controller
{
    public function indexCompetition()
    {
        $datas = DB::table('detail_competition')
            ->join('detail_event', 'detail_competition.id_event', '=', 'detail_event.id')
            ->join('users', 'detail_event.id_eo', '=', 'users.id')
            ->select('detail_competition.id',
                    'detail_competition.id_event',
                    'users.name', //Nama EO
                    'detail_event.event_name', 
                    'detail_competition.competition_name',
                    'detail_competition.competition_description',
                    'detail_competition.registration_date',
                    'detail_competition.registration_deadline',
                    'detail_competition.competition_start_date',
                    'detail_competition.competition_end_date',
                    'detail_competition.competition_category',
                    'detail_competition.competition_fee',
                    'detail_competition.participant_qty',
                    )
            ->get();

        return view('admin.activities.competition', ['datas' => $datas], ['type_menu' => 'competition']);
    }
}