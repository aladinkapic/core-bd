<?php

namespace App\Models\DummyModels;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PrestanakRO extends Model{
    protected $table = 'sluzbenik_prestanak_radnog_odnosa';
    protected $guarded = ['id'];

    public function datumRješenja(){
        if(!$this->datum_rjesenja) return '';
        return Carbon::parse($this->datum_rjesenja)->format('d.m.Y');
    }

    public function datumPrestanka(){
        if(!$this->datum_prestanka) return '';
        return Carbon::parse($this->datum_prestanka)->format('d.m.Y');
    }

    public function osnov_za_prestanak_sl()
    {
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'osnov_za_prestanak')
            ->where('type', '=', 'osnov_za_prestanak_ro');
    }
}
