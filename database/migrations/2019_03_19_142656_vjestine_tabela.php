<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VjestineTabela extends Migration{
    public function up()
    {
        Schema::create('sluzbenik_vjestine_sluzbenika', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vrsta_vjestine');                    // Ovdje povlačimo iz tabele vjestine id_vjestine
            $table->string('nivo_vjestine', 50)->nullable();
            $table->string('institucija', 50)->nullable(); // Od koje je institucije uvjerenje izdato
            $table->string('broj_uvjerenja', 50)->nullable();
            $table->date('datum_uvjerenja')->nullable();
            $table->string('komentar', 100)->nullable();

            $table->integer('id_sluzbenika'); /*** Ovdje upisujemo ID sluzbenika iz tabele sluzbenici one-to-one **/

            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('vjestine_sluzbenika');
    }
}
