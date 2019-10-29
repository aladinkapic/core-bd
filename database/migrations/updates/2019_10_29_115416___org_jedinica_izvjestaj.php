<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrgJedinicaIzvjestaj extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('org_jedinica_izvjestaj', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('org_jed');
            $table->integer('godina');
            $table->integer('ne_zadovoljava');
            $table->integer('zadovoljava');
            $table->integer('nadmasuje');
            $table->integer('ukupno');

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
        Schema::dropIfExists('org_jedinica_izvjestaj');
    }
}
