<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class EventOrganizerSeeder extends Seeder
{
    public function run()
    {
        // Hapus data existing jika diperlukan
        DB::table('event_organizer')->truncate();

        // Ambil id dari tabel users
        $users  = DB::table('users')->where('usertype', 'event organizer')->pluck('id');

        // Masukkan data menggunakan DB::insert
        foreach ($users as $data) {
            DB::table('event_organizer')->insert([
                'id' => $data, // Sesuaikan dengan id dari tabel users
                'foto_profile' => 'profile.jpg',
                'alamat' => 'Alamat A',
                'kota' => 'City A',
                'nomor_whatsapp' => '1234567890',
            ]);
        }
    }
}