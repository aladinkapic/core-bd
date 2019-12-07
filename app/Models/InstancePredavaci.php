<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstancePredavaci extends Model
{
    protected $guarded = ['id'];
    protected $table = 'obuke_instance_predavaci';

    public function imePredavaca(){
        return $this->hasOne(Predavac::class,'id', 'predavac_id');
    }
    public function instance(){
        return $this->hasOne(InstanceObuke::class, 'id', 'instanca_id');
    }
}
