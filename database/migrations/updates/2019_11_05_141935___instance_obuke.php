<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InstanceObuke extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obuke_nove_instance', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('obuka_id');
            $table->date('pocetak_obuke');
            $table->date('kraj_obuke');

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
        Schema::dropIfExists('obuke_nove_instance');
    }
}
