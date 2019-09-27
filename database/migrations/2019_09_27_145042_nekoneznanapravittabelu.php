<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Nekoneznanapravittabelu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ugovori_dodatne_djelatnosti', function (Blueprint $table) {
            $table->integer('sluzbenik')->nullable();
            $table->string('razlog','250')->nullable();
            $table->string('rjesenje','100')->nullable();
            $table->date('datum_rjesenja')->nullable();
            $table->bigIncrements('id');
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
        Schema::table('ugovori_dodatne_djelatnosti', function (Blueprint $table) {
            //
        });
    }
}
