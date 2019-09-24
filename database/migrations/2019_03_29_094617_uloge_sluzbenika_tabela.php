<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UlogeSluzbenikaTabela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()    {
        Schema::create('uloge', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sluzbenik_id')->nullable();
            $table->string('keyword')->nullable();
            $table->integer('vrijednost')->nullable();
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
        Schema::dropIfExists('uloge');
    }
}
