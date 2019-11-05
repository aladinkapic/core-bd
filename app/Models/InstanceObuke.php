<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstanceObuke extends Model{
    protected $table = 'obuke_nove_instance';
    protected $guarded = ['id'];

    public function predavaci(){
        return $this->hasMany(InstancePredavaci::class, 'instanca_id', 'id');
    }
    public function obuka(){
        return $this->hasOne(Obuka::class, 'id', 'obuka_id');
    }
}
