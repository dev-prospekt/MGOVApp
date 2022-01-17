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

            $table->foreignId('animal_group_id');
            $table->foreignId('animal_id')->constrained('animals');
            $table->foreignId('shelter_id')->constrained('shelters');
            $table->boolean('animal_item_care_end_status')->default(1);
            $table->foreignId('founder_id')->nullable();
            $table->foreignId('brought_animal_id');
            $table->string('founder_note')->nullable();
            $table->foreignId('animal_size_attributes_id')->nullable();
            $table->boolean('in_shelter');

            $table->string('animal_found_note');
            $table->date('animal_date_found')->nullable();
            $table->date('date_seized_animal');

            $table->bigInteger('euthanasia_ammount');

            $table->string('place_seized');
            $table->string('place_seized_select');
            $table->string('seized_doc_type');
            $table->string('animal_gender');
            $table->string('animal_age');
            $table->string('solitary_or_group')->nullable();
            $table->string('location');
            $table->string('location_retrieval_animal')->nullable();
            $table->string('location_animal_takeover')->nullable();
            $table->string('seized_doc');
            $table->boolean('full_care_status')->default(false);

            $table->string('shelter_code');
            $table->string('animal_code');

            $table->softDeletes();

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
