<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKoeficijentPrethodno extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sluzbenik_prethodno_radno_iskustvo', function (Blueprint $table) {
            $table->integer('radni_staz_dana')->nullable();
            $table->integer('radni_staz_mjeseci')->nullable();
            $table->integer('radni_staz_godina')->nullable();
            $table->integer('koeficijent')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sluzbenik_prethodno_radno_iskustvo', function (Blueprint $table) {
            //
        });
    }
}
