<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PodaciOPrebivalistuTabela extends Migration{
    public function up(){
        Schema::create('sluzbenik_podaci_o_prebivalistu', function (Blueprint $table) { // Da li ćemo ovdje staviti sluzbenik_id ili ćemo u službenike staviti id_prebivaliste
            $table->bigIncrements('id');
            $table->string('mjesto_prebivalista')->nullable();
            $table->string('adresa_prebivalista')->nullable();
            $table->string('adresa_boravista')->nullable();

            $table->integer('id_sluzbenika'); /*** Ovdje upisujemo ID sluzbenika iz tabele sluzbenici one-to-one **/

            $table->timestamps();
        });
    }


    public function down(){
        Schema::dropIfExists('podaci_o_prebivalistu');
    }
}
