<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShelterNutritionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shelter_nutrition', function (Blueprint $table) {
            $table->id();

            $table->string('food_type');
            $table->string('food_store');
            $table->string('food_transport');
            $table->string('food_supplements');
            $table->string('image');

            $table->foreignId('shelter_id')->constrained('shelters');
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
        Schema::dropIfExists('shelter_unit_nutrition');
    }
}
