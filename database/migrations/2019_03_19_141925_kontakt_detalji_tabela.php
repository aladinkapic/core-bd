<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KontaktDetaljiTabela extends Migration{
    public function up(){
        Schema::create('sluzbenik_kontakt_detalji_osobe', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sluzbeni_tel', 50)->nullable();
            $table->string('sluzbeni_mail', 50)->nullable();
            $table->string('mobilni_tel', 50)->nullable();
            $table->string('email', 50)->nullable();

            $table->integer('id_sluzbenika'); /*** Ovdje upisujemo ID sluzbenika iz tabele sluzbenici one-to-one **/

            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('kontakt_detalji_osobe');
    }
}
