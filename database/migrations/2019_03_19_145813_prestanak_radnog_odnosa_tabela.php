<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrestanakRadnogOdnosaTabela extends Migration{
    public function up(){ /** ovo u biti neće trebati, ne daje se otkaz ovdje **/
        Schema::create('sluzbenik_prestanak_radnog_odnosa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('datum_prestanka');
            $table->integer('osnov_za_prestanak');               // FK
            $table->string('napomena', 200);

            $table->integer('id_sluzbenika'); /*** Ovdje upisujemo ID sluzbenika iz tabele sluzbenici one-to-one **/

            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('prestanak_radnog_odnosa');
    }
}
