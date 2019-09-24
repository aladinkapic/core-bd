<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ZalbaTabela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zalba', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('disciplinska_odgovornost_id')->nullable();
            $table->string('broj_ulozene_zalbe',50)->nullable();
            $table->date('datum_ulozene_zalbe')->nullable();
            $table->string('broj_odluke_zalbe',50)->nullable();
            $table->date('datum_odluke_zalbe')->nullable();

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
        Schema::dropIfExists('zalba');
    }
}
