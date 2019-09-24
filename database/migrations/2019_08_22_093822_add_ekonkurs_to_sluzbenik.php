<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEkonkursToSluzbenik extends Migration
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
            /*
             * 0 - nije došao iz ekonkursa
             * 1 - došao iz e-konkursa, nisu ubačeni podaci poput prebivališta itd.
             * 2 - završen ciklus ekonkursa - ubačeni podaci prebivališta, jezika itd.
             */
            $table->integer('ekonkurs')->default(0);
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
            $table->dropColumn('ekonkurs');
        });
    }
}
