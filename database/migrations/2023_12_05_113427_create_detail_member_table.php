<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailMemberTable extends Migration
{
    public function up()
    {
        Schema::create('detail_member', function (Blueprint $table) {
            $table->foreignId('id')->constrained('users')->primary(); // Kolom foreign key dan primary key
            $table->string('foto_profile');
            $table->string('kota');
            $table->string('nomor_whatsapp');
            // Tambahkan kolom lain sesuai kebutuhan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_member');
    }
}
