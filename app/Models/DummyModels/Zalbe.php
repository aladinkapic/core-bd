<?php

namespace App\Models\DummyModels;

use Illuminate\Database\Eloquent\Model;

class Zalbe extends Model{
    protected $table = 'zalba';

    protected $fillable = [
        'disciplinska_odgovornost_id', 'broj_ulozene_zalbe', 'datum_ulozene_zalbe', 'broj_odluke_zalbe',
        'datum_odluke_zalbe',
    ];

    public function disciplinskaOdgovornost(){
        return $this->belongsTo('App\Models\DisciplinskaOdgovornost', 'disciplinska_odgovornost_id');
    }
}
