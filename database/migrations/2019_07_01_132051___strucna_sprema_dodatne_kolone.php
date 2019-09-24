<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StrucnaSpremaDodatneKolone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()    {
        Schema::table('sluzbenik_strucna_sprema', function (Blueprint $table) {
            $table->integer('diploma_vracena_sa_provjere')->after('diploma_poslana_na_provjeru')->nullable();
            $table->string('broj_obavijestenja_provjere')->after('diploma_poslana_na_provjeru')->nullable();
            $table->date('datum_povratka_sa_provjere')->after('diploma_poslana_na_provjeru')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sluzbenik_strucna_sprema', function (Blueprint $table) {
            $table->integer('diploma_vracena_sa_provjere');
            $table->string('broj_obavijestenja_provjere');
            $table->date('datum_povratka_sa_provjere');
        });
    }
}
