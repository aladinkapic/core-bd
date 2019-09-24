<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObukasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obuke', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('naziv',50)->nullable();
            $table->string('vrsta',50)->nullable();
            $table->text('opis')->nullable();
            $table->string('oblast',50)->nullable();
            $table->string('podtema',50)->nullable();
            $table->string('organizator',50)->nullable();
            $table->string('sjediste',50)->nullable();
            $table->integer('zemlja_organizatora')->nullable(); //->FK sifrarnik
            $table->string('potvrda',50)->nullable();
            $table->date('datum_certifikata')->nullable();
            $table->string('broj_certifikata', 50)->nullable();
            $table->string('finansiranje_obuke', 50)->nullable();
            $table->text('stecena_znanja')->nullable();
            $table->integer('predavac_id')->nullable(); //->FK
            $table->integer('broj_polaznika')->nullable();
            $table->integer('status')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obukas');
    }
}
