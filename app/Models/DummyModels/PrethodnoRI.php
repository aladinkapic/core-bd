<?php

namespace App\Models\DummyModels;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PrethodnoRI extends Model{
    protected $table = 'sluzbenik_prethodno_radno_iskustvo';
    protected $guarded = ['id'];

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

    public function datumPocetka(){
        if(!$this->period_zaposlenja_od) return '';
        return Carbon::parse($this->period_zaposlenja_od)->format('d.m.Y');
    }

    public function datumZavrsetka(){
        if(!$this->period_zaposlenja_do) return '';
        return Carbon::parse($this->period_zaposlenja_do)->format('d.m.Y');
    }

    public function radno_vrijeme_sl()
    {
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'radno_vrijeme')
            ->where('type', '=', 'radno_vrijeme');
    }
}
