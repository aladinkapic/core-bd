<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEkonkursPrijavaToSluzbenik extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sluzbenici', function (Blueprint $table) {
            //
            $table->integer('ekonkurs_prijava')->default('0');
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
            $table->dropColumn('ekonkurs_prijava');
        });
    }
}
