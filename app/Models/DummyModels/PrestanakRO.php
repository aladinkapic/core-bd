<?php

namespace App\Models\DummyModels;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PrestanakRO extends Model{
    protected $table = 'sluzbenik_prestanak_radnog_odnosa';

    public function datumRješenja(){
        if(!$this->datum_rjesenja) return '';
        return Carbon::parse($this->datum_rjesenja)->format('d.m.Y');
    }
}
