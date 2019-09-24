<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisciplinskaOdgovornost extends Model{
    protected $table = "disciplinska_odgovornost";

    protected $fillable = [
        'sluzbenik_id', 'datum_povrede', 'opis_povrede','opis_disciplinske_mjere', 'datum_rjesenja_zabrane','broj_rjesenja_zabrane', 'datum_zavrsetka_zabrane'
    ];

    public function sluzbenik(){
        return $this->belongsTo('App\Models\Sluzbenik', 'sluzbenik_id');
    }
}
