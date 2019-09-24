<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RegistarUgovoraDodatneDjelatnostiTabela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ugovor_dodatne_djelatnosti', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('opis_djelatnosti', 500)->nullable();
            $table->integer('pismena_saglasnost_rukovodioca')->nullable();
            $table->string('broj_rjesenja', 50)->nullable();
            $table->date('datum rjesenja')->nullable();
            $table->string('napomena', 400)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ugovor_dodatne_djelatnosti');
    }
}
