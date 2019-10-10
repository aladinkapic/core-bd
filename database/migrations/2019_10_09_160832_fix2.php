<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Fix2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sluzbenik_strucna_sprema', function (Blueprint $table) {
            $table->date('datum_dostavljanja_diplome')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sluzbenik_strucna_sprema', function (Blueprint $table) {
            //
        });
    }
}
