<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FajloviSistematizacija extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizacija_fajlovi', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('organizacija_id');
            $table->string('naziv_dokumenta')->nullable();
            $table->string('hash')->nullable();

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
        Schema::dropIfExists('organizacija_fajlovi');
    }
}
