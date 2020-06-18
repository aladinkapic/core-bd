<?php

namespace App\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class Sifrarnik extends Model{
    protected $table = 'sifrarnici'; // postavi custom tabelu za ovaj model
    protected $fillable = [
        'type', 'value', 'name'
    ];

    protected $types = array(

        // Sistemski šifarnici
        array('tip_javne_uprave', 'Tip javne uprave'),
        array('nacionalnost', 'Nacionalnost službenika'),
        array('spolovi', 'Spol'),
        array('bracni_status', 'Bračni status službenika'),
        array('status_predmeta', 'Status predmeta'),
        array('status_zabrane', 'Status zabrane'),
        array('osiguranje', 'Osiguranje'),
        array('radno_vrijeme', 'Radno vrijeme'),
        array('vrsta_obuke', 'Vrsta obuke'),
        array('vrsta_vještine', 'Vrsta vještine'),
        array('nivo_vjestine', 'Nivo vještine'),
        array('status_sistematizacije', 'Status sistematizacije'),
        array('vrsta_odsustva', 'Vrsta odsustva'),
        array('kategorija', 'Kategorija službenika'),
        array('status', 'Status'),
        array('kategorija_radnog_mjesta', 'Kategorija radnog mjesta'),
        array('osnov_za_prestanak_ro', 'Osnov za prestanak radnog odnosa'),
        array('nacin_zasnivanja_ro', 'Način zasnivanja radnog odnosa'),
        array('vrsta_radnog_odnosa', 'Vrsta radnog odnosa'),
        array('obracunati_staz', 'Obračunati staž'),
        array('tip_privremenog_premjestaja', 'Tip privremenog premještaja'),
        array('tip_uslova', 'Tip uslova za radno mjesto'),
        array('strucna_sprema', 'Kompetencije'),
        array('tip_radnog_mjesta', 'Tip radnog mjesta'),
        array('tip_organizacione_jedinice', 'Tip organizacione jedinice'),
        array('kategorija_ocjene', 'Kategorija ocjene'),
        array('drzava','Država'),
        array('oblasti','Oblasti obuke'),
        array('kategorija_ocjene', 'Kategorija ocjene'),
        array('srodstvo', 'Srodstvo'),
        array('trenutno_radi', 'Trenutno zaposlen'),
        array('clanovi_porodice', 'Članovi porodice'),
        array('kategorija_ispita', 'Kategorija ispita'),
        array('rukovodeca_pozicija', 'Rukovodeća pozicija'),
        array('ekstenzija_domene', 'Domena'),
        array('opisna_probni', 'Opisna ocjena - probni rad'),
        array('opisna_ocjenaaa', 'Opisna ocjena'),
        array('pio', 'Poreska uprava'),
        array('obrazovna_institucija', 'Obrazovna institucija'),
        array('poslodavac', 'Poslodavac'),
        array('benificirani', 'Benificirani radni staž'),
        // array('kompetencije', 'Kompetencije'),
        array('stepen', 'Stepen'),
    );

    public static function dajKljucneRijeci(){
        $instance = new self();
        return $instance->types;
    }
    public static function dajNazivSifrarnika($type){
        $inst  = new self();
        $types = $inst->types;

        foreach($types as $tp){
            if($tp[0] == $type) return $tp[1];
        }
    }

    public static function dajSifrarnik($type){
        return Sifrarnik::where('type', $type)->pluck('name', 'value');

        // $instance = new self();
        // return DB::table($instance->table)->where('type', $type)->orderBy('name')->get()->pluck('name', 'value');
    }

    public static function dajInstancu($type, $value){
        $instance = new self();
        return DB::table($instance->table)->where('type', $type)->where('value', $value)->first()->name;
    }
    public static function dajInstancuByName($type, $value){
        $instance = new self();
        return DB::table($instance->table)->where('type', $type)->where('name', $value)->first();
    }
    public static function dajSifrarnikCollection($type){
        $instance = new self();
        return DB::table($instance->table)->where('type', $type)->orderBy('value', 'ASC')->get();
    }
}
