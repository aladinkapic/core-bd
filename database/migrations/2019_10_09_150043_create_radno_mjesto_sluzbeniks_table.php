<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRadnoMjestoSluzbeniksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radno_mjesto_sluzbenici', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('sluzbenik_id')->nullable();
            $table->integer('radno_mjesto_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('radno_mjesto_sluzbeniks');
    }
}
