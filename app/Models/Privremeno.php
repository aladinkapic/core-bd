<?php

namespace App\Models;

use Carbon\Carbon;
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
    public function datumRjesenja(){
        if(!$this->datum_rjesenja) return '';
        return Carbon::parse($this->datum_rjesenja)->format('d.m.Y');
    }
    public function datumOd(){
        if(!$this->datum_od) return '';
        return Carbon::parse($this->datum_od)->format('d.m.Y');
    }
    public function datumDo(){
        if(!$this->datum_do) return '';
        return Carbon::parse($this->datum_do)->format('d.m.Y');
    }
}
