<?php

namespace App\Models\DummyModels;

use Illuminate\Database\Eloquent\Model;

class Komisija extends Model{
    protected $table = 'disciplinska_komisija';

    public function sluzbenik(){
        return $this->belongsTo('App\Models\Sluzbenik', 'sluzbenik_id_kom');
    }
}
