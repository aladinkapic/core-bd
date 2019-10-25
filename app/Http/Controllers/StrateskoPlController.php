<?php

namespace App\Http\Controllers;

use App\Models\Uprava;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RadnoMjesto;
use App\Models\StrateskoPlaniranje;

class StrateskoPlController extends Controller{

    public function __construct(){
        $this->middleware('role:stratesko_pl');
    }

    public function pregled(){
//        $plan = StrateskoPlaniranje::find(9)->organJU->naziv;


        $strat_plan = StrateskoPlaniranje::query();
        //dd($strat_plan);
        $strat_plan = FilterController::filter($strat_plan);

        $filteri = [
            "id_rm" => "Radno mjesto",
        "id_oju" => "Organizaciona jedinica",
        "datum_broj" => "Datum i broj akta",
        "pb_neodredjeno" => "Postojeći broj na neodređeno",
        "Postojeći broj na određeno" => "12",
        "pb_prekobrojnih" => "12",
        "pb_godina" => "12",
        "pot_b_neodredjeno" => "12",
        "pot_b_odredjeno" => "12",
        "pot_b_godina" => "123",
        "naziv" => "Naziv",
        "br_plan_godina" => "46",
        "id_sluzbenika" => "SluŽbenik",
            ];

        $radna_mjesta = RadnoMjesto::select('naziv_rm', 'id')->orderBy('naziv_rm')->get()->pluck('naziv_rm', 'id');
        $organ_ju     = Uprava::select('naziv', 'id')->orderBy('naziv')->get()->pluck('naziv', 'id' );

        return view('ostalo.stratesko_planiranje.pregled', compact('strat_plan', 'radna_mjesta'));
    }

    public function pregledSP($id){ // Pregled samo jednog plana
        $sp = StrateskoPlaniranje::find($id);
        $radna_mjesta = RadnoMjesto::select('naziv_rm', 'id')->orderBy('naziv_rm')->get()->pluck('naziv_rm', 'id' );
        $organ_ju     = Uprava::select('naziv', 'id')->orderBy('naziv')->get()->pluck('naziv', 'id' );


        return view('ostalo.stratesko_planiranje.unos', compact('radna_mjesta', 'sp', 'id', 'organ_ju'));
    }

    public function unos(){
        $radna_mjesta = RadnoMjesto::select('naziv_rm', 'id')->orderBy('naziv_rm')->get()->pluck('naziv_rm', 'id' );
        $organ_ju     = Uprava::select('naziv', 'id')->orderBy('naziv')->get()->pluck('naziv', 'id' );

        return view('ostalo.stratesko_planiranje.unos', compact('radna_mjesta', 'organ_ju'));
    }

    public function spremiSP(Request $request){

        $validatedData = $request->validate([
            'datum_broj' => 'required|max:50',
            'pb_neodredjeno' => 'required',
            'pb_odredjeno' => 'required',
            'pb_prekobrojnih' => 'required',
            'pb_godina' => 'required',
            'pot_b_neodredjeno' => 'required',
            'pot_b_odredjeno' => 'required',
            'pot_b_godina' => 'required',
        ]);

        $request->request->add([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        try{
            StrateskoPlaniranje::insert(
                $request->except(['_token', 'id'])
            );

            return redirect(route('pregled.strateskogplaniranja'));
        }catch(\Exception $e){

        }
    }

    public function urediSP($id){
        $sp = StrateskoPlaniranje::find($id);
        $radna_mjesta = RadnoMjesto::select('naziv_rm', 'id')->orderBy('naziv_rm')->get()->pluck('naziv_rm', 'id' );
        $organ_ju     = Uprava::select('naziv', 'id')->orderBy('naziv')->get()->pluck('naziv', 'id' );

        return view('ostalo.stratesko_planiranje.unos', compact('radna_mjesta', 'sp', 'organ_ju'));
    }

    public function azurirajSp(Request $request){
        $validatedData = $request->validate([
            'datum_broj' => 'required|max:50',
            'pb_neodredjeno' => 'required',
            'pb_odredjeno' => 'required',
            'pb_prekobrojnih' => 'required',
            'pb_godina' => 'required',
            'pot_b_neodredjeno' => 'required',
            'pot_b_odredjeno' => 'required',
            'pot_b_godina' => 'required',
        ]);


        $request->request->add([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        try{
            StrateskoPlaniranje::where('id', '=', $request->id)->update(
                $request->except(['_token', 'id'])
            );

            return redirect(route('pregled.strateskogplaniranja'));
        }catch(\Exception $e){
            dd($e);
        }
    }

}
