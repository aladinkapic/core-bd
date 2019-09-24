<?php

namespace App\Models\DummyModels;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PrethodnoRI extends Model{
    protected $table = 'sluzbenik_prethodno_radno_iskustvo';

    public function broj_dana_izmedju($prvi_datum, $drugi_datum){
        $prvi_datum = Carbon::parse($prvi_datum);
        return $prvi_datum->diffInDays(Carbon::parse($drugi_datum));
    }

    public function radniStazGodina(){
        return (int)(($this->broj_dana_izmedju($this->period_zaposlenja_od, $this->period_zaposlenja_do) / 30 / 12));
    }
    public function radniStazMjeseci(){
        return (int)(($this->broj_dana_izmedju($this->period_zaposlenja_od, $this->period_zaposlenja_do) / 30) - ($this->radniStazGodina() * 12));
    }
    public function radniStazDana(){
        return (int)($this->broj_dana_izmedju($this->period_zaposlenja_od, $this->period_zaposlenja_do) % 30);
    }
}
