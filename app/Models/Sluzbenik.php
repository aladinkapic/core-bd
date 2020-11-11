<?php

namespace App\Models;
use App;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Notifications\Notifiable;
use App\Models\Sifrarnik;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Sluzbenik extends Model{
    use Notifiable;
    public $_godina, $_mjeseci, $_dana, $_ukupan_broj_dana;

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    /*******************************************************************************************************************
     *
     *      Pored svih informacija, potrebno je čuvati informaciju o tome da li je službenik stekao pravo da se
     *      penzioniše i o tome da li je zapravo penzionisan : (
     *
     *      To ćemo čuvati u dvije kolone, uskoro_se_penzionise, penzionsian
     *
     ******************************************************************************************************************/

    protected $table = 'sluzbenici'; // postavi custom tabelu za ovaj model
    protected $kategorija = 'kategorija';
    public $podaci_o_prebivalistu = null, $strucna_sprema = null, $ispiti = null, $kontakt_detalji = null,
           $obrazovanje = null, $vjestine = null, $zasnivanje_ro = null, $prethodno_ri = null, $prestanak_ro = null,
           $clanovi_porodice = null;


    /*******************************************************************************************************************
     *
     *      Ovdje čuvamo ukupan broj dana, odnosno broj godina, mjeseci i dana koje je službenik proveo radeći u
     *      nekoj od kompanija.
     *
     ******************************************************************************************************************/

    protected $ukupan_broj_dana = 0, $godina = 0, $mjeseci = 0, $dana = 0;

    protected $guarded = ['id'];


    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }

    // Laravel accessors - https://laravel.com/docs/5.4/eloquent-mutators#defining-an-accessor
    public function getFullNameAttribute($value){
        return ucfirst($this->ime) . ' ' . ucfirst($this->prezime).' - '.ucfirst($this->id);
    }
    public function getNameWorkPlaceAttribute($value){
        isset($this->sluzbenikRel->rm->naziv_rm) ? $rm = $this->sluzbenikRel->rm->naziv_rm : $rm = '';

        return ucfirst($this->ime) . ' ' . ucfirst($this->prezime).' ('.$rm.')';
    }

    public function radnoMjesto(){
        return $this->belongsTo('App\Models\RadnoMjesto', 'radno_mjesto');
    }

    public function privremeniPremjestaj(){
        return $this->belongsTo('App\Models\RadnoMjesto', 'privremeni_premjestaj');
    }

    public static function sviPodaci(){
        return DB::table("sluzbenici")
            ->join('sluzbenik_podaci_o_prebivalistu', function ($join) {
                $join->on('sluzbenici.id', '=', 'sluzbenik_podaci_o_prebivalistu.id_sluzbenika');
            })
            ->get();
    }

    public function dodatnaTabela(){
        return $this->hasMany((new Generic('sluzbenik_podaci_o_prebivalistu')) , 'id_sluzbenika');
    }


//    public function dodatno(){
//        $this->podaci_o_prebivalistu = DB::table('sluzbenik_podaci_o_prebivalistu')->where('id_sluzbenika', $this->id)->get();
//        $this->strucna_sprema        = DB::table('sluzbenik_strucna_sprema')->where('id_sluzbenika', $this->id)->get();
//        $this->ispiti                = DB::table('sluzbenik_ispiti')->where('id_sluzbenika', $this->id)->get();
//        $this->kontakt_detalji       = DB::table('sluzbenik_kontakt_detalji_osobe')->where('id_sluzbenika', $this->id)->get();
//        $this->obrazovanje           = DB::table('sluzbenik_obrazovanje_sluzbenika')->where('id_sluzbenika', $this->id)->get();
//        $this->vjestine              = DB::table('sluzbenik_vjestine_sluzbenika')->where('id_sluzbenika', $this->id)->get();
//        $this->zasnivanje_ro         = DB::table('sluzbenik_zasnivanje_radnog_odnosa')->where('id_sluzbenika', $this->id)->get();
//        $this->prethodno_ri          = DB::table('sluzbenik_prethodno_radno_iskustvo')->where('id_sluzbenika', $this->id)->get();
//        $this->prestanak_ro          = DB::table('sluzbenik_prestanak_radnog_odnosa')->where('id_sluzbenika', $this->id)->get();
//        $this->clanovi_porodice      = DB::table('sluzbenik_clanovi_porodice')->where('id_sluzbenika', $this->id)->get();
//    }

    public function clanoviPorodiceRel(){
        return $this->hasMany('App\Models\DummyModels\ClanoviPorodice', 'id_sluzbenika');
    }
    public function ispitiRel(){
        return $this->hasMany('App\Models\DummyModels\Ispiti', 'id_sluzbenika');
    }
    public function kontaktDetalji(){
        return $this->hasMany('App\Models\DummyModels\KontaktDetalji', 'id_sluzbenika');
    }
    public function obrazovanjeRel(){
        return $this->hasMany('App\Models\DummyModels\Obrazovanje', 'id_sluzbenika');
    }
    public function prebivaliste(){
        return $this->hasMany('App\Models\DummyModels\Prebivaliste', 'id_sluzbenika');
    }
    public function prestanakRORel(){
        return $this->hasMany('App\Models\DummyModels\PrestanakRO', 'id_sluzbenika');
    }
    public function prethodnoRIRel(){
        return $this->hasMany('App\Models\DummyModels\PrethodnoRI', 'id_sluzbenika');
    }
    public function strucnaSprema(){
        return $this->hasMany('App\Models\DummyModels\StrucnaSprema', 'id_sluzbenika');
    }
    public function vjestineRel(){
        return $this->hasMany('App\Models\DummyModels\Vjestine', 'id_sluzbenika');
    }
    public function zasnivanjeRORel(){
        return $this->hasMany('App\Models\DummyModels\zasnivanjeRO', 'id_sluzbenika');
    }
    public function uloge(){
        return $this->hasMany('App\Models\Uloge', 'sluzbenik_id');
    }


    /*******************************************************************************************************************
     *
     *      Property službenika u zavisnosti od šifrarnika.
     *
     ******************************************************************************************************************/

    public function spol_sl(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'pol')
            ->where('type', '=', 'spolovi');
    }
    public function poreskaUprava(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'PIO')
            ->where('type', '=', 'pio');
    }
    public function kategorija_sl(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'kategorija')
            ->where('type', '=', 'kategorija');
    }
    public function bracni_status_sl(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'bracni_status')
            ->where('type', '=', 'bracni_status');
    }
    public function nacionalnost_sl(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'nacionalnost')
            ->where('type', '=', 'nacionalnost');
    }
    public function pioRel(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'PIO')
            ->where('type', '=', 'pio');
    }
    public function drzavljanstvoRel(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'drzavljanstvo_1')
            ->where('type', '=', 'drzava');
    }

    public function trenutno_zaposlen_sl(){
        return $this->hasOne('App\Models\Sifrarnik', 'value', 'trenutno_radi')
            ->where('type', '=', 'trenutno_radi');
    }

    public function datumRodjenja(){
        if(!$this->datum_rodjenja) return '';
        return Carbon::parse($this->datum_rodjenja)->format('d.m.Y');
    }

    public function neplacenoOdustvoKarton(){
        try{
            if($this->neplaceno_odsustvo != null) return Carbon::parse($this->neplaceno_odsustvo)->format('d.m.Y');
            else return "";
        }catch (\Exception $e){
            return "";
        }
    }

    public static function whereOrgan($id){

        $sluzbenici_raw = DB::table('sluzbenici')
            ->select('sluzbenici.id')
            ->join('radna_mjesta', function ($t){
                $t->on('sluzbenici.radno_mjesto', '=', 'radna_mjesta.id');
            })
            ->join('org_jedinica', function ($t){
                $t->on('radna_mjesta.id_oj', '=', 'org_jedinica.id');
            })
            ->join('organizacija', function ($t){
                $t->on('org_jedinica.org_id', '=', 'organizacija.id');
            })
            ->where('organizacija.oju_id', '=', $id)->get();

        $sluzbenici = collect();


        foreach($sluzbenici_raw as $sluzbenik){
            $sluzbenici->push(Sluzbenik::find($sluzbenik->id));
        }

        return $sluzbenici;
    }

    public static function organJavneUprave($id){
        return DB::table('organ_ju')
            ->select('organ_ju.id')
            ->join('organizacija', function ($t){
                $t->on('organ_ju.id', '=', 'organizacija.oju_id');
            })
            ->join('org_jedinica', function ($t){
                $t->on('organizacija.id', '=', 'org_jedinica.org_id');
            })
            ->join('radna_mjesta', function ($t){
                $t->on('org_jedinica.id', '=', 'radna_mjesta.id_oj');
            })
            ->join('sluzbenici', function ($t){
                $t->on('radna_mjesta.id', '=', 'sluzbenici.radno_mjesto');
            })
            ->where('sluzbenici.id', '=', $id)
            ->get();
    }


    public static function radnaMjesta($id){
        return DB::table('radna_mjesta')
            ->select(['radna_mjesta.id', 'radna_mjesta.naziv_rm'])
            ->join('org_jedinica', function($e){
                $e->on('radna_mjesta.id_oj', '=', 'org_jedinica.id');
            })
            ->join('organizacija', function($e){
                $e->on('org_jedinica.org_id', '=', 'organizacija.id');
            })
            ->join('organ_ju', function($e){
                $e->on('organizacija.oju_id', '=', 'organ_ju.id');
            })
            ->where('organ_ju.id', '=', $id)
            ->get();
    }

    public static function hasRole($role, $sluzbenik){
        foreach($sluzbenik->uloge as $rola){
            if($rola->keyword == $role){
                if($rola->vrijednost == 1) return true;
            }
        }

        return false;
    }

    public static function me(){
        return Sluzbenik::where('id', '=', Crypt::decryptString(Session::get('ID')))->first();
    }

    public function sluzbenikRel(){
        return $this->hasOne(RadnoMjestoSluzbenik::class, 'sluzbenik_id', 'id');
    }
    public function privremeniPremjestajRel(){
        return $this->hasOne(Privremeno::class, 'id', 'privremeni_premjestaj');
    }
    public function upravljanjeUcinkom(){
        return $this->hasOne(UpravljanjeUcinkom::class, 'sluzbenik', 'id')->where('godina', date('Y'));
    }



    // Radni staž

    public function daniStazNew($godina, $mjeseci, $dana){
        $this->_godina  = $godina;
        $this->_mjeseci = $mjeseci;
        $this->_dana    = $dana;

        return $this->_godina.' godina '.$this->_mjeseci.' mjeseci i '.$this->_dana.' dana.';
    }

    public function godinaStaza(){return $this->_godina;}
    public function mjeseciIStaza(){return $this->_mjeseci;}
    public function danaStaza(){return $this->_dana;}

    public function ukupnoDana(){return $this->_ukupno_dana;}

    public function radniStaz(){
        $number_of_days = 0;

        // Logika računanja radnog staža; U zasnivanju se unosi radni staž u godinama, danima i mjesecima do trenutka
        // stupanja na dužnost
        // Radni staž se računa kao zbir tog staža i broja dana proteklih od tog datuma !

        // Prvo pretvorimo godine, mjesece i dane u dane
        if(count($this->zasnivanjeRORel)){
            if($this->zasnivanjeRORel->last()->datum_zasnivanja_o == null) return null;
            $date = explode("-", $this->zasnivanjeRORel->last()->datum_zasnivanja_o);

//            try{
//                $date = Carbon::createFromDate($this->zasnivanjeRO->last()->datum_stupanja_na_duznost_zasni)->diff(Carbon::now())->format('%y-%m-%d');
//            }catch (\Exception $e){}

            // Returns years - months - days
            $time = explode("-", Carbon::createFromDate($date[0], $date[1], $date[2])->diff(Carbon::now())->format('%y-%m-%d'));

            $years  = $time[0];
            $months = $time[1];
            $days   = $time[2];


            $finalYears = 0; $finalMonths = 0; $finalDays = 0;
            if(($days + $this->zasnivanjeRORel->last()->obracunati_r_s_dan) > 30){
                $finalDays = ($days + $this->zasnivanjeRORel->last()->obracunati_r_s_dan - 30);
                $finalMonths += 1;
            }else{
                $finalDays = $days + $this->zasnivanjeRORel->last()->obracunati_r_s_dan;
            }

            if(($months + $this->zasnivanjeRORel->last()->obracunati_r_s_mje + $finalMonths) > 11){
                $finalYears += 1;
                $finalMonths = ($months + $this->zasnivanjeRORel->last()->obracunati_r_s_mje + $finalMonths - 12);
            }else{
                $finalMonths = $months + $this->zasnivanjeRORel->last()->obracunati_r_s_mje + $finalMonths;
            }
            $finalYears += ($years + $this->zasnivanjeRORel->last()->obracunati_r_s_god);

            return $this->daniStazNew($finalYears, $finalMonths, $finalDays);
        }

    }

    public function privremeniRel(){
        return $this->hasOne(Privremeno::class, 'id', 'privremeni_premjestaj');
    }
}
