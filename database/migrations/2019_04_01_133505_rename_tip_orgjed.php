<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTipOrgjed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::rename('organizacione_jedinice', 'org_jedinica');
        Schema::rename('tip_orgjed', 'org_jedinica_tip');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::rename('org_jedinica', 'organizacione_jedinice');
        Schema::rename('org_jedinica_tip', 'tip_orgjed');
    }
}
