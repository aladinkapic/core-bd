<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Prestanak extends Model
{
    //d

    protected $guarded = ['id'];

    protected $table = "ugovori_prestanak_radnog_odnosa";

    public function usluzbenik(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik');
    }

    public function radno_mj(){
        return $this->hasOne(RadnoMjesto::class, 'id', 'radno_mjesto');
    }

    public function datumRješenja(){
        if(!$this->datum_rjesenja) return '';
        return Carbon::parse($this->datum_rjesenja)->format('d.m.Y');
    }
}
