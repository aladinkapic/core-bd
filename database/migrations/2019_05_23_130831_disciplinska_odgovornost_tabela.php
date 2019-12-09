<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DisciplinskaOdgovornostTabela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disciplinska_odgovornost', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('sluzbenik_id')->nullable();
            $table->date('datum_povrede')->nullable();
            $table->text('opis_povrede')->nullable();
            $table->text('opis_disciplinske_mjere')->nullable();
            $table->date('datum_rjesenja_zabrane')->nullable();
            $table->string('broj_rjesenja_zabrane')->nullable();
            $table->date('datum_zavrsetka_zabrane')->nullable();
            $table->string('vrsta_disciplinske')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disciplinska_odgovornost');
    }
}
