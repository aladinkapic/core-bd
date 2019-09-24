<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRasporedjivanje extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ugovor_privremeno_rasporedjivanje', function (Blueprint $table) {
            //
            $table->integer('radno_mjesto');
        });
        Schema::rename('ugovor_privremeno_rasporedjivanje', 'ugovori_privremeno_rasporedjivanje');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ugovor_mjesto_rada', function (Blueprint $table) {
            //
            $table->dropColumn('radno_mjesto');
        });
        Schema::rename('ugovor_privremeno_rasporedjivanje', 'ugovori_privremeno_rasporedjivanje');
    }
}
