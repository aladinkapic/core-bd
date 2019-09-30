<?php

namespace App\Http\Controllers;
use App;
use App\Models\Organizacija;
use App\Models\RadnoMjesto;
use App\Models\Sluzbenik;
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
        $planovi = Organizacija::where('active', '1');
        $planovi = FilterController::filter($planovi);

        $filteri = [
            'organizacioneJedinice.radnaMjesta.naziv_rm'=>'Naziv radnog mjesta',
            'organizacioneJedinice.naziv'=>'Naziv organizacione jedinice',
            'organizacioneJedinice.radnaMjesta.sifra_rm'=>'Šifra radnog mjesta',
            'organizacioneJedinice.radnaMjesta.broj_izvrsilaca'=>'Ukupan broj izvršilaca',
            'organizacioneJedinice.radnaMjesta.sluzbenici.count()'=>'Broj izvršilaca',
        ];

        return view('ostalo.interno_trziste.pregled', compact('planovi', 'filteri'));
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
        $planovi = Organizacija::where('active', '1');
        $prekobrojni = true;
        $planovi = FilterController::filter($planovi);

        $filteri = [
            'organizacioneJedinice.radnaMjesta.naziv_rm'=>'Naziv radnog mjesta',
            'organizacioneJedinice.naziv'=>'Naziv organizacione jedinice',
            'organizacioneJedinice.radnaMjesta.sifra_rm'=>'Šifra radnog mjesta',
            'organizacioneJedinice.radnaMjesta.broj_izvrsilaca'=>'Ukupan broj izvršilaca',
            'organizacioneJedinice.radnaMjesta.sluzbenici.count()'=>'Broj izvršilaca',
        ];

        return view('ostalo.interno_trziste.pregled', compact('planovi', 'prekobrojni', 'filteri'));
    }

    public function sviPrekobrojniLjudi($id){
        $sluzbenici = Sluzbenik::where('radno_mjesto', $id)->get();

        return view('ostalo.interno_trziste.prekobrojni', compact('sluzbenici'));

    }


    /****************************************** PRIVREMENI PREMJEŠTAJ *************************************************/

    public function privremeniPremjestaj(){
        $sluzbenici = Sluzbenik::whereNotNull('privremeni_premjestaj');
        $sluzbenici = FilterController::filter($sluzbenici);

        $filteri = [
            'ime_prezime'=>'Ime i prezime službenika',
            'radnoMjesto->naziv_rm'=>'Radno mjesto',
            'privremeniPremjestaj->naziv_rm'=>'Privremeni premještaj',
        ];

        return view('ostalo.interno_trziste.privremeni_premjestaj', compact('sluzbenici', 'filteri'));
    }

}
