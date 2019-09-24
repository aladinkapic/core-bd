<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpravljanjeUcinkomTabela extends Migration
{
    public function up()
    {
        Schema::create('obrazac_za_ocjenjivanje_drzavnog_sluzbenika', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('ocjena_brojcana', 150);
            $table->string('ocjena_opisna', 150); /*** nema u specifikaciji tip i velicina podatka */
            $table->string('kategorija_ocjene', 150); /*** nema u specifikaciji tip i velicina podatka */

            $table->integer('id_sluzbenika');  /*** FK Ovdje upisujemo ID sluzbenika iz tabele sluzbenici one-to-one **/
            $table->integer('radno_mjesto'); /*** FK Ovdje upisujemo Šifra radnog mjesta iz tabele Radno mjesto **/
            $table->integer('godina'); /*** FK Provjeriti na koju tabelu se veže **/

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('obrazac_za_ocjenjivanje_drzavnog_sluzbenika');
    }
}
