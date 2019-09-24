<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrazniciTabela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('praznici', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('naziv_praznika')->nullable();     // 0. Praznik 1. Vjerski praznik
            $table->date('datum_praznika')->nullable();
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
        Schema::dropIfExists('praznici');
    }
}
