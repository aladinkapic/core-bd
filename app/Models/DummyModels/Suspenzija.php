<?php

namespace App\Models\DummyModels;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Suspenzija extends Model{
    protected $table = 'suspenzija';

    protected $fillable = [
        'disciplinska_odgovornost_id', 'broj_rjesenja', 'razlog_udaljenja', 'datum_udaljenja'
    ];

    public function disciplinskaOdgovornost(){
        return $this->belongsTo('App\Models\DisciplinskaOdgovornost', 'disciplinska_odgovornost_id');
    }

    public function datumUdaljenjaa(){
        if(!$this->datum_udaljenja) return '';
        return Carbon::parse($this->datum_udaljenja)->format('d.m.Y');
    }
}
