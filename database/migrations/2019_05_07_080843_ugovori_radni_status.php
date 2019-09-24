<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UgovoriRadniStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('ugovori_radni_status', function($table){
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('broj', 100);
            $table->integer('sluzbenik');
            $table->date('datum');
            $table->date('datum_isteka');
            $table->date('datum_isteka_probni');
            $table->integer('broj_sati');
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

        Schema::drop('ugovori_radni_status');
    }
}
