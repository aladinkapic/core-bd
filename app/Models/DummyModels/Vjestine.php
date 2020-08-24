<?php

namespace App\Models\DummyModels;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Vjestine extends Model{
    protected $table = 'sluzbenik_vjestine_sluzbenika';
    protected $guarded = ['id'];

    public function vrsta_vjestine_sl()
    {
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'vrsta_vjestine')
            ->where('type', '=', 'vrsta_vještine');
    }

    public function nivo_vjestine_sl()
    {
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'nivo_vjestine')
            ->where('type', '=', 'nivo_vjestine');
    }

    public function datumUvjerenja(){
        if(!$this->datum_uvjerenja) return '';
        return Carbon::parse($this->datum_uvjerenja)->format('d.m.Y');
    }
}
