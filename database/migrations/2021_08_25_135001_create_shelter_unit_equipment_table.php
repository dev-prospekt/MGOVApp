<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShelterUnitEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shelter_unit_equipment', function (Blueprint $table) {
            $table->id();

            $table->text('description');
            $table->text('transport');
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
        Schema::dropIfExists('shelter_unit_equipment');
    }
}
