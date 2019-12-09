<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpravljanjeUcinkomProbni extends Model{
    protected $table = "upravljanje_ucinkom_probni";

    protected $guarded = ['id'];

    public function usluzbenik(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik_id');
    }
    public function prviClan(){
        return $this->hasOne(Sluzbenik::class, 'id', 'prvi_ocjenjivac');
    }
    public function drugiClan(){
        return $this->hasOne(Sluzbenik::class, 'id', 'drugi_ocjenjiva');
    }
    public function treciClan(){
        return $this->hasOne(Sluzbenik::class, 'id', 'treci_ocjenjivac');
    }
    public function opisnaOcjena(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'opisna_ocjena')
            ->where('type', '=', 'opisna_probni');
    }
}
