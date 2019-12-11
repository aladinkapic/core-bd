<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ZasnivanjeRadnogOdnosa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sluzbenik_zasnivanje_radnog_odnosa', function (Blueprint $table) {
            $table->string('radno_vrijeme')->nullable();
            $table->string('opis_poslova')->nullable();
            $table->string('steceno_radno_iskustvo')->nullable();
            $table->string('staz_osiguranja')->nullable();
            $table->string('dobrovoljno_osiguranje')->nullable();
            $table->string('penzioni_staz')->nullable();
            $table->string('koeficijent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sluzbenik_zasnivanje_radnog_odnosa', function (Blueprint $table) {
            //
        });
    }
}
