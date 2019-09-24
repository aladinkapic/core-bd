<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MedijatoriTabela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medijatori', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('disciplinska_odgovornost_id')->nullable();
            $table->integer('sluzbenik_id_med')->nullable();
            $table->string('sluzbenik_id_med_e',255)->nullable();
            $table->integer('oju_med')->nullable();
            $table->string('oju_med_e',255)->nullable();
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
        Schema::dropIfExists('medijatori');
    }
}
