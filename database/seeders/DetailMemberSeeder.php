<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DetailMemberSeeder extends Seeder
{
    public function run()
    {
        // Hapus data existing jika diperlukan
        DB::table('detail_member')->truncate();

        // Ambil id dari tabel users
        $users  = DB::table('users')->where('usertype', 'member')->pluck('id');

        // Masukkan data menggunakan DB::insert
        foreach ($users as $data) {
            DB::table('detail_member')->insert([
                'id' => $data, // Sesuaikan dengan id dari tabel users
                'foto_profile' => 'profile.jpg',
                'kota' => 'City A',
                'nomor_whatsapp' => '1234567890',
            ]);
        }
    }
}
