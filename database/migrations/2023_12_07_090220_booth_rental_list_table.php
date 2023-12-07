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
        Schema::create('booth_rental', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_event')->constrained('detail_event')->onDelete('cascade'); // Kolom foreign key dan primary key
            $table->string('booth_name');
            $table->string('booth_size');
            $table->string('booth_location');
            $table->string('provided_facilities');
            $table->string('booth_description');
            $table->string('rental_price');
            $table->string('rental_time_limit');
            $table->string('admin_phone');
            $table->string('availability_status');
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
        //
    }
};
