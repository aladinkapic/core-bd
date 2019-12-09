<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OcjenjivanjeProbnogRada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upravljanje_ucinkom_probni', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('sluzbenik_id');
            $table->integer('godina');
            $table->integer('opisna_ocjena')->nullable();
            $table->string('prvi_ocjenjivac')->nullable();
            $table->string('ocjena_prvi')->nullable();
            $table->string('drugi_ocjenjivac')->nullable();
            $table->string('ocjena_drugi')->nullable();
            $table->string('treci_ocjenjivac')->nullable();
            $table->string('ocjena_treci')->nullable();

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
        Schema::dropIfExists('upravljanje_ucinkom_probni');
    }
}
