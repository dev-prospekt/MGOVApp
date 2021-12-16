<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalItemDocumentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animal_item_documentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_item_id');

            $table->foreignId('state_recive')->nullable()->constrained('animal_item_documentation_state_types');
            $table->text('state_recive_desc')->nullable();

            $table->foreignId('state_found')->nullable()->constrained('animal_item_documentation_state_types');
            $table->text('state_found_desc')->nullable();

            $table->foreignId('state_reason')->nullable()->constrained('animal_item_documentation_state_types');
            $table->text('state_reason_desc')->nullable();

            $table->string('seized_doc')->nullable();

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
        Schema::dropIfExists('animal_item_documentations');
    }
}
