<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisciplinskaKomisija extends Model{
    protected $table = "disciplinska_komisija";

    protected $fillable = [
        'disciplinska_odgovornost_id', 'ime_i_prezime', 'institucija'
    ];
}
