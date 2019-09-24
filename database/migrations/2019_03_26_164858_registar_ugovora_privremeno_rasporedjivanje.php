<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RegistarUgovoraPrivremenoRasporedjivanje extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ugovor_privremeno_rasporedjivanje', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('privremeno_radno_mjesto')->nullable(); //FK tabela radno mjesto
            $table->string('broj_rjesenja', 50)->nullable();
            $table->date('datum_rjesenja')->nullable();
            $table->date('datum_od')->nullable();
            $table->date('datum_do')->nullable();
            $table->integer('sluzbenik')->nullable(); //FK tabela sluzbenik
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ugovor_privremeno_rasporedjivanje');
    }
}
