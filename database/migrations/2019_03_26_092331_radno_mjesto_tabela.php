<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RadnoMjestoTabela extends Migration{

    public function up(){
        Schema::create('radna_mjesta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('naziv_rm', 2000)->nullable();
            $table->string('sifra_rm', 50)->nullable();
            $table->text('opis_rm')->nullable();
            $table->integer('broj_izvrsilaca')->nullable();
            $table->string('platni_razred', 100)->nullable();
            $table->integer('tip_rm')->nullable();                                      // FK
            $table->integer('kategorija_rm')->nullable();                               // FK
            $table->integer('id_oj')->nullable();                                       // FK
            $table->integer('strucna_sprema')->nullable();                              // FK
            $table->integer('tip_pm')->nullable();                                      // FK  -  // Tip privremeenog promjestaja
            $table->integer('parent_id')->nullable();                                   // FK  -  // U slučaju da bude nadređenih
            $table->integer('status')->default(0);                                // 1 - upražnjeno; 2 - prekomjerno
            $table->integer('uposleno')->default(0);

            $table->timestamps();
        });
    }

    public function down()    {
        Schema::dropIfExists('radna_mjesta');
    }
}
