<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoothRentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('booth_rental')->truncate();

        $users = DB::table('detail_event')->pluck('id');

        foreach ($users as $data) {
            DB::table('booth_rental')->insert([
                'id' => 1,
                'id_event' => $data,
                'booth_name' => 'Booth A',
                'booth_size' => '10x10 ft',
                'booth_location' => 'Hall A - No. 6',
                'provided_facilities' => 'Electricity, WiFi',
                'booth_description' => 'A cozy booth with...',
                'rental_price' => 500000,
                'rental_time_limit' => '3 days',
                'admin_phone' => '082167565321',
                'availability_status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
