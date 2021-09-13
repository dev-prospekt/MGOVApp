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
            $table->string('shelterCode');
            $table->string('status');
            $table->string('animal_size');
            $table->string('animal_gender');
            $table->tinyInteger('solitary_or_group');
            $table->string('location');

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
