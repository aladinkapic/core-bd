<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Odsustva extends Model{
    protected $table = 'odsustva'; // postavi custom tabelu za ovaj model


    protected $fillable = [
        'vrsta_odsustva', 'sluzbenik_id', 'datum', 'putni_nalog', 'naknade', 'troskovi', 'napomena'
    ];
}
