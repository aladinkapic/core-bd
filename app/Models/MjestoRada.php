<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MjestoRada extends Model
{
    //
    protected $table = 'ugovori_mjesto_rada';
    protected $guarded = ['id'];

    public function usluzbenik(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik');
    }

    public function sluzbeno_autoq(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'sluzbeno_auto')
            ->where('type', '=', 'sluzbeno_auto');
    }

    public function rm(){
        return $this->hasOne(RadnoMjesto::class,'id', 'radno_mjesto');
    }
}
