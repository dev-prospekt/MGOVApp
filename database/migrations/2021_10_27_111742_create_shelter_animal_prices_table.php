<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShelterAnimalPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shelter_animal_prices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('animal_item_id');
            $table->decimal('hibern')->nullable();
            $table->decimal('full_care')->nullable();
            $table->decimal('solitary_price')->nullable();
            $table->decimal('group_price')->nullable();
            $table->decimal('total_price')->nullable();

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
        Schema::dropIfExists('shelter_animal_prices');
    }
}
