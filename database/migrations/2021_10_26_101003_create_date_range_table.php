<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDateRangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('date_ranges', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('animal_item_id');
            
            $table->string('start_date');
            $table->string('end_date')->nullable();
            $table->string('reason_date_end')->nullable();

            $table->string('hibern_start')->nullable();
            $table->string('hibern_end')->nullable();

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
        Schema::dropIfExists('date_range');
    }
}
