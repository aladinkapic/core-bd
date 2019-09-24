<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RegistarUgovoraMjestoRadaTabela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ugovor_mjesto_rada', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('adresa', 100)->nullable();
            $table->string('sprat', 20)->nullable();
            $table->string('broj_kancelarije', 50)->nullable();
            $table->integer('sluzbeno_auto')->nullable();
            $table->string('povjerena_stalna_sredstva', 500)->nullable();
            $table->integer('radno_mjesto')->nullable(); //FK tabela radno mjesto
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ugovor_mjesto_rada');
    }
}
