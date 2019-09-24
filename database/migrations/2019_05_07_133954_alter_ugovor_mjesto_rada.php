<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUgovorMjestoRada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ugovor_mjesto_rada', function (Blueprint $table) {
            //
            $table->integer('sluzbenik');
        });
        Schema::rename('ugovor_mjesto_rada', 'ugovori_mjesto_rada');
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
            $table->dropColumn('sluzbenik');
        });
        Schema::rename('ugovori_mjesto_rada', 'ugovor_mjesto_rada');
    }
}
