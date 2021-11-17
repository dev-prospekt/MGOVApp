<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('animal_id')->constrained('animals');
            $table->foreignId('shelter_id')->constrained('shelters');
            $table->foreignId('animal_file_id');
            $table->foreignId('animal_mark_id');
            $table->foreignId('founder_id');
            $table->foreignId('animal_size_attributes_id');
            $table->string('status');
            $table->string('status_receiving');
            $table->string('status_found');

            $table->string('animal_gender');
            $table->string('animal_dob');
            $table->string('reason');
            $table->tinyInteger('solitary_or_group');
            $table->string('location');
            $table->string('shelter_code');
            $table->string('date_found');

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
        Schema::dropIfExists('animal_items');
    }
}
