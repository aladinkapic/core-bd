<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OdsustvaTabbela extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odsustva', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vrsta_odsustva')->nullable();              // FK
            $table->integer('sluzbenik_id')->nullable();                // FK
            $table->date('datum')->nullable();
            $table->string('putni_nalog')->nullable();
            $table->string('naknade')->nullable();
            $table->string('troskovi')->nullable();
            $table->text('napomena')->nullable();                       // ovdje upisujemo razlog odsustva (zašto je korisnik na bolovanju)
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
        Schema::dropIfExists('odsustva');
    }
}
