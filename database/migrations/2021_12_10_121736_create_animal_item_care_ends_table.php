<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalItemCareEndsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_item_care_ends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_item_id')->nullable();
            $table->foreignId('animal_item_care_end_type_id')->nullable();
            $table->string('release_location')->nullable();
            $table->string('permanent_keep_name')->nullable();
            $table->string('care_end_other')->nullable();
            $table->text('care_end_description')->nullable();
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
        Schema::dropIfExists('animal_item_care_ends');
    }
}
