<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailCompetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_competition')->truncate();

        $users = DB::table('detail_event')->pluck('id');

        foreach ($users as $data) {
            DB::table('detail_competition')->insert([
                'id' => 1,
                'id_event' => $data,
                'competition_name' => 'Lomba Desain Poster',
                'competition_description' => 'Lomba Desain Poster',
                'registration_date' => '2021-01-01',
                'registration_deadline' => '2021-01-31',
                'competition_start_date' => '2021-02-01',
                'competition_end_date' => '2021-02-28',
                'competition_category' => 'Desain',
                'competition_fee' => 50000,
                'participant_qty' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
