<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class
RadniStatus extends Model
{
    //
    protected $table = 'ugovori_radni_status';
    protected $guarded = ['id'];

    public function usluzbenik(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik');
    }

    public function datumUgovora(){
        if(!$this->datum) return '';
        return Carbon::parse($this->datum)->format('d.m.Y');
    }

    public function datumIsteka(){
        if(!$this->datum_isteka) return '';
        return Carbon::parse($this->datum_isteka)->format('d.m.Y');
    }

    public function datumIstekaProbni(){
        if(!$this->datum_isteka_probni) return '';
        return Carbon::parse($this->datum_isteka_probni)->format('d.m.Y');
    }
    public function datumPocetkaRada(){
                if(!$this->datum_pocetka_rada) return '';
        return Carbon::parse($this->datum_pocetka_rada)->format('d.m.Y');
    }
    public function radnoMjesto(){
        return $this->hasOne(RadnoMjesto::class, 'id', 'radno_mjesto');
    }

}
