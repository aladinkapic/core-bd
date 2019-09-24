<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RadnoMjestoUsloviTabela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radno_mjesto_uslovi', function (Blueprint $table) {
            $table->bigIncrements('id');                                       //nedostaje u specifikaciji
            $table->integer('id_rm')->nullable();                              // FK
            $table->integer('tip')->nullable();                                // FK
            $table->string('tekst_uslova', 4000)->nullable();
            $table->string('vrijednost', 100)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('radno_mjesto_uslovi');
    }
}
