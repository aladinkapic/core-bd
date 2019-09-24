<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ItrUpraznjenaRmTabela extends Migration{
    public function up()    {
        Schema::create('itr_upraznjena_rm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_sluzbenika');            /*** Ovdje upisujemo ID sluzbenika iz tabele sluzbenici one-to-one **/
            $table->text('rjesenje');                    // ** Rješenje  ** //
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('itr_upraznjena_rm');
    }
}
