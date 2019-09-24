<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Izvjestaji extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('izvjestaji', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('naziv')->nullable();
            $table->string('naziv_korisnicki')->nullable();
            $table->string('what', 50)->nullable();
            $table->integer('id_sluzbenika')->nullable();

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
        Schema::dropIfExists('izvjestaji');
    }
}
