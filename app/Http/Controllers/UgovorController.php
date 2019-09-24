<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RadniStatus;
USE App\Models\Sluzbenik;
USE App\Models\MjestoRada;
use App\Models\Privremeno;
use App\Models\Prestanak;
use App\Models\Dodatno;

class UgovorController extends Controller{

    public function __construct(){
        $this->middleware('role:regitar_ugovora');
    }
    /*
     * Raspored na radno mjesto
     */

    public function index(Request $request){
        $ugovori = RadniStatus::with('usluzbenik')->get()->toJson();

        return view('hr.ugovori.index')->with(compact('ugovori'));
    }

    public function createRadniStatus(Request $request){

        $sluzbenici = Sluzbenik::select(['id', 'ime', 'prezime'])->get();

        return view('hr.ugovori.radni_status.create')->with(compact('sluzbenici'));
    }

    public function storeRadniStatus(Request $request){

        $data = $request->all();

        $pravila = [
            'broj' => 'required|max:255',
            'sluzbenik' => 'required',
            'datum' => 'required|date',
            'broj_sati' => 'required',
        ];

        $poruke = HelpController::getValidationMessages();
        $this->validate($request, $pravila, $poruke);


        $object = new RadniStatus();

        $object->broj = $data['broj'];
        $object->sluzbenik = $data['sluzbenik'];
        $object->datum = Carbon::parse($data['datum']);
        $object->datum_isteka = Carbon::parse($data['datum_isteka']);
        $object->datum_isteka_probni = Carbon::parse($data['datum_isteka_probni']);
        $object->broj_sati = $data['broj_sati'];

        $object->save();

        return redirect(route('ugovor.index'))->with(['success' => 'Izmjene su uspješno spašene!']);
    }

    public function editRadniStatus(Request $request, $id){

        $sluzbenici = Sluzbenik::select(['id', 'ime', 'prezime'])->get();
        $ugovor = RadniStatus::findOrFail($id);

        return view('hr.ugovori.radni_status.edit')->with(compact('ugovor', 'sluzbenici'));

    }

    public function updateRadniStatus(Request $request, $id){

        $data = $request->all();

        $pravila = [
            'broj' => 'required|max:255',
            'sluzbenik' => 'required',
            'datum' => 'required|date',
            'broj_sati' => 'required',
        ];

        $poruke = HelpController::getValidationMessages();
        $this->validate($request, $pravila, $poruke);


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

        $ugovori = MjestoRada::with('usluzbenik')->get();

        return view('hr.ugovori.mjesto_rada.index')->with(compact('ugovori'));
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

        $ugovori = Privremeno::with('usluzbenik')->get();

        return view('hr.ugovori.privremeno.index')->with(compact('ugovori'));
    }

    public function createPrivremeno(Request $request){

        $sluzbenici = Sluzbenik::select(['id', 'ime', 'prezime'])->get();

        return view('hr.ugovori.privremeno.create')->with(compact('sluzbenici'));
    }


    public function radnaMjesta(Request $request){

        $radnaMjesta = ''; // Definišimo praznu varijablu radna mjesta
        $organ_ju = Sluzbenik::organJavneUprave($request->id);
        if(count($organ_ju)){
            $radnaMjesta = Sluzbenik::radnaMjesta($organ_ju[0]->id);
        }

        return array('radnaMjesta' => $radnaMjesta, 'naziv_radnog_mjesta' => (Sluzbenik::where('id', $request->id)->first()->radnoMjesto) ? Sluzbenik::where('id', $request->id)->first()->radnoMjesto->naziv_rm : '');
    }


    public function storePrivremeno(Request $request){
        $request = HelpController::formatirajRequest($request);
        $data = $request->all();

        $sluzbenik = Sluzbenik::where('id', '=', $data['sluzbenik']);
        
//        foreach($data as $key => $value){
//            if(strtotime($value)){
//                $data[$key] = Carbon::parse($value);
//            }
//        }

        $request->merge(['radno_mjesto' => $sluzbenik->first()->radnoMjesto->id]);

        $object = new Privremeno();
        $object->fill($request->except(['_token', '_method']));
        $object->save();


        $sluzbenik->update(['privremeni_premjestaj' => $data['privremeno_radno_mjesto']]);

        return redirect(route('ugovor.privremeno.index'))->with(['success' => 'Izmjene su uspješno spašene!']);

    }

    public function editPrivremeno(Request $request, $id){

//        $sluzbenici = Sluzbenik::with('radnoMjesto.orgjed.organizacija')->where('id', '=', 1)->get();


        $sluzbenici = Sluzbenik::select(['id', 'ime', 'prezime'])->get();

        $ugovor = Privremeno::find($id)->first();
        $sluzbenik  = Sluzbenik::where('id', $ugovor->sluzbenik)->first();

        $radnaMjesta = ''; // Definišimo praznu varijablu radna mjesta
        $organ_ju = Sluzbenik::organJavneUprave($sluzbenik->id);
        if(count($organ_ju)){
            $radnaMjesta = Sluzbenik::radnaMjesta($organ_ju[0]->id);
        }

        return view('hr.ugovori.privremeno.edit')->with(compact('sluzbenici', 'ugovor', 'sluzbenik', 'radnaMjesta'));
    }
    public function updatePrivremeno(Request $request, $id){
        $request = HelpController::formatirajRequest($request);
        $data = $request->all();

        $sluzbenik = Sluzbenik::where('id', '=', $data['sluzbenik']);

//        foreach($data as $key => $value){
//            if(strtotime($value)){
//                $data[$key] = Carbon::parse($value);
//            }
//        }

        $request->merge(['radno_mjesto' => $sluzbenik->first()->radnoMjesto->id]);

        $object = Privremeno::find($id);
        $object->fill($request->except(['_token', '_method']));
        $object->save();


        $sluzbenik->update(['privremeni_premjestaj' => $data['privremeno_radno_mjesto']]);
        return redirect(route('ugovor.privremeno.index'))->with(['success' => 'Izmjene su uspješno spašene!']);

    }


    /*
     * Prestanak radnog odnosa
     *
     */


    public function indexPrestanak(Request $request){

        $ugovori = Prestanak::with('usluzbenik')->get();

        return view('hr.ugovori.prestanak.index')->with(compact('ugovori'));
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

        $ugovori = Dodatno::with('usluzbenik')->get();

        return view('hr.ugovori.dodatno.index')->with(compact('ugovori'));
    }

    public function createDodatno(Request $request){

        $sluzbenici = Sluzbenik::select(['id', 'ime', 'prezime'])->get();

        return view('hr.ugovori.dodatno.create')->with(compact('sluzbenici'));
    }
    public function storeDodatno(Request $request){

        $data = $request->except(['_token', '_method']);

        foreach($data as $key => $value){
            if(strtotime($value)){
                $data[$key] = Carbon::parse($value);
            }
        }

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

        $data = $request->except(['_token', '_method']);

        foreach($data as $key => $value){
            if(strtotime($value)){
                $data[$key] = Carbon::parse($value);
            }
        }

        $object = Dodatno::find($id);
        $object->fill($data);
        $object->save();

        return redirect(route('ugovor.dodatno.index'))->with(['success' => 'Izmjene su uspješno spašene!']);

    }
}
