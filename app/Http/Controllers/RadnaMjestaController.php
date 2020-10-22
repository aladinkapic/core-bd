<?php

namespace App\Http\Controllers;

use App\Models\RadnoMjestoSluzbenik;
use App\Models\Sluzbenik;
use App\Models\Sifrarnik;
use App\Models\RadnoMjesto;
use App\Models\OrganizacionaJedinica;
use App\Models\Organizacija;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Filter;

class RadnaMjestaController extends Controller{
    public function __construct(){
        $this->middleware('role:radna_mjesta');
    }

    public function svaRadnaMjesta(){
        // Ovdje trebamo samo isfiltrirati radna mjesta u odnosu na organizacionu jedinuc
        //$radna_mjesta = RadnoMjesto::aktivna();

        $radna_mjesta = RadnoMjesto::with('orgjed.organizacija.organ')->with('sluzbenici')->with('rukovodeca_pozicija', 'stepenSS', 'katgorijaa', 'kompetencijeRel');
        $radna_mjesta = FilterController::filter($radna_mjesta);

        $filteri = [
            'naziv_rm' => 'Naziv radnog mjesta',
            'sifra_rm' => 'Šifra radnog mjesta',
            'broj_izvrsilaca' => 'Broj izvršilaca',
            'platni_razred' => 'Platni razred',
            'stepenSS.name' => 'Stepen',
            'katgorijaa.name' => 'Kategorija radnog mjesta',
            'orgjed.naziv' => 'Organizacijska jedinica',
            'orgjed.organizacija.organ.naziv' => 'Organ javne uprave',
            'kompetencijeRel.name' => 'Kompetencije',
            'sluzbenici.ime_prezime' => 'Službenici',
        ];


//        $radna_mjesta = collect();
//        foreach ($ids as $id){
//            $radna_mjesta->push(RadnoMjesto::where('id', $id->id)->with('orgjed')->first());
//        }



        return view('/hr/radna_mjesta/home', compact('radna_mjesta', 'filteri'));
    }

    public function dodajRadnoMjesto($id){
        $sluzbenici = Sluzbenik::select('ime', 'id', 'prezime')->orderBy('ime')->get()->pluck('full_name', 'id' );

        $nadlezni = RadnoMjesto::orderBy('naziv_rm')->get(['id', 'naziv_rm'])->pluck('naziv_rm', 'id' );
        $nadlezni->put('', 'Nema nadležnog');
        $kompetencije = Sifrarnik::dajSifrarnik('strucna_sprema');


//        $sluzbenici = Sluzbenik::select('ime', 'id', 'prezime')->orderBy('ime')->get()->pluck('full_name', 'id' );


        $org_jedinice = OrganizacionaJedinica::with('parent') // Organizaciona jedinica
        ->where('org_id', '=', $id)
            ->orderBy('broj', 'ASC')
            ->get()->pluck('naziv','id');


        return view('/hr/radna_mjesta/dodaj_rm', compact('sluzbenici', 'nadlezni', 'org_jedinice', 'kompetencije'));
    }


    public function spremiRadnoMjesto(Request $request){
        $active = OrganizacionaJedinica::where('id', $request->id_oj)->first()->organizacija->active;
        $validatedData = $request->validate([
            'naziv_rm' => 'required',
            'sifra_rm' => 'required',
            'opis_rm' => 'required',
            'broj_izvrsilaca' => 'required',
            'platni_razred' => 'required',
        ]);

        if($request->rukovodioc == 'on'){
            $request['rukovodioc'] = 1;
        }else{
            $request['rukovodioc'] = 0;
        }

//        dd($request->all());

        try{
            $id = DB::table('radna_mjesta')->insertGetId(
                $request->except(['_token', 'naziv_rm_inp', 'tip_inp', 'xx', 'tekst_uslova_inp', 'vrijednost_inp', 'sluzbenik_id'])
            );

            $request->request->add(['id_rm' => $id]);

            for($i=1; $i<count($request->tekst_uslova_inp); $i++){
                DB::table('radno_mjesto_uslovi')->insert([
                    'id_rm' => $request->id_rm,
//                    'tip' => $request->tip_inp[$i],
                    'tekst_uslova' => $request->tekst_uslova_inp[$i],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            for($i=1; $i<count($request->sluzbenik_id); $i++){
                $sluz = Sluzbenik::find($request->sluzbenik_id[$i]);
                if($active) $sluz->radno_mjesto = $id;
                else $sluz->radno_mjesto_temp  = $id;
                $sluz->save();
            }


            return redirect(route('organizacija.radna-mjesta', ['id' => OrganizacionaJedinica::findOrFail($request->id_oj)->org_id ]));
        }catch(\Exception $e){
            return $e;
        }
    }

    public function pregledajRadnoMjesto($id, $what = null){
        $radno_mjesto = RadnoMjesto::where('id', '=', $id)->first();
        $active = OrganizacionaJedinica::where('id', $radno_mjesto->id_oj)->first()->organizacija->active;

        $sluzbenici = Sluzbenik::select('ime', 'id', 'prezime')->orderBy('ime')->get()->pluck('full_name', 'id' );
        if($active) $odabrani_sluzbenici = Sluzbenik::where('radno_mjesto', '=', $radno_mjesto->id)->get();
        else $odabrani_sluzbenici = Sluzbenik::where('radno_mjesto_temp', '=', $radno_mjesto->id)->get();

        $uslovi              = DB::table('radno_mjesto_uslovi')->where('id_rm', '=', $radno_mjesto->id)->get();
        $organizacija        = Organizacija::find(OrganizacionaJedinica::findOrFail($radno_mjesto->id_oj)->org_id);
        $kateogrija_radnog   = Sifrarnik::dajSifrarnik('kategorija_radnog_mjesta');
        $tip_premjestaja     = Sifrarnik::dajSifrarnik('tip_privremenog_premjestaja');
        $tip_uslova          = Sifrarnik::dajSifrarnik('tip_uslova');
        $kompetencije        = Sifrarnik::dajSifrarnik('strucna_sprema');
        $tip_radnog_mjesta   = Sifrarnik::dajSifrarnik('stepen');
        $benificirani        = Sifrarnik::dajSifrarnik('benificirani')->prepend('Odaberite', '0');

        $org_jedinice = OrganizacionaJedinica::with('parent') // Organizaciona jedinica
        ->where('org_id', '=', $organizacija->id)
            ->orderBy('broj', 'ASC')
            ->get()->pluck('naziv','id');

        return view('/hr/radna_mjesta/dodaj_rm', compact('sluzbenici', 'radno_mjesto', 'tip_uslova', 'tip_premjestaja', 'odabrani_sluzbenici', 'uslovi', 'org_jedinice', 'organizacija', 'kateogrija_radnog', 'what', 'kompetencije', 'tip_radnog_mjesta', 'benificirani'));
    }

    public function pregledajRadnoMjestoooo($id){
        $radno_mjesto = RadnoMjesto::where('id', '=', $id)->first();
        $active = OrganizacionaJedinica::where('id', $radno_mjesto->id_oj)->first()->organizacija->active;

        $sluzbenici = Sluzbenik::select('ime', 'id', 'prezime')->orderBy('ime')->get()->pluck('full_name', 'id' );
        if($active) $odabrani_sluzbenici = Sluzbenik::where('radno_mjesto', '=', $radno_mjesto->id)->get();
        else $odabrani_sluzbenici = Sluzbenik::where('radno_mjesto_temp', '=', $radno_mjesto->id)->get();

        $uslovi              = DB::table('radno_mjesto_uslovi')->where('id_rm', '=', $radno_mjesto->id)->get();
        $organizacija        = Organizacija::find(OrganizacionaJedinica::findOrFail($radno_mjesto->id_oj)->org_id);
        $kateogrija_radnog   = Sifrarnik::dajSifrarnik('kategorija_radnog_mjesta');
        $tip_premjestaja     = Sifrarnik::dajSifrarnik('tip_privremenog_premjestaja');
        $tip_uslova          = Sifrarnik::dajSifrarnik('tip_uslova');
        $kompetencije        = Sifrarnik::dajSifrarnik('strucna_sprema');
        $tip_radnog_mjesta   = Sifrarnik::dajSifrarnik('stepen');


        $org_jedinice = OrganizacionaJedinica::with('parent') // Organizaciona jedinica
        ->where('org_id', '=', $organizacija->id)
            ->orderBy('broj', 'ASC')
            ->get()->pluck('naziv','id');

        return view('/hr/radna_mjesta/samo-pregled', compact('sluzbenici', 'radno_mjesto', 'tip_uslova', 'tip_premjestaja', 'odabrani_sluzbenici', 'uslovi', 'org_jedinice', 'organizacija', 'kateogrija_radnog', 'kompetencije', 'tip_radnog_mjesta'));
    }

    public function azurirajRadnoMjesto(Request $request){
        $active = OrganizacionaJedinica::where('id', $request->id_oj)->first()->organizacija->active;

        if($request->rukovodioc == 'on'){
            $request['rukovodioc'] = 1;
        }else{
            $request['rukovodioc'] = 0;
        }


        $id_rm = $request->id_rm;

        try{

            $id = RadnoMjesto::where('id', '=', $request->id_rm)->update(
                $request->except(['_token', 'naziv_rm_inp', 'tip_inp', 'tekst_uslova_inp', 'xx', 'vrijednost_inp', 'sluzbenik_id', 'id_rm', 'id_uslova', 'id_sluzben'])
            );

            for($i=1; $i<count($request->tekst_uslova_inp); $i++){

                if($request->id_uslova[$i] == 'empty'){
                    DB::table('radno_mjesto_uslovi')->insert([
                        'id_rm' => $request->id_rm,
//                        'tip' => $request->tip_inp[$i],
                        'tekst_uslova' => $request->tekst_uslova_inp[$i],
//                        'vrijednost' => $request->vrijednost_inp[$i],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }else{
                    DB::table('radno_mjesto_uslovi')->where('id', '=', $request->id_uslova[$i])->update([
//                        'tip' => $request->tip_inp[$i],
                        'tekst_uslova' => $request->tekst_uslova_inp[$i],
                        'vrijednost' => $request->vrijednost_inp[$i],
                        'updated_at' => Carbon::now()
                    ]);
                }
            }

//            for($i=1; $i<count($request->sluzbenik_id); $i++){
//                if($request->id_sluzben[$i] == 'empty'){
//                    // Ako je novi službenik na radnom mjestu, onda ga unosimo.
//                    try{
//                        $rel = RadnoMjestoSluzbenik::where('sluzbenik_id', $request->sluzbenik_id[$i])->where('radno_mjesto_id', $request->id_rm)->firstOrFail();
//                    }catch (\Exception $e){
//                        try{
//                            $rel = RadnoMjestoSluzbenik::create([
//                                'sluzbenik_id'    => $request->sluzbenik_id[$i],
//                                'radno_mjesto_id' => $request->id_rm
//                            ]);
//                        }catch (\Exception $e){}
//                    }
//
//                    $sluz = Sluzbenik::find($request->sluzbenik_id[$i]);
//
//                    if($active){
//                        // Obrišimo službenika sa stare aktivne sistematizacije
//                        try{
//                            $rms = RadnoMjestoSluzbenik::where('sluzbenik_id', $sluz->id)->where('radno_mjesto_id', $sluz->radno_mjesto)->delete();
//                        }catch (\Exception $e){}
//
//                        // Ako je sistematizacija aktivna, onda provjeravamo da li ima uzorak prvo, ako nema
//                        // unesemo ga, a ako ima onda ga ažuriramo
//
//                        $sluz->radno_mjesto = $id_rm;
//                    }
//                    else{
//                        $sluz->radno_mjesto_temp  = $request->id_rm;
//                    }
//                    $sluz->save();
//                }else{
//                    // Ovdje ne radimo ništa ! Nije moguće
//                }
//            }

            return back();

            return redirect(route('organizacija.radna-mjesta', ['id' => OrganizacionaJedinica::findOrFail($request->id_oj)->org_id ]));
        }catch(\Exception $e){}
    }

    public function urediRadnoMjesto($id){
        $radno_mjesto = RadnoMjesto::where('id', '=', $id)->first();
        $active = OrganizacionaJedinica::where('id', $radno_mjesto->id_oj)->first()->organizacija->active;

        $sluzbenici = Sluzbenik::select('ime', 'id', 'prezime')->orderBy('ime')->get()->pluck('full_name', 'id' );
        if($active) $odabrani_sluzbenici = Sluzbenik::where('radno_mjesto', '=', $radno_mjesto->id)->get();
        else $odabrani_sluzbenici = Sluzbenik::where('radno_mjesto_temp', '=', $radno_mjesto->id)->get();

        $uposleni = RadnoMjesto::where('id', $id)->with('sluzbeniciRel.sluzbenik')->get();


        $uslovi              = DB::table('radno_mjesto_uslovi')->where('id_rm', '=', $radno_mjesto->id)->get();
        $kateogrija_radnog   = Sifrarnik::dajSifrarnik('kategorija_radnog_mjesta');
        $tip_premjestaja     = Sifrarnik::dajSifrarnik('tip_privremenog_premjestaja');
        $tip_uslova          = Sifrarnik::dajSifrarnik('tip_uslova');
        $kompetencije        = Sifrarnik::dajSifrarnik('strucna_sprema');
        $tip_radnog_mjesta   = Sifrarnik::dajSifrarnik('stepen');
        $benificirani        = Sifrarnik::dajSifrarnik('benificirani')->prepend('Odaberite', '0');


        $organizacija        = Organizacija::find(OrganizacionaJedinica::findOrFail($radno_mjesto->id_oj)->org_id);

        $org_jedinice = OrganizacionaJedinica::with('parent') // Organizaciona jedinica
        ->where('org_id', '=', $organizacija->id)
            ->orderBy('broj', 'ASC')
            ->get()->pluck('naziv','id');


        return view('/hr/radna_mjesta/uredi_rm', compact('sluzbenici', 'tip_premjestaja', 'tip_uslova', 'radno_mjesto', 'odabrani_sluzbenici', 'uslovi', 'org_jedinice', 'organizacija', 'kateogrija_radnog', 'kompetencije', 'tip_radnog_mjesta', 'uposleni', 'benificirani'));
    }

    public function obrisiSaRadnogMjesta($rm, $sluz){
        try{
            $rel = RadnoMjestoSluzbenik::where('sluzbenik_id', $sluz)->where('radno_mjesto_id', $rm)->delete();
        }catch (\Exception $e){}
        return back();
    }

    public function obrisiRMsaSluzbenicima($id){
        try{
            $rel = RadnoMjestoSluzbenik::where('radno_mjesto_id', $id)->delete();

            $rm = RadnoMjesto::where('id', $id)->delete();
        }catch (\Exception $e){}

        return back();
    }
}
