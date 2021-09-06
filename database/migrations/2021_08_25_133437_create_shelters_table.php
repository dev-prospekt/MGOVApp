<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSheltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shelters', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('shelterCode');
            $table->string('email');
            $table->string('address');
            $table->bigInteger('oib');
            $table->string('place_zip');
            $table->string('bank_name');
            $table->bigInteger('telephone');
            $table->bigInteger('mobile');
            $table->bigInteger('fax');
            $table->string('web_address');
            $table->bigInteger('iban');

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
        Schema::dropIfExists('shelters');
    }
}
