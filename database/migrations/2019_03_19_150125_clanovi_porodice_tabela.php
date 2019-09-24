<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClanoviPorodiceTabela extends Migration{
    public function up()
    {
        Schema::create('sluzbenik_clanovi_porodice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('srodstvo', 50)->nullable();
            $table->date('datum_rodjenja');
            $table->string('napomena', 200)->nullable();

            $table->integer('id_sluzbenika'); /*** Ovdje upisujemo ID sluzbenika iz tabele sluzbenici one-to-one **/

            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('clanovi_porodice');
    }
}
