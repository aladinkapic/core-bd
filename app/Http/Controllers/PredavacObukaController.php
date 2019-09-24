<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Predavac_Obuka;
use App\Models\Sifrarnik;

class PredavacObukaController extends Controller
{
    public function index()    {
        $predavaci_obuke = Predavac_Obuka::all();

        return view('/osposobljavanje_i_usavrsavanje/predavaci/home', compact('predavaci_obuke'));
    }


    public function storePredavaci(Request $request){

        $pravila = [
            'id_obuka' => 'required|max:100',
            'id_predavac' => 'required|max:100'
        ];

        $poruke = HelpController::getValidationMessages();
        $this->validate($request, $pravila, $poruke);

        try{
            $predavac_obuka = Predavac_Obuka::create($request->except(['_method']));
        }catch(\Exception $e){
            return $e->getMessage();
        }

        return redirect('/osposobljavanje_i_usavrsavanje/predavaci/home')->with('success', __('Uspješno ste unijeli predavača!'));
    }
}
