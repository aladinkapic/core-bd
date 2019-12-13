<?php

namespace App\Http\Controllers;

use App\Models\Tema;
use Illuminate\Http\Request;
use App\Models\Predavac;
use App\Models\Sifrarnik;
use Illuminate\Support\Facades\DB;


class PredavaciController extends Controller
{
    public function index()    {
        $predavaci = Predavac::query();
        $predavaci = FilterController::filter($predavaci);

        $filteri = [
            "ime" => "Ime",
          "prezime" => "Prezime",
          "telefon" => "Telefon",
          "mail" => "E-mail",
          "napomena" => 'Napomena',
        ];

        return view('/osposobljavanje_i_usavrsavanje/predavaci/home', compact('predavaci', 'filteri'));
    }

    public function create()
    {
        $obuke = Sifrarnik::dajSifrarnik('vrsta_obuke');

        $oblasti = Sifrarnik::dajSifrarnik('oblasti');

        return view('osposobljavanje_i_usavrsavanje/predavaci/add', compact('obuke','oblasti'));
    }
    public function storePredavaci(Request $request){


        $request->request ->add(['oblasti_id' => $request->teme]);
        $pravila = [
            'ime' => 'required|max:100',
            'prezime' => 'required|max:100',
            'telefon' => 'required|max:255',
            'mail' => 'required',
            'napomena' => 'max:255',
            'teme' => 'required'
        ];

        $poruke = HelpController::getValidationMessages();
        $this->validate($request, $pravila, $poruke);

        $predavac = new Predavac();
        $predavac -> ime = $request-> ime;
        $predavac -> prezime = $request-> prezime;
        $predavac -> telefon = $request-> telefon;
        $predavac -> mail = $request-> mail;
        $predavac -> napomena = $request-> napomena;
        $predavac->oblasti_id = json_encode($request -> oblasti_id);
        $predavac ->save();



        return redirect('/osposobljavanje_i_usavrsavanje/predavaci/home')->with('success', __('Uspješno ste unijeli predavača!'));
    }

    public function show($id)
    {
        $oblastitekst = null;
        $predavac = Predavac::findOrFail($id);
        //$teme = $this->getTeme($id);
        $predavac->oblasti_id = json_decode($predavac->oblasti_id);
        $oblasti = Sifrarnik::dajSifrarnik('oblasti');
        foreach ($predavac->oblasti_id as $key =>$value){
            foreach ($oblasti as $oblastikey =>$oblastivalue){
                if($value == $oblastikey){$oblastitekst.= $oblastivalue.' ';}
            }
        }

        return view('/osposobljavanje_i_usavrsavanje/predavaci/view', compact('predavac', 'oblastitekst'));
    }

    public function edit($id)
    {
        $predavac = Predavac::findOrFail($id);
        $oblasti = Sifrarnik::dajSifrarnik('oblasti')->toArray();
        $selected = array_intersect(json_decode($predavac->oblasti_id) , array_flip($oblasti));

        return view('/osposobljavanje_i_usavrsavanje/predavaci/add', compact('predavac', 'oblasti', 'selected'));
    }
    public function update(Request $request, $id){
        $pravila = [
            'ime' => 'required|max:100',
            'prezime' => 'required|max:100',
            'telefon' => 'required|max:255',
            'mail' => 'required',
            'napomena' => 'max:255',
            'oblasti' => 'required'

        ];

        $poruke = HelpController::getValidationMessages();
//        $this->validate($request, $pravila, $poruke);

        try{
            $predavac = Predavac::where('id', $id)->first()->update([
                'ime' => $request->ime,
                'prezime' => $request->prezime,
                'telefon' => $request->telefon,
                'mail' => $request->mail,
                'napomena' => $request->napomena,
                'oblasti_id' => json_encode($request->teme)
            ]);
        }catch (\Exception $e){dd($e);}

        return redirect()
            ->back()
            ->with('success', 'Uspješno ste izmjenili predavača!');

    }
    public function destroy($id)
    {
        $predavac = Predavac::findOrFail($id);
        $predavac -> delete();

        return redirect('/osposobljavanje_i_usavrsavanje/predavaci/home')->with('success', __('Uspješno ste izbrisali predavača!'));
    }
    public function getTeme($id){
        $niztema = [];

        $teme = Predavac::findOrFail($id)->teme;
        $teme = json_decode($teme);
            foreach($teme as $tema){
                $niztema[$tema] = Tema::findOrFail($tema)->naziv;
            }
        return $niztema;
    }
}
