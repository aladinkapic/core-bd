<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Notifikacije extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifikacije', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('sluzbenik_id')->nullable();
            $table->string('what')->nullable();
            $table->string('to_who')->nullable();
            $table->text('message')->nullable();
            $table->string('note')->nullable();
            $table->date('read_at')->nullable();

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
        Schema::dropIfExists('notifikacije');
    }
}
