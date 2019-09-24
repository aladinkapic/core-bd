<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SifrarnikOdsustavaTabela extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()    {
        Schema::create('sifrarnik_odsustava', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('naziv_odsustva')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()    {
        Schema::dropIfExists('sifrarnik_odsustava');
    }
}
