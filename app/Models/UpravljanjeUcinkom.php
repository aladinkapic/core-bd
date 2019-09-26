<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpravljanjeUcinkom extends Model{
    protected $table = "upravljanje_ucinkom";

    protected $fillable = [
        'sluzbenik', 'radno_mjesto', 'godina','ocjena', 'opisna_ocjena','kategorija'
    ];

    public function usluzbenik(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik');
    }

    public function mjesto(){
        return $this->hasOne(RadnoMjesto::class,'id', 'radno_mjesto');
    }
    public function kategorija_ocjene()
    {
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'kategorija')
            ->where('type', '=', 'kategorija_ocjene');
    }
}
