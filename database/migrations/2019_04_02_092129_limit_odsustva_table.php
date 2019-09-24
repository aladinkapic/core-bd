<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LimitOdsustvaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('limit_odsustva', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("odsustvo")->nullable();                  // FK
            $table->integer('ukupno')->nullable();
            $table->integer('sluzbenik_id')->nullable();              // FK ili null gdje null predstavlja sve sluzbenike
            $table->integer('godina')->nullable();
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
        Schema::dropIfExists('limit_odsustva');
    }
}
