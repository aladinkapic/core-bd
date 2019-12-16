<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use phpDocumentor\Reflection\Types\Self_;

class RadnoMjesto extends Model
{
    protected $table = 'radna_mjesta'; // postavi custom tabelu za ovaj model
    protected $aktivni = null;

    protected $fillable = [
        'naziv_rm', 'sifra_rm', 'opis_rm', 'broj_izvrsilaca', 'platni_razred', 'tip_rm', 'kategorija_rm', 'id_oju', 'id_oj', 'strucna_sprema', 'tip_pm',
        'parent_id', 'rukovodioc'
    ];

    public function orgjed()
    {
        return $this->hasOne(OrganizacionaJedinica::class, 'id', 'id_oj');
    }

    public static function aktivnaa()
    {
        dump(RadnoMjesto::with('orgjed')->get());
    }

    public function full_name($value)
    {
        return ucfirst($this->broj) . ' ' . ucfirst($this->naziv);
    }

    public static function aktivna($columns = '*')
    {
        $o = new self();
        $rm = DB::table($o->table)
            ->select([$o->table . '.' . $columns])
            ->join('org_jedinica', function ($join) {
                $join->on('radna_mjesta.id_oj', '=', 'org_jedinica.id');
            })
            ->join('organizacija', function ($join) {
                $join->on('organizacija.id', '=', 'org_jedinica.org_id');
            })
            ->where('organizacija.active', '=', 1)->get();
        return $rm;
    }

    public static function aktivnaUpraznjena()
    {
        $o = new self();
        dd(DB::raw('SELECT count(sl.*) as broj_sl from radna_mjesta rm 
                              INNER JOIN org_jedinice oj ON oj.id = rm.id_oj
                              INNER JOIN organizacija o ON oj.org = o.id
                              INNER JOIN sluzbenici sl ON sl.radno_mjesto = rm.id
                              WHERE o.active = 1 AND broj_sl != rm.broj_izvrsilaca
                              '))->get();


//        return DB::table($o->table)
//            ->select([$o->table . '.*'])
//            ->join('org_jedinica', function ($join) {
//                $join->on('radna_mjesta.id_oj', '=', 'org_jedinica.id');
//            })
//            ->join('organizacija', function ($join) {
//                $join->on('organizacija.id', '=', 'org_jedinica.org_id');
//            })
//            ->where('organizacija.active', '=', 1)->get();
    }

    public static function aktivnaBezPaginacije()
    {
        $o = new self();
        $rm = DB::table($o->table)
            ->select([$o->table . '.*'])
            ->join('org_jedinica', function ($join) {
                $join->on('radna_mjesta.id_oj', '=', 'org_jedinica.id');
            })
            ->join('organizacija', function ($join) {
                $join->on('organizacija.id', '=', 'org_jedinica.org_id');
            })
            ->where('organizacija.active', '=', 1)->get();
        return $rm;
    }

    public static function organizacijska($id)
    {
        $o = new self();

        return DB::table($o->table)
            ->select([$o->table . '.*'])
            ->join('org_jedinica', function ($join) {
                $join->on('radna_mjesta.id_oj', '=', 'org_jedinica.id');
            })
            ->join('organizacija', function ($join) {
                $join->on('organizacija.id', '=', 'org_jedinica.org_id');
            })
            ->where('organizacija.id', '=', $id);
    }

    public function sluzbenici(){
        return $this->hasMany('App\Models\Sluzbenik', 'radno_mjesto');
    }

    public function sluzbeniciRel(){
        return $this->hasMany(RadnoMjestoSluzbenik::class, 'radno_mjesto_id', 'id');
    }

    public static function parent($org_jed){
        return RadnoMjesto::where('id_oj', '=', $org_jed)->where('rukovodioc', '=', 1)->first();
    }

    public function rukovodeca_pozicija(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'rukovodioc')->where('type', 'rukovodeca_pozicija');
    }
    public function rukovodioc_s(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'rukovodioc')
            ->where('type', '=', 'rukovodeca_pozicija');
    }
    public function katgorijaa(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'kategorija_rm')
            ->where('type', '=', 'kategorija_radnog_mjesta');
    }
    public function strucnaSprema(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'strucna_sprema')
            ->where('type', '=', 'strucna_sprema');
    }
    public function tipRadnogMjesta(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'tip_rm')
            ->where('type', '=', 'tip_radnog_mjesta');
    }
    public function tipPrivremenogPremjestaja(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'ip_pm')
            ->where('type', '=', 'tip_privremenog_premjestaja');
    }


}
