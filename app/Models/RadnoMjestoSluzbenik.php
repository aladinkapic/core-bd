<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadnoMjestoSluzbenik extends Model{
    protected $table = 'radno_mjesto_sluzbenici';
    protected $guarded = ['id'];


    public function sluzbenik(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik_id');
    }
    public function rm(){
        return $this->hasOne(Sluzbenik::class, 'id', 'radno_mjesto_id');
    }
}
