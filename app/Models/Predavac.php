<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Predavac extends Model{
    protected $table = "predavaci";

    protected $guarded = ['id'];

    public function getFullNameAttribute($value){
        return ucfirst($this->ime) . ' ' . ucfirst($this->prezime);
    }
}
