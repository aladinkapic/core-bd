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

        $radnaMjesta = RadnoMjesto::with('orgjed.organizacija.organ')->with('sluzbenici')->with('rukovodeca_pozicija', 'stepenSS', 'katgorijaa', 'kompetencijeRel', 'sluzbeniciRel');
        $radnaMjesta = FilterController::filter($radnaMjesta, 100);

        $filteri = [
            'id' => '#',
            'naziv_rm' => 'Naziv radnog mjesta',
            // 'sifra_rm' => 'Šifra radnog mjesta',
            'broj_izvrsilaca' => 'Broj izvršilaca',
            'uposlenika' => 'Zaposlenih',
            'platni_razred' => 'Platni razred',
            'stepenSS.name' => 'Stepen',
            'katgorijaa.name' => 'Kategorija radnog mjesta',
            'orgjed.naziv' => 'Organizacijska jedinica',
            'orgjed.organizacija.organ.naziv' => 'Organ javne uprave',
            'kompetencijeRel.name' => 'Kompetencije',
            'sluzbeniciRel.sluzbenik.ime_prezime' => 'Službenici',
        ];


//        $radnaMjesta = RadnoMjesto::whereHas('orgjed.organizacija', function ($query){
//            $query->where('active', '=', 1);
//        })->with('sluzbeniciRel.sluzbenik')
//        ->with('orgjed.organizacija.organ');
//
//
//        $radnaMjesta = FilterController::filter($radnaMjesta);
//
//        $filteri = [
//            'id' => '#',
//            'naziv_rm'=>'Naziv radnog mjesta',
//            'orgjed.naziv'=>'Naziv organizacione jedinice',
//            'orgjed.organizacija.organ.naziv'=>'Organ javne uprave',
//            'sifra_rm'=>'Šifra radnog mjesta',
//            'broj_izvrsilaca'=>'Ukupan broj izvršilaca',
//            ''=>'Broj izvršilaca',
//            'sluzbeniciRel.sluzbenik.ime_prezime' => 'Službenici'
//        ];
//
//        $planovi = Organizacija::where('active', '1');
//        $planovi = FilterController::filter($planovi);
//
//        $filteri = [
//            'id' => '#',
//            'organizacioneJedinice.radnaMjesta.naziv_rm'=>'Naziv radnog mjesta',
//            'organizacioneJedinice.naziv'=>'Naziv organizacione jedinice',
//            'organizacioneJedinice.radnaMjesta.sifra_rm'=>'Šifra radnog mjesta',
//            'organizacioneJedinice.radnaMjesta.broj_izvrsilaca'=>'Ukupan broj izvršilaca',
//            'organizacioneJedinice.radnaMjesta.sluzbenici.count()'=>'Broj izvršilaca',
//        ];

        $withoutPag = true;

        return view('ostalo.interno_trziste.pregled', compact('radnaMjesta', 'filteri', 'withoutPag'));
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
        $prekobrojni = true;

        $radnaMjesta = RadnoMjesto::whereHas('orgjed.organizacija', function ($query){
            $query->where('active', '=', 1);
        })->with('sluzbeniciRel.sluzbenik')
            ->with('orgjed.organizacija.organ');

        $radnaMjesta = FilterController::filter($radnaMjesta);

        $filteri = [
            'id' => '#',
            'naziv_rm'=>'Naziv radnog mjesta',
            'orgjed.naziv'=>'Naziv organizacione jedinice',
            'orgjed.organizacija.organ.naziv'=>'Organ javne uprave',
            'sifra_rm'=>'Šifra radnog mjesta',
            'broj_izvrsilaca'=>'Ukupan broj izvršilaca',
            ''=>'Broj izvršilaca',
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

        $ugovori = Privremeno::whereDate('datum_do', '>=', $trenutno)->orWhere('datum_do', null)->with('usluzbenik')->with('mjesto')->with('privremeno_mjesto');
        $ugovori = FilterController::filter($ugovori);

        $filteri = [
            'id' => '#',
            'usluzbenik.ime_prezime'=>'Službenik',
            'mjesto.naziv_rm'=>'Redovno radno mjesto',
            'privremeno_mjesto.naziv_rm'=>'Privremeno radno mjesto',
            'broj_rjesenja'=>'Broj rješenja',
            'datum_rjesenja'=>'Datum rješenja',
            'datum_od'=>'Datum od',
            'datum_do'=>'Datum do',
        ];

//        return view('hr.ugovori.privremeno.index')->with(compact('ugovori', 'filteri'));
//
//
//        $sluzbenici = Sluzbenik::whereNotNull('privremeni_premjestaj')->with('privremeniPremjestajRel.privremeno_mjesto')
//            ->with('radnoMjesto')
//        ;

//        dd($sluzbenici->get()[1]->privremeniPremjestajRel->datumRjesenja());

//        $sluzbenici = FilterController::filter($sluzbenici);

//        $filteri = [
//            'id' => '#',
//            'ime_prezime'=>'Ime i prezime službenika',
//            'radnoMjesto.naziv_rm'=>'Radno mjesto',
//            'privremeniPremjestajRel.privremeno_mjesto.naziv_rm'=>'Privremeni premještaj',
//            'privremeniPremjestajRel.broj_rjesenja'=>'Broj rješenja',
//            'privremeniPremjestajRel.datum_rjesenja'=>'Datum rješenja',
//            'privremeniPremjestajRel.datum_od'=>'Datum od',
//            'privremeniPremjestajRel.datum_do'=>'Datum do',
//        ];

        return view('ostalo.interno_trziste.privremeni_premjestaj', compact('ugovori', 'filteri'));
    }

}
