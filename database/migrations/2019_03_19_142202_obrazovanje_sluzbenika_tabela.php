<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ObrazovanjeSluzbenikaTabela extends Migration{
    public function up()    {
        Schema::create('sluzbenik_obrazovanje_sluzbenika', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('naziv_ustanove', 50)->nullable();
            $table->string('sjediste_ustanove', 50)->nullable();
            $table->string('broj_diplome', 50)->nullable();
            $table->date('datum_izdavanja_dipl')->nullable();
            $table->date('datum_diplomiranja')->nullable();
            $table->string('vrsta_obrazovanja', 50)->nullable();
            $table->string('ciklus_obrazovanja', 50)->nullable();
            $table->string('strucno_zvanje', 50)->nullable();
            $table->string('odsjek', 50)->nullable();
            $table->string('broj_nostrifikacije', 50)->nullable();
            $table->date('datum_nostrifikacije')->nullable();
            $table->string('rjesenje_izdato_od', 50)->nullable();

            $table->integer('id_sluzbenika'); /*** Ovdje upisujemo ID sluzbenika iz tabele sluzbenici one-to-one **/

            $table->timestamps();
        });
    }


    public function down(){
        Schema::dropIfExists('obrazovanje_sluzbenika');
    }
}
