<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKretanjeSluzbenika extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sluzbenik_kretanje', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->integer('id_rm');
            $table->integer('id_rm_before');
            $table->integer('org_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sluzbenik_kretanje');
    }
}
