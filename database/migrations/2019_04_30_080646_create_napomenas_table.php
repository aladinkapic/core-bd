<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNapomenasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('napomenas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('napomena',1000);
            $table->integer('user_id'); //uzeti iz sesije
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('napomenas');
    }
}
