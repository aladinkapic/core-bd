<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TemeZaObukuTabela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teme', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('naziv', 100)->nullable();
            $table->string('oblast', 250)->nullable();
            $table->text('napomena')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teme');
    }
}
