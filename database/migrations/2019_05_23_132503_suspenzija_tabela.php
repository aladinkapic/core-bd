<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SuspenzijaTabela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suspenzija', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('disciplinska_odgovornost_id')->nullable();
            $table->string('broj_rjesenja',50)->nullable();
            $table->string('razlog_udaljenja',500)->nullable();
            $table->date('datum_udaljenja',255)->nullable();

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
        Schema::dropIfExists('suspenzija');
    }
}
