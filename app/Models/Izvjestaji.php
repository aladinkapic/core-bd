<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izvjestaji extends Model{
    protected $table = 'izvjestaji';

    public function sluzbenik(){
        return $this->hasOne('\App\Models\Sluzbenik', 'id', 'id_sluzbenika');
    }
}
