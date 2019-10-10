<?php

namespace App\Models\DummyModels;

use Illuminate\Database\Eloquent\Model;

class ZasnivanjeRO extends Model{
    protected $table = 'sluzbenik_zasnivanje_radnog_odnosa';


    public function datumZasnivanjaRO(){
        dd();
        if(!$this->datum_zasnivanja_o) return '';
        return Carbon::parse($this->datum_zasnivanja_o)->format('m.d.Y');
    }
}
