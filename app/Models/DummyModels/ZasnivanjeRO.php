<?php

namespace App\Models\DummyModels;
use App\Models\Sifrarnik;

use Illuminate\Database\Eloquent\Model;

class ZasnivanjeRO extends Model{
    protected $table = 'sluzbenik_zasnivanje_radnog_odnosa';

    public function nacin_zasnivanja_ro_s(){
        return $this->hasOne(Sifrarnik::class,'value', 'nacin_zasnivanja_r_o')
            ->where('type','nacin_zasnivanja_ro');
    }
    public function vrsta_r_o_s(){
        return $this->hasOne(Sifrarnik::class,'value', 'vrsta_r_o')
            ->where('type','vrsta_radnog_odnosa');
    }
    public function obracunati_r_staz_s(){
        return $this->hasOne(Sifrarnik::class,'value', 'obracunati_r_staz')
            ->where('type','obracunati_staz');
    }
}
