<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpravljanjeUcinkomTabela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upravljanje_ucinkom', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('sluzbenik')->nullable();
            $table->integer('radno_mjesto')->nullable();
            $table->string('godina', 100)->nullable();
            $table->decimal('ocjena',8,2)->nullable();
            $table->text('opisna_ocjena')->nullable();
            $table->integer('kategorija')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upravljanje_ucinkom');
    }
}
