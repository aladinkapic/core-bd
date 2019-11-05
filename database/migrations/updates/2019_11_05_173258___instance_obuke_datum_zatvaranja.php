<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InstanceObukeDatumZatvaranja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('obuke_nove_instance', function (Blueprint $table) {
            $table->date('datum_zatvaranja')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('obuke_nove_instance', function (Blueprint $table) {
            //
        });
    }
}
