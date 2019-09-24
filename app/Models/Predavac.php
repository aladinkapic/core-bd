<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Predavac extends Model{
    protected $table = "predavaci";

    protected $fillable = [
        'ime', 'prezime', 'telefon','mail', 'napomena','teme'
    ];

}
