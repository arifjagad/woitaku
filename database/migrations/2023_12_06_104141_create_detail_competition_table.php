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
        Schema::create('detail_competition', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_event')->constrained('detail_event')->onDelete('cascade'); // Kolom foreign key dan primary key
            $table->string('competition_name');
            $table->string('competition_description');
            $table->string('registration_date');
            $table->string('registration_deadline');
            $table->string('competition_start_date');
            $table->string('competition_end_date');
            $table->string('competition_caregory');
            $table->string('competition_fee');
            $table->string('participant_qty');
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
        Schema::dropIfExists('detail_competition');
    }
};
