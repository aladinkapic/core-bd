<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUgovoriDodatno extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('ugovor_dodatne_djelatnosti', function ($table){
           $table->renameColumn('opis_djelatnosti', 'opis');
           $table->renameColumn('pismena_saglasnost_rukovodioca', 'saglasnost');
        });

        Schema::rename('ugovor_dodatne_djelatnosti', 'ugovori_dodatno');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('ugovor_dodatno', function ($table){
            $table->renameColumn('opis', 'opis_djelatnosti');
            $table->renameColumn('saglasnost', 'pismena_saglasnost_rukovodioca');
        });

        Schema::rename('ugovori_dodatno', 'ugovor_dodatne_djelatnosti');
    }
}
