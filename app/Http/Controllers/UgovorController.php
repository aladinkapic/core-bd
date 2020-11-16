<?php

namespace App\Http\Controllers;

use App\Models\Organ;
use App\Models\Organizacija;
use App\Models\RadnoMjesto;
use App\Models\RadnoMjestoSluzbenik;
use App\Models\registarUgovora\PrestanakRadnogOdnosa;
use App\Models\Sifrarnik;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RadniStatus;
USE App\Models\Sluzbenik;
USE App\Models\MjestoRada;
use App\Models\Privremeno;
use App\Models\Prestanak;
use App\Models\Dodatno;
use Illuminate\Support\Facades\DB;

class UgovorController extends Controller{

    public function __construct(){
        $this->middleware('role:regitar_ugovora');
    }
    /*
     * Raspored na radno mjesto
     */

    public function index(Request $request){
        $ugovori = RadniStatus::with('usluzbenik.sluzbenikRel.rm.orgjed.organizacija.organ');


        $ugovori = FilterController::filter($ugovori);

        $filteri = [
            'broj'=>'Broj ugovora/odluke',
            'usluzbenik.ime_prezime'=>'Službenik',
            'usluzbenik.sluzbenikRel.rm.naziv_rm' => 'Trenutno radno mjesto',
            'usluzbenik.sluzbenikRel.rm.orgjed.organizacija.organ.naziv' => 'Organ',
            'radnoMjesto.naziv_rm' => 'Radno mjesto na koje je postavljen',
            'datum'=>'Datum ugovora/odluke',
            'datum_isteka'=>'Datum isteka ugovora/odluke',
            'datum_isteka_probni'=>'Datum isteka probnog perioda',
            'broj_sati'=>'Broj sati',
        ];
        return view('hr.ugovori.index')->with(compact('ugovori', 'filteri'));
    }

    public function createRadniStatus(Request $request){

        $sluzbenici = Sluzbenik::select(['id', 'ime', 'prezime'])->get();
        $organi     = Organ::pluck('naziv', 'id')->prepend('Odaberite organ', '');
        $radno_v    = Sifrarnik::dajSifrarnik('radno_vrijeme')->prepend('Odaberite radno vrijeme', '');

        return view('hr.ugovori.radni_status.create')->with(compact('sluzbenici', 'organi', 'radno_v'));
    }

    public function storeRadniStatus(Request $request){
        $request = HelpController::formatirajRequest($request);

        try{

            $organizacija = Organizacija::where('id', $request->organizacioni_plan)->first();

            if($organizacija->active == 1){ // Ako postavljamo u aktivnu sistematizaciju
                $rms = RadnoMjestoSluzbenik::where('sluzbenik_id', $request->sluzbenik)->get();

                foreach ($rms as $r) $r->update(['active' => null]); // Inaktiviraj na svim ostalima prvo

                // Obriši ako se nalazi u nekoj od aktivnih sistematizacija
                $rm_s = RadnoMjestoSluzbenik::where('sluzbenik_id', $request->sluzbenik)->get();
                foreach($rm_s as $rm){
                    $radno_mjesto = RadnoMjesto::where('id', $rm->radno_mjesto_id)->with('orgjed.organizacija')->first();
                    if(isset($radno_mjesto->orgjed->organizacija) and $radno_mjesto->orgjed->organizacija->active == 1){
                        $rm->delete();
                    }
                }

                // Postavi na radno mjesto
                $rm = RadnoMjestoSluzbenik::create([
                    'sluzbenik_id' => $request->sluzbenik,
                    'radno_mjesto_id' => $request->radno_mjesto,
                    'active' => 1
                ]);

            }else{
                $rm_s = RadnoMjestoSluzbenik::where('sluzbenik_id', $request->sluzbenik)->get();
                foreach($rm_s as $rm){
                    $radno_mjesto = RadnoMjesto::where('id', $rm->radno_mjesto_id)->with('orgjed.organizacija')->first();


                    if(isset($radno_mjesto->orgjed->organizacija)){
                        if($radno_mjesto->orgjed->organizacija->id == $organizacija->id) $rm->delete();
                    }
                }

                // Postavi na radno mjesto
                $rm = RadnoMjestoSluzbenik::create([
                    'sluzbenik_id' => $request->sluzbenik,
                    'radno_mjesto_id' => $request->radno_mjesto
                ]);
            }

            $rs = RadniStatus::create(
                $request->except(['_token', '_method', 'organizacioni_plan'])
            );

        }catch (\Exception $e){dd($e);}

        return redirect(route('ugovor.index'))->with(['success' => 'Izmjene su uspješno spašene!']);
    }

    public function editRadniStatus(Request $request, $id){

        $sluzbenici = Sluzbenik::select(['id', 'ime', 'prezime'])->get();
        $ugovor = RadniStatus::findOrFail($id);
        $organi     = Organ::pluck('naziv', 'id')->prepend('Odaberite organ', '');
        $radno_v    = Sifrarnik::dajSifrarnik('radno_vrijeme')->prepend('Odaberite radno vrijeme', '');

        $organ_id = $ugovor->organ;

        $radnaMjesta = RadnoMjesto::whereHas('orgjed.organizacija.organ', function ($query) use ($organ_id){
            $query->where('id', $organ_id);
        })->whereHas('orgjed.organizacija', function ($query){
            $query->where('active', 1);
        })->get()->pluck('naziv_rm', 'id');

        $e_slu = Sluzbenik::where('id', $ugovor->sluzbenik)->first();
        $e_rm  = RadnoMjesto::where('id', $ugovor->radno_mjesto)->first();
        $e_org = Organ::where('id', $ugovor->organ)->first();

        return view('hr.ugovori.radni_status.edit')->with(compact('ugovor', 'sluzbenici', 'organi', 'radno_v', 'radnaMjesta', 'e_slu', 'e_rm', 'e_org'));

    }

    public function updateRadniStatus(Request $request, $id){

        $request = HelpController::formatirajRequest($request);
        try{
            $rs = RadniStatus::where('id', $id)->update([
                'broj' => $request->broj,
                'datum' => $request->datum,
                'datum_isteka' => $request->datum_isteka,
                'datum_isteka_probni' => $request->datum_isteka_probni,
                'broj_sati' => $request->broj_sati,
                'datum_pocetka_rada' => $request->datum_pocetka_rada
            ]);
        }catch (\Exception $e){}

        return back();

        dd($request->all());
        $object = RadniStatus::find($id);

        $object->broj = $data['broj'];
        $object->sluzbenik = $data['sluzbenik'];
        $object->datum = Carbon::parse($data['datum']);
        $object->datum_isteka = Carbon::parse($data['datum_isteka']);
        $object->datum_isteka_probni = Carbon::parse($data['datum_isteka_probni']);
        $object->broj_sati = $data['broj_sati'];

        $object->save();

        return redirect(route('ugovor.index'))->with(['success' => 'Izmjene su uspješno spašene!']);
    }



    /*
     * Mjesto rada državnog službenika
     */

    public function indexMjestoRada(Request $request){

        $ugovori = MjestoRada::with('usluzbenik')->with('sluzbeno_autoq')->with('rm');
        $ugovori = FilterController::filter($ugovori);

        $filteri = [
            'usluzbenik.ime_prezime'=>'Službenik',
            'adresa'=>'Adresa',
            'sprat'=>'Sprat',
            'broj_kancelarije'=>'Broj kancelarije',
            'sluzbeno_autoq.name'=>'Službeno auto na raspolaganju',
            'povjerena_stalna_sredstva'=>'Povjerena stalna sredstva',
            'rm.naziv_rm'=>'Radno mjesto',
        ];

        return view('hr.ugovori.mjesto_rada.index')->with(compact('ugovori', 'filteri'));
    }

    public function createMjestoRada(Request $request){

        $sluzbenici = Sluzbenik::select(['id', 'ime', 'prezime'])->get();

        return view('hr.ugovori.mjesto_rada.create')->with(compact('sluzbenici'));
    }
    public function storeMjestoRada(Request $request){

        $data = $request->except(['_token', '_method']);

        $object = new MjestoRada();
        if(!$request->has('sluzbeno_auto')){
            $object->sluzbeno_auto = 0;
        }
        $object->fill($data);
        $object->save();

        return redirect(route('ugovor.mjesto_rada.index'))->with(['success' => 'Izmjene su uspješno spašene!']);

    }

    public function editMjestoRada(Request $request, $id){

        $sluzbenici = Sluzbenik::select(['id', 'ime', 'prezime'])->get();

        $ugovor = MjestoRada::find($id);

        return view('hr.ugovori.mjesto_rada.edit')->with(compact('sluzbenici', 'ugovor'));
    }
    public function updateMjestoRada(Request $request, $id){



        $data = $request->except(['_token', '_method']);

        $object = MjestoRada::find($id);
        if(!$request->has('sluzbeno_auto')){
            $object->sluzbeno_auto = 0;
        }
        $object->fill($data);
        $object->save();

        return redirect(route('ugovor.mjesto_rada.index'))->with(['success' => 'Izmjene su uspješno spašene!']);

    }


    /*
     * Privremeno raspoređivanje
     *
     */


    public function indexPrivremeno(Request $request){

        $ugovori = Privremeno::with('usluzbenik')->with('mjesto')->with('privremeno_mjesto');
        $ugovori = FilterController::filter($ugovori);

        $filteri = [
            'usluzbenik.ime_prezime'=>'Službenik',
            'mjesto.naziv_rm'=>'Redovno radno mjesto',
            'privremeno_mjesto.naziv_rm'=>'Privremeno radno mjesto',
            'broj_rjesenja'=>'Broj rješenja',
            'datum_rjesenja'=>'Datum rješenja',
            'datum_od'=>'Datum od',
            'datum_do'=>'Datum do',
        ];

        return view('hr.ugovori.privremeno.index')->with(compact('ugovori', 'filteri'));
    }

    public function createPrivremeno(Request $request){
        $sluzbenici = Sluzbenik::select(['id', 'ime', 'prezime'])->get();
        $organi     = Organ::pluck('naziv', 'id');

        return view('hr.ugovori.privremeno.create')->with(compact('sluzbenici', 'organi'));
    }


    public function radnaMjesta(Request $request){

        $radnaMjesta = ''; // Definišimo praznu varijablu radna mjesta

        // Prijašnji princip je biranje radnih mesta u zavisnosti od organa kojem pripada
        /* $organ_ju = Sluzbenik::organJavneUprave($request->id);
        if(count($organ_ju)){
            $radnaMjesta = Sluzbenik::radnaMjesta($organ_ju[0]->id);
        } */

        // Sada žele da se na privremeni premještaj može ubaciti bilo koje radno mjesto -- ovo treba dobro pogledati : )

        $radnaMjesta = DB::table('radna_mjesta')
            ->select(['radna_mjesta.id', 'radna_mjesta.naziv_rm'])->get();
        return array('radnaMjesta' => $radnaMjesta, 'naziv_radnog_mjesta' => (Sluzbenik::where('id', $request->id)->first()->radnoMjesto) ? Sluzbenik::where('id', $request->id)->first()->radnoMjesto->naziv_rm : '', 'rm_id' => (Sluzbenik::where('id', $request->id)->first()->radnoMjesto) ? Sluzbenik::where('id', $request->id)->first()->radnoMjesto->id : '');
    }


    public function storePrivremeno(Request $request){
        $request = HelpController::formatirajRequest($request);
        $data = $request->all();

        $sluzbenik = Sluzbenik::where('id', '=', $data['sluzbenik'])->first();
        try{
            $privremeno = Privremeno::create(
                $request->except(['_token', '_method', 'radno_mjesto_naziv'])
            );

            $sluzbenik->privremeni_premjestaj = $privremeno->id;
            $sluzbenik->save();
        }catch (\Exception $e){dd($e);}

        return redirect(route('ugovor.privremeno.index'))->with(['success' => 'Izmjene su uspješno spašene!']);

    }

    public function editPrivremeno(Request $request, $id){
        $sluzbenici = Sluzbenik::select(['id', 'ime', 'prezime'])->get();

        $ugovor = Privremeno::where('id', $id)->first();
        $sluzbenik  = Sluzbenik::where('id', $ugovor->sluzbenik)->first();

        $organ_id   = $ugovor->organ;

        $radnaMjesta = RadnoMjesto::whereHas('orgjed.organizacija.organ', function ($query) use ($organ_id){
            $query->where('id', $organ_id);
        })->whereHas('orgjed.organizacija', function ($query){
            $query->where('active', 1);
        })->get()->pluck('naziv_rm', 'id');

        $organi     = Organ::pluck('naziv', 'id');

        return view('hr.ugovori.privremeno.edit')->with(compact('sluzbenici', 'ugovor', 'sluzbenik', 'radnaMjesta', 'organi'));
    }
    public function updatePrivremeno(Request $request, $id){
        $request = HelpController::formatirajRequest($request);
        $data = $request->all();
        $sluzbenik = Sluzbenik::where('id', '=', $data['sluzbenik'])->first();

        try{
            $privremeno = Privremeno::where('id', $id)->update(
                $request->except(['_token', '_method', 'radno_mjesto'])
            );
            $sluzbenik->privremeni_premjestaj = $privremeno->id;
        }catch (\Exception $e){}
        return redirect(route('ugovor.privremeno.index'))->with(['success' => 'Izmjene su uspješno spašene!']);

    }


    /*
     * Prestanak radnog odnosa
     *
     */


    public function indexPrestanak(Request $request){

        $ugovori = Prestanak::with('usluzbenik')->with('radno_mj');
        $ugovori = FilterController::filter($ugovori);

        $filteri = [
            'usluzbenik.ime_prezime'=>'Službenik',
            'radno_mj.naziv_mjesta'=>'Radno mjesto',
            'razlog'=>'Razlog',
            'rjesenje'=>'Broj rješenja',
            'datum_rjesenja'=>'Datum rješenja',
        ];
        return view('hr.ugovori.prestanak.index')->with(compact('ugovori', 'filteri'));
    }

    public function createPrestanak(Request $request){

        $sluzbenici = Sluzbenik::select(['id', 'ime', 'prezime'])->get();

        return view('hr.ugovori.prestanak.create')->with(compact('sluzbenici'));
    }
    public function storePrestanak(Request $request){

        $data = $request->except(['_token', '_method']);

        foreach($data as $key => $value){
            if(strtotime($value)){
                $data[$key] = Carbon::parse($value);
            }
        }

        $object = new Prestanak();
        $object->fill($data);
        $object->save();

        return redirect(route('ugovor.prestanak.index'))->with(['success' => 'Izmjene su uspješno spašene!']);

    }

    public function editPrestanak(Request $request, $id){

        $sluzbenici = Sluzbenik::select(['id', 'ime', 'prezime'])->get();

        $ugovor = Prestanak::find($id);

        return view('hr.ugovori.prestanak.edit')->with(compact('sluzbenici', 'ugovor'));
    }
    public function updatePrestanak(Request $request, $id){

        $data = $request->except(['_token', '_method']);

        foreach($data as $key => $value){
            if(strtotime($value)){
                $data[$key] = Carbon::parse($value);
            }
        }

        $object = Prestanak::find($id);
        $object->fill($data);
        $object->save();

        return redirect(route('ugovor.prestanak.index'))->with(['success' => 'Izmjene su uspješno spašene!']);

    }



    /*
     * Evidencija o dodatnim djelatnostima
     *
     */


    public function indexDodatno(Request $request){

        $ugovori = Dodatno::with('usluzbenik');
        $ugovori = FilterController::filter($ugovori);

        $filteri = [
            'usluzbenik.ime_prezime'=>'Službenik',
            'razlog'=>'Razlog',
            'rjesenje'=>'Rješenje',
            'datum_rjesenja'=>'Datum rješenja',
        ];

        return view('hr.ugovori.dodatno.index')->with(compact('ugovori', 'filteri'));
    }

    public function createDodatno(){

        $sluzbenici = Sluzbenik::select(['id', 'ime', 'prezime'])->get();

        return view('hr.ugovori.dodatno.create')->with(compact('sluzbenici'));
    }
    public function storeDodatno(Request $request){
        $request=HelpController::formatirajRequest($request);
        $data = $request->except(['_token', '_method','radno_mjesto']);

        $object = new Dodatno();
        $object->fill($data);
        $object->save();

        return redirect(route('ugovor.dodatno.index'))->with(['success' => 'Izmjene su uspješno spašene!']);

    }

    public function editDodatno(Request $request, $id){

        $sluzbenici = Sluzbenik::select(['id', 'ime', 'prezime'])->get();

        $ugovor = Dodatno::find($id);

        return view('hr.ugovori.dodatno.edit')->with(compact('sluzbenici', 'ugovor'));
    }
    public function updateDodatno(Request $request, $id){

        $data = $request->except(['_token', '_method','radno_mjesto']);


        $object = Dodatno::find($id);
        $object->fill($data);
        $object->save();

        return redirect(route('ugovor.dodatno.index'))->with(['success' => 'Izmjene su uspješno spašene!']);
    }

    public function destroyDodatno($id){
        $org_jed = Dodatno::find($id);

        $org_jed->delete();

        return redirect(route('ugovor.dodatno.index'))->with(['success' => 'Uspješno izbrisano!']);
    }

    public function destroyPrestanak($id){
        $org_jed = Prestanak::find($id);

        $org_jed->delete();

        return redirect(route('ugovor.prestanak.index'))->with(['success' => 'Uspješno izbrisano!']);
    }

    public function destroyPrivremeno($id){
        try{
            $privremeno = Privremeno::find($id);

            $sluzbenik = Sluzbenik::where('id', $privremeno->sluzbenik)->firstOrFail();

            // TODO - Razmisliti malo o ovome !!!
            // $sluzbenik->privremeni_premjestaj = null;
            // $sluzbenik->save();

            $privremeno->delete();
        }catch (\Exception $e){}

        return redirect(route('ugovor.privremeno.index'))->with(['success' => 'Uspješno izbrisano!']);
    }

    public function destroyMjestoRada($id){
        $org_jed = MjestoRada::find($id);

        $org_jed->delete();

        return redirect(route('ugovor.mjesto_rada.index'))->with(['success' => 'Uspješno izbrisano!']);
    }

    public function destroyRadniStatus($id){
        $org_jed = RadniStatus::find($id);

        $org_jed->delete();

        return redirect(route('ugovor.index'))->with(['success' => 'Uspješno izbrisano!']);
    }
}
