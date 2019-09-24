<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ZasnivanjeRadnogOdnosaTabela extends Migration{
    public function up(){
        Schema::create('sluzbenik_zasnivanje_radnog_odnosa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('datum_zasnivanja_o')->nullable();
            $table->integer('nacin_zasnivanja_r_o');                         // FK
            $table->integer('vrsta_r_o');                                    // FK
            $table->integer('obracunati_r_staz');                            // FK
            $table->integer('obracunati_r_s_god')->default(0);
            $table->integer('obracunati_r_s_mje')->default(0);
            $table->integer('obracunati_r_s_dan')->default(0);
            $table->text('napomena')->nullable();

            $table->integer('id_sluzbenika'); /*** Ovdje upisujemo ID sluzbenika iz tabele sluzbenici one-to-one **/

            $table->timestamps();
        });
    }


    public function down(){
        Schema::dropIfExists('zasnivanje_radnog_odnosa');
    }
}
