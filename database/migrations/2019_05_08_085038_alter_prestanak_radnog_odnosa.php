<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPrestanakRadnogOdnosa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('ugovor_prestanak_radnog_odnosa', function ($table){
            $table->renameColumn('razlog_prestanka_radnog_odnosa', 'razlog');
        });

        Schema::rename('ugovor_prestanak_radnog_odnosa', 'ugovori_prestanak_radnog_odnosa');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //

        Schema::table('ugovori_prestanak_radnog_odnosa', function ($table){
            $table->renameColumn('razlog', 'razlog_prestanka_radnog_odnosa');
        });

        Schema::rename('ugovori_prestanak_radnog_odnosa', 'ugovor_prestanak_radnog_odnosa');
    }
}
