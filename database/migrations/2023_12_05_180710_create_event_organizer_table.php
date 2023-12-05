<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_organizer', function (Blueprint $table) {
            $table->foreignId('id')->constrained('users')->primary(); // Kolom foreign key dan primary key
            $table->string('foto_profile');
            $table->string('alamat');
            $table->string('kota');
            $table->string('nomor_whatsapp');
            // Tambahkan kolom lain sesuai kebutuhan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_organizer');
    }
};
