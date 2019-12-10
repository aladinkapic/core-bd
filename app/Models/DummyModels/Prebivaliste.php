<?php

namespace App\Models\DummyModels;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Prebivaliste extends Model{
    protected $table = 'sluzbenik_podaci_o_prebivalistu';

    public function datumDo(){
        if(!$this->datum_do) return '';
        return Carbon::parse($this->datum_do)->format('d.m.Y');
    }
}
