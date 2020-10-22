<?php

namespace App\Models\DummyModels;
use App\Models\Sifrarnik;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ZasnivanjeRO extends Model{
    protected $table = 'sluzbenik_zasnivanje_radnog_odnosa';
    protected $guarded = ['id'];

    public function nacin_zasnivanja_ro_s(){
        return $this->hasOne(Sifrarnik::class,'value', 'nacin_zasnivanja_r_o')
            ->where('type','nacin_zasnivanja_ro');
    }
    public function vrsta_r_o_s(){
        return $this->hasOne(Sifrarnik::class,'value', 'vrsta_r_o')
            ->where('type','vrsta_radnog_odnosa');
    }
    public function obracunati_r_staz_s(){
        return $this->hasOne(Sifrarnik::class,'value', 'obracunati_r_staz')
            ->where('type','obracunati_staz');
    }

    public function datumZasnivanjaRO(){
        if(!$this->datum_zasnivanja_o) return '';
        return Carbon::parse($this->datum_zasnivanja_o)->format('d.m.Y');
    }
    public function datumPrestankaRO(){
        if(!$this->datum_prestanka_ro) return '';
        return Carbon::parse($this->datum_prestanka_ro)->format('d.m.Y');
    }

    public function datumDonosenjaDokumentacije(){
        if(!$this->datum_donosenja_dokumentacije) return '';
        return Carbon::parse($this->datum_donosenja_dokumentacije)->format('d.m.Y');
    }

    public function nacin_zasnivanja_sl()
    {
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'nacin_zasnivanja_r_o')
            ->where('type', '=', 'nacin_zasnivanja_ro');
    }

    public function vrsta_radnog_sl()
    {
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'vrsta_r_o')
            ->where('type', '=', 'vrsta_radnog_odnosa');
    }

    public function obracunati_staz_sl()
    {
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'obracunati_r_staz')
            ->where('type', '=', 'obracunati_staz');
    }
}
