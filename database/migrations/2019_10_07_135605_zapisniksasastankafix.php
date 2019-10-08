<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Zapisniksasastankafix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sluzbenik_zasnivanje_radnog_odnosa', function (Blueprint $table) {
            $table->date('datum_donosenja_dokumentacije')->nullable();
            $table->string('minuli_radni_staz')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sluzbenik_zasnivanje_radnog_odnosa', function (Blueprint $table) {
            //
        });
    }
}
