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
        Schema::create('detail_event', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_eo')->constrained('event_organizer')->onDelete('cascade'); // Kolom foreign key dan primary key
            $table->string('event_name');
            $table->string('featured_image');
            $table->string('event_category');
            $table->string('event_description');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('city');
            $table->string('address');
            $table->integer('ticket_price');
            $table->integer('ticket_qty');
            $table->string('document');
            $table->string('verification');
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
        Schema::dropIfExists('detail_event');
    }
};
