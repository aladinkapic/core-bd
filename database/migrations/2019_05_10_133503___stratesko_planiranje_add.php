<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StrateskoPlaniranjeAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ostalo', function (Blueprint $table) {
            $table->string('naziv')->nullable();                   // Naziv  :D
            $table->integer('br_plan_godina')->nullable();         // Broj planiranih godina
            $table->integer('id_sluzbenika')->nullable();          // Ime osobe koja je ovo kreirala

            // Potrebno je još displayati datum :)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ostalo', function (Blueprint $table) {
            //
        });
    }
}
