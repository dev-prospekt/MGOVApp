<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalShelterDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_shelter_data', function (Blueprint $table) {
            $table->id();


            $table->string("location");
            $table->text('found_desc');

            $table->timestamps();
            $table->foreignId('animal_unit_id')->constrained('animal_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animal_shelter_data');
    }
}
