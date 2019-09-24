<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SifrarniciTabela extends Migration{

    public function up()    {
        Schema::create('sifrarnici', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("type", 50)->nullable();              // Tip sifrarnika - nacionalnost
            $table->integer("value")->nullable();                       // Vrijednost npr 0 ili 1 ili ..
            $table->string("name", 350)->nullable();              // Ime vrijednosti - Bošnjak
            $table->timestamps();
        });
    }


    public function down()    {
        Schema::dropIfExists('sifrarnici');
    }
}
