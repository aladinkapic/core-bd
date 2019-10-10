<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Dodatno extends Model
{
    //

    protected $table = 'ugovori_dodatne_djelatnosti';

    protected $guarded = ['id'];

    public function usluzbenik(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik');
    }

    public function datumRješenja(){
        if(!$this->datum_rjesenja) return '';
        return Carbon::parse($this->datum_rjesenja)->format('d.m.Y');
    }
}
