<?php

namespace App\Models\DummyModels;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StrucnaSprema extends Model{
    protected $table = 'sluzbenik_strucna_sprema';

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
}
