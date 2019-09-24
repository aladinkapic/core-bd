<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RegistarUgovoraPrestanakRadnogOdnosaTabela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ugovor_prestanak_radnog_odnosa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('sluzbenik')->nullable(); //FK tabela sluzbenik
            $table->string('razlog_prestanka_radnog_odnosa', 500)->nullable();
            $table->integer('radno_mjesto')->nullable(); //FK tabela radno mjesto
            $table->string('rjesenje', 100)->nullable();
            $table->date('datum_rjesenja')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ugovor_prestanak_radnog_odnosa');
    }
}
