<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EkonkursHistorijaSluzbenika extends Migration{
    public function up(){
        Schema::create('ekonkurs_hs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_sluzbenika');
            $table->integer('id_roota');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('ekonkurs_hs');
    }
}
