<?php

namespace App\Models\DummyModels;

use Illuminate\Database\Eloquent\Model;

class Suspenzija extends Model{
    protected $table = 'suspenzija';

    protected $fillable = [
        'disciplinska_odgovornost_id', 'broj_rjesenja', 'razlog_udaljenja', 'datum_udaljenja'
    ];

    public function disciplinskaOdgovornost(){
        return $this->belongsTo('App\Models\DisciplinskaOdgovornost', 'disciplinska_odgovornost_id');
    }
}
