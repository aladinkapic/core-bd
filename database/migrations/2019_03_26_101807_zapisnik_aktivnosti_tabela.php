<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ZapisnikAktivnostiTabela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zapisnik_aktivnosti', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps(); //umjesto datum vrijeme
            $table->integer('operater')->nullable(); //FK trenutno logovani korisnik
            $table->string('url', 150)->nullable();
            $table->json('strare_vrijednosti')->nullable();     //diskutovati sa kolegama :)
            $table->json('nove_vrijednosti')->nullable();     //diskutovati sa kolegama :)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zapisnik_aktivnosti');
    }
}
