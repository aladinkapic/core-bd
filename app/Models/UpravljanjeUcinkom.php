<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpravljanjeUcinkom extends Model{
    protected $table = "upravljanje_ucinkom";

    protected $fillable = [
        'sluzbenik', 'radno_mjesto', 'godina','ocjena', 'opisna_ocjena','kategorija'
    ];
}
