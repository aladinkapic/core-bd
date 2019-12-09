<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DisciplinskaOdgovornost extends Model{
    protected $table = "disciplinska_odgovornost";

    protected $guarded = ['id'];

    public function sluzbenik(){
        return $this->belongsTo('App\Models\Sluzbenik', 'sluzbenik_id');
    }

    public function datumPovrede(){
        if(!$this->datum_povrede) return '';
        return Carbon::parse($this->datum_povrede)->format('d.m.Y');
    }

    public function datumZabrane(){
        if(!$this->datum_rjesenja_zabrane) return '';
        return Carbon::parse($this->datum_rjesenja_zabrane)->format('d.m.Y');
    }

    public function datumZavrsetka(){
        if(!$this->datum_zavrsetka_zabrane) return '';
        return Carbon::parse($this->datum_zavrsetka_zabrane)->format('d.m.Y');
    }
}
