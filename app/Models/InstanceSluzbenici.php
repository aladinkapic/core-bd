<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstanceSluzbenici extends Model
{
    protected $guarded = ['id'];
    protected $table = 'obuke_instance_sluzbenici';

    public function imeSluzbenika(){
        return $this->hasOne(Sluzbenik::class, 'id', 'sluzbenik_id');
    }
}
