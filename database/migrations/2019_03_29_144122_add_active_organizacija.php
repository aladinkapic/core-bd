<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveOrganizacija extends Migration
{
    public function up()
    {
        Schema::table('organizacija', function($table) {
            $table->integer('active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizacija', function($table) {
            $table->dropColumn('active');
        });
    }
}
