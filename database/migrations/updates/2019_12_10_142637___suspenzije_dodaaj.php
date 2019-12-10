<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SuspenzijeDodaaj extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suspenzija', function (Blueprint $table) {
            $table->string('broj_rjesenja_o_povratku')->nullable();
            $table->date('datum_rjesenja_o_povratku')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suspenzija', function (Blueprint $table) {
            //
        });
    }
}
