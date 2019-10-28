<?php

namespace App\Models\DummyModels;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Zalbe extends Model{
    protected $table = 'zalba';

    protected $fillable = [
        'disciplinska_odgovornost_id', 'broj_ulozene_zalbe', 'datum_ulozene_zalbe', 'broj_odluke_zalbe',
        'datum_odluke_zalbe',
    ];

    public function disciplinskaOdgovornost(){
        return $this->belongsTo('App\Models\DisciplinskaOdgovornost', 'disciplinska_odgovornost_id');
    }

    public function datumUlozene(){
        if(!$this->datum_ulozene_zalbe) return '';
        return Carbon::parse($this->datum_ulozene_zalbe)->format('d.m.Y');
    }

    public function datumOdluke(){
        if(!$this->datum_udaljenja) return '';
        return Carbon::parse($this->datum_udaljenja)->format('d.m.Y');
    }
}
