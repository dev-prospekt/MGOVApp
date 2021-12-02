<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDateSolitaryGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_solitary_groups', function (Blueprint $table) {
            $table->id();

            $table->foreignId('animal_item_id');
            
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('solitary_or_group');

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
        Schema::dropIfExists('date_solitary_groups');
    }
}
