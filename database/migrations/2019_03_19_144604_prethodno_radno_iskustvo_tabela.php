<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrethodnoRadnoIskustvoTabela extends Migration{
    public function up(){
        Schema::create('sluzbenik_prethodno_radno_iskustvo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('poslodavac', 50)->nullable();
            $table->string('sjediste_poslodavca', 50)->nullable();
            $table->date('period_zaposlenja_od')->nullable();
            $table->date('period_zaposlenja_do')->nullable();
            $table->integer('radno_vrijeme')->nullable();           // FK
            $table->string('opis_poslova', 1000)->nullable();
            $table->string('steceno_radno_iskustvo', 50)->nullable();
            $table->string('ostvareni_radni_staz', 50)->nullable();
            $table->string('staz_osiguranja', 50)->nullable();
            $table->string('dobrovoljno_osiguranje', 50)->nullable();
            $table->string('penzioni_staz', 50)->nullable();
            $table->string('staz_sa_uvecanim_trajanjem', 50)->nullable();
            $table->string('drzava_sa_stazom', 50)->nullable();
            $table->string('trajanje_staza_u_drzavi', 50)->nullable();
            $table->string('napomena', 500)->nullable();

            $table->integer('id_sluzbenika'); /*** Ovdje upisujemo ID sluzbenika iz tabele sluzbenici one-to-one **/

            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('prethodno_radno_iskustvo');
    }
}
