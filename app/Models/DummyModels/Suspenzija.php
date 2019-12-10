<?php

namespace App\Models\DummyModels;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Suspenzija extends Model{
    protected $table = 'suspenzija';

    protected $guarded = ['id'];
    public function disciplinskaOdgovornost(){
        return $this->belongsTo('App\Models\DisciplinskaOdgovornost', 'disciplinska_odgovornost_id');
    }

    public function datumUdaljenjaa(){
        if(!$this->datum_udaljenja) return '';
        return Carbon::parse($this->datum_udaljenja)->format('d.m.Y');
    }
    public function datumPovratka(){
        if(!$this->datum_rjesenja_o_povratku) return '';
        return Carbon::parse($this->datum_rjesenja_o_povratku)->format('d.m.Y');
    }
}
