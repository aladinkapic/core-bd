<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRasporedjivanje2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::rename('ugovori_privremeno_rasporedjivanje', 'ugovori_privremeni_premjestaj');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::rename('ugovori_privremeni_premjestaj', 'ugovori_privremeno_rasporedjivanje');
    }
}
