<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StrucnaSpremaTabela extends Migration{
    public function up(){
        Schema::create('sluzbenik_strucna_sprema', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('stepen_s_s', 4000)->nullable();
            $table->string('vrsta_s_s', 4000)->nullable();
            $table->integer('diploma_poslana_na_provjeru')->unsigned()->nullable();
            $table->string('komenta_o_diplomi', 4000)->nullable();
            $table->string('obrazovna_institucija', 4000)->nullable();
            $table->date('datum_zavrsetka')->nullable();
            $table->string('nostrifikacija', 4000)->nullable();

            $table->integer('id_sluzbenika'); /*** Ovdje upisujemo ID sluzbenika iz tabele sluzbenici one-to-one **/

            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('strucna_sprema');
    }
}
