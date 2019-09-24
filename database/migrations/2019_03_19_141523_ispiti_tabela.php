<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IspitiTabela extends Migration{
    public function up(){
        Schema::create('sluzbenik_ispiti', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ispit_za_rad', 1500)->nullable();
            $table->string('pravosudni_isp', 1500)->nullable();
            $table->string('strucni_isp', 1500)->nullable();
            $table->date('datum_zavrsetka')->nullable();
            $table->string('nostrifikacija', 50)->nullable();

            $table->integer('id_sluzbenika'); /*** Ovdje upisujemo ID sluzbenika iz tabele sluzbenici one-to-one **/

            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('ispiti');
    }
}
