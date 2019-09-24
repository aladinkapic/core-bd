<?php

namespace App\Models;
use App\Models\Uprava;
use Illuminate\Database\Eloquent\Model;

class StrateskoPlaniranje extends Model{
    protected $table = 'ostalo'; // postavi custom tabelu za ovaj model


    protected $fillable = [
        'id_rm', 'id_oju', 'datum_broj', 'pb_neodredjeno', 'pb_odredjeno', 'pb_prekobrojnih', 'pb_godina',
        'pot_b_neodredjeno', 'pot_b_odredjeno', 'pot_b_godina'
    ];


    public function organJU(){
        return $this->belongsTo('App\Models\Uprava', 'id_oju');
    }

}
