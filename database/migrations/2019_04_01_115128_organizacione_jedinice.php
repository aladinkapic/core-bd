<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrganizacioneJedinice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('organizacione_jedinice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('naziv', 50);
            $table->integer('tip');
            $table->integer('parent_id')->nullable();
            $table->text('opis');
            $table->integer('org_id');
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
        //
        Schema::drop('organizacione_jedinice');
    }
}
