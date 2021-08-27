<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShelterUnitAccomodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shelter_unit_accomodations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('dimensions');
            $table->string('description');
            $table->string('image');

            $table->foreignId('shelter_unit_id')->constrained('shelter_units');
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
        Schema::dropIfExists('shelter_unit_accomodations');
    }
}
