<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrganJavneUpraveTabela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organ_ju', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('tin', 255)->nullable();
            $table->string('naziv', 255)->nullable();
            $table->string('tip', 255)->nullable(); //FK vjerovatno iz sifarnika ne postoji trenutno tabela
            $table->string('ulica',255)->nullable();
            $table->string('broj', 255)->nullable();
            $table->string('telefon', 255)->nullable();
            $table->string('fax', 255)->nullable();
            $table->string('web', 255)->nullable();
            $table->string('email', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organ_javne_uprave');
    }
}
