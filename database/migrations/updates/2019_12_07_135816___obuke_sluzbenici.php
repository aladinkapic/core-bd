<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ObukeSluzbenici extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obuke__sluzbenici', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('obuka_id');
            $table->integer('sluzbenik_id');

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
        Schema::dropIfExists('obuke__sluzbenici');
    }
}
