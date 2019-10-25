<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstancePredavacisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obuke_instance_predavaci', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('predavac_id')->nullable();
            $table->integer('instanca_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instance_predavacis');
    }
}
