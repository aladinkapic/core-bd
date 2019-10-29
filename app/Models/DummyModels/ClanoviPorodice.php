<?php

namespace App\Models\DummyModels;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ClanoviPorodice extends Model{
    protected $table = 'sluzbenik_clanovi_porodice';

    public function datumRodjenja(){
        if(!$this->datum_rodjenja) return '';
        return Carbon::parse($this->datum_rodjenja)->format('d.m.Y');
    }

    public function srodstvo_sl()
    {
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'srodstvo')
            ->where('type', '=', 'srodstvo');
    }
}
