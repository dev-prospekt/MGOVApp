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
            $table->foreignId('animal_file_id')->nullable();
            $table->foreignId('animal_mark_id')->nullable();
            $table->foreignId('founder_id')->nullable();
            $table->text('founder_note')->nullable();
            $table->foreignId('animal_size_attributes_id');
            $table->string('status');
            $table->string('status_receiving')->nullable();
            $table->text('receiving_note');
            $table->string('status_found')->nullable();
            $table->text('found_note')->nullable();
            $table->string('animal_keep_type')->nullable();
            $table->string('animal_mark_name')->nullable();
            $table->string('animal_gender');
            $table->string('animal_dob');
            $table->text('animal_found_note')->nullable();
            $table->string('status_reason');
            $table->text('reason_note')->nullable();
            $table->tinyInteger('solitary_or_group');
            $table->string('location')->nullable();
            $table->string('shelter_code');
            $table->date('date_found');

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
