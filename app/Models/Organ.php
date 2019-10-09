<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organ extends Model{
    public $table = 'organ_ju';
    protected $guarded = ['id'];

    public function organizacija(){
        return $this->hasOne(Organizacija::class, 'oju_id', 'id')->where('active', '=', 1);
    }
}
