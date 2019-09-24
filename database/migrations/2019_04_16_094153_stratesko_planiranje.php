<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StrateskoPlaniranje extends Migration{
    public function up()
    {
        Schema::create('ostalo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_rm')->nullable();              // FK - radno mjesto
            $table->integer('id_oju')->nullable();             // FK - organ javne uprave
            $table->string('datum_broj')->nullable();          // Datum i broj akta

            // Radno mjesto opet ??

            $table->integer('pb_neodredjeno')->nullable();     // Postojeći broj na neodređeno
            $table->integer('pb_odredjeno')->nullable();       // Postojeći broj na određeno
            $table->integer('pb_prekobrojnih')->nullable();    // Postojeći broj prekobrojnih
            $table->integer('pb_godina')->nullable();          // Postojeći broj godina
            $table->integer('pot_b_neodredjeno')->nullable();  // Potreban broj na neodređeno vrijeme
            $table->integer('pot_b_odredjeno')->nullable();    // Potreban broj na određeno vrijeme
            $table->integer('pot_b_godina')->nullable();       // Potreban broj - godina

            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('ostalo');
    }
}