<?php

namespace App\Http\Controllers;
use App;
use App\Models\Organ;
use App\Models\Organizacija;
use App\Models\Privremeno;
use App\Models\RadnoMjesto;
use App\Models\Sluzbenik;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Code;
use App\Models\Check;
use Illuminate\Queue\RedisQueue;

class InternoTrzisteController extends Controller{

    public function __construct(){
        $this->middleware('role:interno_trziste');
    }
    /*******************************************************************************************************************
     *
     *      Interno tržište rada je podijeljeno u dva dijela :
     *          1. Upražnjena radna mjesta
     *          2. Prekobrojni ljudi; trajni-privremeni premještaj
     *
     ******************************************************************************************************************/

    public function pregled(){

        $radnaMjesta = $radnaMjesta = RadnoMjesto::whereHas('orgjed.organizacija', function ($query){
            $query->where('active', '=', 1);
        })->where('status', '1')->with('orgjed.organizacija.organ')->with('sluzbenici')->with('rukovodeca_pozicija', 'stepenSS', 'katgorijaa', 'kompetencijeRel', 'sluzbeniciRel');;

        // $radnaMjesta = RadnoMjesto::with('orgjed.organizacija.organ')->with('sluzbenici')->with('rukovodeca_pozicija', 'stepenSS', 'katgorijaa', 'kompetencijeRel', 'sluzbeniciRel');
        $radnaMjesta = FilterController::filter($radnaMjesta);

        $filteri = [
            'id' => '#',
            'naziv_rm' => 'Naziv radnog mjesta',
            'broj_izvrsilaca' => 'Broj izvršilaca',
            'uposleno' => 'Zaposlenih',
            'platni_razred' => 'Platni razred',
            'stepenSS.name' => 'Stepen',
            'katgorijaa.name' => 'Kategorija radnog mjesta',
            'orgjed.naziv' => 'Organizacijska jedinica',
            'orgjed.organizacija.organ.naziv' => 'Organ javne uprave',
            'kompetencijeRel.name' => 'Kompetencije',
            'sluzbeniciRel.sluzbenik.ime_prezime' => 'Službenici',
        ];

        return view('ostalo.interno_trziste.pregled', compact('radnaMjesta', 'filteri'));
    }

    public function radnoMjesto($id){
        $radno_mj = RadnoMjesto::where('id', $id);

        return view('ostalo.interno_trziste.radnomjesto', compact('radno_mj', 'id'));
    }

    public function rjesenje(Request $request){
        return RadnoMjesto::where('id', $request->id)->first()->rjesenje;
    }
    public function rjesenjeKorisnika(Request $request){
        return Sluzbenik::where('id', $request->id)->first()->rjesenje;
    }

    public function dbUnos(Request $request, $radnoMjesto = null){
        if($radnoMjesto){ // Ovdje updejtujemo radna mjesta
            try{
                return RadnoMjesto::where('id', $request->id)->update($request->except(['_method', 'id']));
            }catch (\Exception $e){
                return false;
            }
        }else{ // Ovdje updejtujemo sluzbenike
            try{
                return Sluzbenik::where('id', $request->id)->update($request->except(['_method', 'id']));
            }catch (\Exception $e){
                return false;
            }
        }
    }

    public function spremiRjesenje(Request $request){
        if($this->dbUnos($request, true)) return Code::generateCode(App::make('App\Models\Check')->getErrorCode('0000'));
        else return Code::generateCode(App::make('App\Models\Check')->getErrorCode('2000'));
    }
    public function spremiRjesenjeKorisnika(Request $request){
        if($this->dbUnos($request)) return Code::generateCode(App::make('App\Models\Check')->getErrorCode('0000'));
        else return Code::generateCode(App::make('App\Models\Check')->getErrorCode('2000'));
    }


    /******************************************* PREKOBROJNI LJUDI ****************************************************/
    public function prekobrojniLjudi(){

        $radnaMjesta = $radnaMjesta = RadnoMjesto::whereHas('orgjed.organizacija', function ($query){
            $query->where('active', '=', 1);
        })->where('status', '2')->with('orgjed.organizacija.organ')->with('sluzbenici')->with('rukovodeca_pozicija', 'stepenSS', 'katgorijaa', 'kompetencijeRel', 'sluzbeniciRel');;
        $prekobrojni = true;

        $radnaMjesta = FilterController::filter($radnaMjesta);

        $filteri = [
            'id' => '#',
            'naziv_rm' => 'Naziv radnog mjesta',
            'broj_izvrsilaca' => 'Broj izvršilaca',
            'uposleno' => 'Zaposlenih',
            'platni_razred' => 'Platni razred',
            'stepenSS.name' => 'Stepen',
            'katgorijaa.name' => 'Kategorija radnog mjesta',
            'orgjed.naziv' => 'Organizacijska jedinica',
            'orgjed.organizacija.organ.naziv' => 'Organ javne uprave',
            'kompetencijeRel.name' => 'Kompetencije',
            'sluzbeniciRel.sluzbenik.ime_prezime' => 'Službenici',
        ];

        return view('ostalo.interno_trziste.prekobrojni', compact('radnaMjesta', 'prekobrojni', 'filteri'));
    }

    public function sviPrekobrojniLjudi($id) {
        $sluzbenici = Sluzbenik::where('radno_mjesto', $id)->get();

        return view('ostalo.interno_trziste.prekobrojni', compact('sluzbenici'));

    }


    /****************************************** PRIVREMENI PREMJEŠTAJ *************************************************/

    public function privremeniPremjestaj(){
        $trenutno = Carbon::now()->format('Y-m-d');

        $ugovori = Privremeno::whereDate('datum_do', '>=', $trenutno)->orWhere('datum_do', null);

        $ugovori = Privremeno::where(function ($query) use ($trenutno){
            $query->whereDate('datum_do', '>=', $trenutno)
                ->orWhereNULL('datum_do');
        });

        $ugovori = FilterController::filter($ugovori);

        $filteri = [
            'id' => '#',
            'usluzbenik.ime_prezime'=>'Službenik',
            'usluzbenik.sluzbenikRel.rm.naziv_rm'=>'Redovno radno mjesto',
            'usluzbenik.sluzbenikRel.rm.orgjed.naziv' => 'Organizaciona jedinica',
            'usluzbenik.sluzbenikRel.rm.orgjed.organizacija.organ.naziv' => 'Organ javne uprave',
            'privremeno_mjesto.naziv_rm'=>'Privremeno radno mjesto',
            'privremeno_mjesto.orgjed.naziv'=>'Privremena organizaciona jedinica',
            'privremeno_mjesto.orgjed.organizacija.organ.naziv'=>'Privremeni organ',
            'broj_rjesenja'=>'Broj rješenja',
            'datum_rjesenja'=>'Datum rješenja',
            'datum_od'=>'Datum od',
            'datum_do'=>'Datum do',
        ];

        return view('ostalo.interno_trziste.privremeni_premjestaj', compact('ugovori', 'filteri'));
    }

}
