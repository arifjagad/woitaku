<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('detail_event')->truncate();

        $users = DB::table('event_organizer')->pluck('id');

        foreach ($users as $data) {
            DB::table('detail_event')->insert([
                'id' => 1,
                'id_eo' => $data,
                'event_name' => 'Event A',
                'featured_image' => 'featured_image.jpg',
                'event_category' => 'Berbayar',
                'event_description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'start_date' => '2023-06-03',
                'end_date' => '2023-06-05',
                'city' => 'Kota A',
                'address' => 'Jl. A',
                'ticket_price' => 100000,
                'ticket_qty' => 100,
                'document' => 'document.pdf',
                'verification' => 'pending',
            ]);
        }
    }
}