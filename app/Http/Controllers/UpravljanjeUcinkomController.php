<?php

namespace App\Http\Controllers;

use App\Models\Organizacija;
use App\Models\OrganizacionaJedinica;
use App\Models\RadnoMjesto;
use App\Models\Sluzbenik;
use App\Models\UpravljanjeUcinkom;
use Illuminate\Http\Request;
use App\Models\Sifrarnik;

class UpravljanjeUcinkomController extends Controller{
    public function index(){
        $ucinci = UpravljanjeUcinkom::with('usluzbenik')->with('mjesto.rm')->with('kategorija_ocjene');
        $ucinci = FilterController::filter($ucinci);

        $filteri = [
            'usluzbenik.ime_prezime'=>'Službenik',
            'mjesto.rm.naziv_rm'=>'Radno mjesto',
            'kategorija_ocjene.name'=>'Kategorija',
            'godina'=>'Godina ocjenjivanja',
            'ocjena'=>'Ocjena',
            'opisna_ocjena'=>'Opisna ocjena'
        ];


        return view('/hr/upravljanje_ucinkom/home', compact('ucinci', 'filteri'));
    }

    public function create(){
        $sluzbenici = Sluzbenik::all('id', 'ime', 'prezime');
        $niz_sluzbenika = array();
        foreach ($sluzbenici as $sluzbenik) {
            $niz_sluzbenika[$sluzbenik['id']] = $sluzbenik['ime'] . ' ' . $sluzbenik['prezime'];
        }


        $radna_mjesta = RadnoMjesto::select(['id', 'naziv_rm'])->get();
        $kategorija = Sifrarnik::dajSifrarnik('kategorija_ocjene');


        return view('hr/upravljanje_ucinkom/add', compact('niz_sluzbenika', 'radna_mjesta', 'kategorija'));
    }

    public function storeUcinci(Request $request){
        $pravila = [
            'sluzbenik' => 'required',
            'godina' => 'required|min:4|max:4',
            'ocjena' => 'required',
            'opisna_ocjena' => 'required|max:255',
            'kategorija' => 'required'
        ];
        $poruke = HelpController::getValidationMessages();
        $this->validate($request, $pravila, $poruke);

        $exists = UpravljanjeUcinkom::where('sluzbenik', '=', $request->sluzbenik)->where('godina', '=', $request->godina)->where('kategorija', '=', $request->kategorija)->first();
        if ($exists) {
            return redirect('/hr/upravljanje_ucinkom/add')->with('error', __('Službenik je prethodno ocjenjen sa ovim podacima!'));
        }
        else {
            try {
                $ucinak = UpravljanjeUcinkom::create($request->except(['_method']));
            } catch (\Exception $e) {
                return $e->getMessage();
            }

            return redirect('/hr/upravljanje_ucinkom/home')->with('success', __('Uspješno ste izvršili ocjenjivanje državnog službenika!'));
        }
    }

    public function show($id){
        $ucinak = UpravljanjeUcinkom::where('id', '=', $id)->first();

        $radnoMjesto = 'Nema radnog mjesta';
        $sluzbnik = Sluzbenik::where('id', '=', $ucinak->sluzbenik)->first();

        if ($sluzbnik->radnoMjesto) {
            $radnoMjesto = $sluzbnik->radnoMjesto->naziv_rm;
        }

        $sluzbenik = Sluzbenik::where('id', '=', $ucinak->sluzbenik)->first();
        $sluzbenik = $sluzbenik['ime'] . ' ' . $sluzbenik['prezime'];


        return view('/hr/upravljanje_ucinkom/view', compact('ucinak', 'radnoMjesto', 'sluzbenik'));
    }

    public function edit($id){
        $sluzbenici = Sluzbenik::all('id', 'ime', 'prezime');
        $niz_sluzbenika = array();
        foreach ($sluzbenici as $sluzbenik) {
            $niz_sluzbenika[$sluzbenik['id']] = $sluzbenik['ime'] . ' ' . $sluzbenik['prezime'];
        }
        $radna_mjesta = RadnoMjesto::select(['id', 'naziv_rm'])->get();
        $kategorija = Sifrarnik::dajSifrarnik('kategorija_ocjene');
        $ucinak = UpravljanjeUcinkom::findOrFail($id);

        return view('/hr/upravljanje_ucinkom/add', compact('niz_sluzbenika', 'radna_mjesta', 'kategorija', 'ucinak'));
    }

    public function update(Request $request, $id){
        $pravila = [
            'sluzbenik' => 'required',
            'godina' => 'required|min:4|max:4',
            'ocjena' => 'required',
            'opisna_ocjena' => 'required|max:255',
            'kategorija' => 'required'
        ];

        $poruke = HelpController::getValidationMessages();
        $this->validate($request, $pravila, $poruke);
        $u = UpravljanjeUcinkom::findOrFail($id);
        $u->update($request->all());

        return redirect()
            ->back()
            ->with('success', 'Uspješno ste izvršili izmjene!');

    }

    public function destroy($id){
        $ucinak = UpravljanjeUcinkom::findOrFail($id);
        $ucinak->delete();

        return redirect('/hr/upravljanje_ucinkom/home')->with('success', __('Uspješno ste izvršili brisanje!'));
    }



    /************************************************ IZVJEŠTAJI ******************************************************/

    public function pregledIzvjestaja(){
        $jedinice = OrganizacionaJedinica::whereHas('organizacija', function ($query){
            $query->where('active', '=', 1);
        })->with('organizacija.organ')
            ->with('radnaMjesta.sluzbeniciRel.sluzbenik');


//        $organizacija = Organizacija::where('active', 1)
//            ->with('organ')
//            ->with('organizacioneJedinice.radnaMjesta.sluzbeniciRel.sluzbenik')
//            ->get();

        $jedinice = FilterController::filter($jedinice);

        $filteri = [
            'organizacija.organ'=>'Organ javne uprave',
            'mjesto.rm.naziv_rm'=>'Organizaciona jedinica',
            'radnaMjesta.naziv_rm'=>'Radno mjesto',
            'radnaMjesta.sluzbeniciRel.sluzbenik.ime_prezime'=>'Službenici',
        ];

        return view('hr.upravljanje_ucinkom.zbirni-izvjestaji', compact('jedinice', 'filteri'));
    }
}
