<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableIdRmBefore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('sluzbenik_kretanje', function(Blueprint $table){
            $table->integer('id_rm_before')->nullable()->change();
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
        Schema::table('sluzbenik_kretanje', function(Blueprint $table){
            $table->integer('id_rm_before')->change();
        });
    }
}
