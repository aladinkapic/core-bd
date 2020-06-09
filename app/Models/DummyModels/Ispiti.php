<?php

namespace App\Models\DummyModels;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ispiti extends Model{
    protected $table = 'sluzbenik_ispiti';
    protected $guarded = ['id'];

    public function kategorija_ispita_sl()
    {
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'podkategorija')
            ->where('type', '=', 'kategorija_ispita');
    }

    public function datumZavrsetka(){
        if(!$this->datum_zavrsetka) return '';
        return Carbon::parse($this->datum_zavrsetka)->format('d.m.Y');
    }
}
