<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sifrarnik;

class SifrarnikController extends Controller{

    public function sviSifrarnici(){
        $kljucne_rijec = Sifrarnik::dajKljucneRijeci();

        $kljucne_rijec = collect($kljucne_rijec)->sortBy('1')->toArray();

        for($i=0; $i<count($kljucne_rijec); $i++){
            array_push($kljucne_rijec[$i], Sifrarnik::where('type', '=', $kljucne_rijec[$i][0])->count());
        }
        return view('sifrarnici.svi_sifrarnici', compact('kljucne_rijec'));
    }

    public function dodajSifrarnik($type){
        $sifrarnici       = Sifrarnik::where('type', '=', $type)->get();
        $naziv_sifrarnika = Sifrarnik::dajNazivSifrarnika($type);

        return view('sifrarnici.pregled_sifrarnika', compact('type', 'sifrarnici', 'naziv_sifrarnika'));
    }

    public function unosSifrarnika($type){
        return view('sifrarnici.unos_sifrarnika', compact('type'));
    }

    public function spremiSifrarnik(Request $request){
        try{
            Sifrarnik::create(
                $request->except(['_token'])
            );

            return redirect(route('dodaj.sifrarnik', ['type' => $request->type]));
        }catch(\Exception $e){
            dd($e);
        }

    }

    public function obrisiSifrarnik($type, $id){
        try{
            Sifrarnik::destroy($id);

            return redirect(route('dodaj.sifrarnik', ['type' => $type]));
        }catch(\Exception $e){
            dd($e);
        }
    }
}
