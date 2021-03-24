<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpravljanjeUcinkom extends Model{
    protected $table = "upravljanje_ucinkom";

    protected $fillable = [
        'sluzbenik', 'radno_mjesto', 'godina','ocjena', 'opisna_ocjena','kategorija', 'ocjenjivac', 'nije_ocjenjen'
    ];

    public function usluzbenik(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik');
    }
    public function ocjenjivacRel(){
        return $this->hasOne(Sluzbenik::class, 'id', 'ocjenjivac');
    }
    public function nijeOcjenjenRel(){
        return $this->hasOne(Sifrarnik::class, 'value', 'nije_ocjenjen')->where('type', 'da_ne');
    }

    public function mjesto(){
        return $this->hasOne(RadnoMjestoSluzbenik::class,'sluzbenik_id', 'sluzbenik');
    }
    public function kategorija_ocjene()
    {
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'kategorija')
            ->where('type', '=', 'kategorija_ocjene');
    }

    public function opisnaOcjena(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'opisna_ocjena')
            ->where('type', '=', 'opisna_ocjenaaa');
    }
}
