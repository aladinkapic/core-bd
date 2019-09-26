<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestanak extends Model
{
    //

    protected $guarded = ['id'];

    protected $table = "ugovori_prestanak_radnog_odnosa";

    public function usluzbenik(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik');
    }

    public function radno_mj(){
        return $this->hasOne(RadnoMjesto::class, 'id', 'radno_mjesto');
    }
}
