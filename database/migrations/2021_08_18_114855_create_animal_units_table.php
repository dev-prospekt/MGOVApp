<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_units', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('latin_name');


            $table->foreignId('shelter_id')->constrained('shelters');
            $table->foreignId('animal_code_id')->constrained('animal_codes');

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
        Schema::dropIfExists('animal_units');
    }
}
