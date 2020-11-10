<?php

namespace App\Models\DummyModels;

use App\Models\Sifrarnik;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Obrazovanje extends Model{
    protected $table = 'sluzbenik_obrazovanje_sluzbenika';
    protected $guarded = ['id'];

    public function datumIzdavanjaDiplome(){
        if(!$this->datum_izdavanja_dipl) return '';
        return Carbon::parse($this->datum_izdavanja_dipl)->format('d.m.Y');
    }

    public function datumDiplomiranja(){
        if(!$this->datum_diplomiranja) return '';
        return Carbon::parse($this->datum_diplomiranja)->format('d.m.Y');
    }

    public function datumNostrifikacije(){
        if(!$this->datum_nostrifikacije) return '';
        return Carbon::parse($this->datum_nostrifikacije)->format('d.m.Y');
    }

    public function ciklus(){
        return $this->hasOne(Sifrarnik::class, 'value', 'ciklus_obrazovanja')->where('type', 'stepen');
    }
}
