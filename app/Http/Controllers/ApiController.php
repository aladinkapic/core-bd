<?php

namespace App\Http\Controllers;

use App\Models\Sluzbenik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //

    public function pretragaSluzbenik(Request $request){
        $data = $request->get('data');

        $sluzbenicis = Sluzbenik::select(DB::raw("CONCAT(ime, ' ', prezime) as ime, id, radno_mjesto"))->whereRaw("CONCAT(ime, ' ', prezime) LIKE ?", ['%' . $data . '%'])->with('sluzbenikRel.rm')->get();

        $sluzbenici = $sluzbenicis->map(function($items){
            $data['id'] = $items->id;
            if(isset($items->sluzbenikRel)){
                $data['ime'] = $items->ime . " (" . ($items->sluzbenikRel->rm->naziv_rm ?? 'Nema radnog mjesta') . ")";
            } else {
                $data['ime'] = $items->ime;
            }
            return $data;
        });

        return response()->json($sluzbenici);

    }

}
