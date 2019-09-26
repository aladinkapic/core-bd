<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model{
    protected $table = "teme";

    protected $fillable = [
        'naziv', 'oblast','napomena'
    ];

    public function oblast_s(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'oblast')->where('type', 'oblasti');
    }
}
