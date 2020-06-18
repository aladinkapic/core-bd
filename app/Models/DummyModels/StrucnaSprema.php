<?php

namespace App\Models\DummyModels;

use App\Models\Sifrarnik;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StrucnaSprema extends Model{
    protected $table = 'sluzbenik_strucna_sprema';
    protected $guarded = ['id'];

    public function datumZavrsetka(){
        if(!$this->datum_zavrsetka) return '';
        return Carbon::parse($this->datum_zavrsetka)->format('d.m.Y');
    }

    public function datumZaprimanja(){
        if(!$this->datum_povratka_sa_provjere) return '';
        return Carbon::parse($this->datum_povratka_sa_provjere)->format('d.m.Y');
    }

    public function datumDostavljanja(){
        if(!$this->datum_dostavljanja_diplome) return '';
        return Carbon::parse($this->datum_dostavljanja_diplome)->format('d.m.Y');
    }

    public function stepenStrucne(){
        return $this->hasOne(Sifrarnik::class, 'value', 'stepen_s_s')->where('type', 'stepen');
    }
    public function obrazovnaInstitucija(){
        return $this->hasOne(Sifrarnik::class, 'value', 'obrazovna_institucija')->where('type', 'obrazovna_institucija');
    }
}
