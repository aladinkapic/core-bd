<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privremeno extends Model
{
    //
    protected $table = 'ugovori_privremeni_premjestaj';
    protected $guarded = ['id'];

    public function usluzbenik(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik');
    }

    public function mjesto(){
        return $this->hasOne(RadnoMjesto::class,'id', 'radno_mjesto');
    }

    public function privremeno_mjesto(){
        return $this->hasOne(RadnoMjesto::class,'id', 'privremeno_radno_mjesto');
    }
}
