<?php

namespace App\Models\DummyModels;

use Illuminate\Database\Eloquent\Model;

class Medijatori extends Model{
    protected $table = 'medijatori';

    public function sluzbenik(){
        return $this->belongsTo('App\Models\Sluzbenik', 'sluzbenik_id_med', 'id');
    }
}
