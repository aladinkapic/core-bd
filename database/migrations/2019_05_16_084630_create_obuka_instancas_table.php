<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObukaInstancasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obuka_instance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('obuka_id');
            $table->text('postavke');
            $table->text('predavaci');
            $table->text('sluzbenici');
            $table->date('odrzavanje_od');
            $table->date('odrzavanje_do');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obuka_instancas');
    }
}
