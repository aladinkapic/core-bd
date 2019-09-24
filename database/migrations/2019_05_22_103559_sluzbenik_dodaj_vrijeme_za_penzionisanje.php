<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SluzbenikDodajVrijemeZaPenzionisanje extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sluzbenici', function (Blueprint $table) {
            $table->integer('vakaz_za_penzionisanje')->nullable();
            $table->integer('penzionisan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sluzbenici', function (Blueprint $table) {
            //
        });
    }
}
