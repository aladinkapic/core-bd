<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DisciplinskaKomisijaTabela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disciplinska_komisija', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('disciplinska_odgovornost_id')->nullable();
            $table->integer('sluzbenik_id_kom')->nullable();
            $table->string('sluzbenik_id_kom_e',255)->nullable();
            $table->integer('oju_kom')->nullable();
            $table->string('oju_kom_e',255)->nullable();
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
        Schema::dropIfExists('disciplinska_komisija');
    }
}
