<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRadnoMjestoTemp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('radna_mjesta', function($table){
            $table->renameColumn('radno_mjesto_temp', 'before_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('radna_mjesta', function($table){
            $table->renameColumn('before_id', 'radno_mjesto_temp');
        });
    }
}
