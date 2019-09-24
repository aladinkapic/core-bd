<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medijatori extends Model{
    protected $table = "medijatori";

    protected $fillable = [
        'disciplinska_odgovornost_id', 'ime_i_prezime', 'institucija'
    ];
}
