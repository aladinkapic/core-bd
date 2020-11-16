<?php

namespace App\Http\Controllers;

use App\Models\Organizacija;
use App\Models\OrganizacionaJedinica;
use App\Models\RadnoMjesto;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function radnaMjestaOrgana(Request $request){
        $id = $request->id;

        /*
        $organizacija = Organizacija::where('oju_id', $id)->where('active', 1)->first();

        dd($id);
        $org_jedinice = OrganizacionaJedinica::where('org_id', $organizacija->id)->pluck('id')->toArray();
        $radnaMjesta = RadnoMjesto::whereIn('id_oj', $org_jedinice)->get();
        dd($radnaMjesta);

        $org_jed = OrganizacionaJedinica::where('organizacija.organ', function ($query) use ($id){
            $query->where('id', $id);
        })->get('id');

        dd($org_jed); */

        $radnaMjesta = RadnoMjesto::whereHas('orgjed.organizacija.organ', function ($query) use ($id){
            $query->where('id', $id);
        })->whereHas('orgjed.organizacija', function ($query){
            $query->where('active', 1);
        })->get(['id', 'naziv_rm']);

        return array('radna_mjesta' => $radnaMjesta);
    }

    public function dajSistematizacije(Request $request){
        $id = $request->id;
        $organizacije = Organizacija::whereHas('organ', function ($query) use ($id){
            $query->where('id', $id);
        })->get(['id', 'naziv', 'active']);


        return array('organizacije' => $organizacije);
    }
    public function radnaMjestaizSistema(Request $request){
        $organizacija = Organizacija::where('id', $request->id)->first();

        $organ_id = $organizacija->oju_id;
        $org_id   = $request->id;

        $radnaMjesta = RadnoMjesto::whereHas('orgjed.organizacija.organ', function ($query) use ($organ_id){
            $query->where('id', $organ_id);
        })->whereHas('orgjed.organizacija', function ($query) use($org_id){
            $query->where('id', $org_id);
        })->get(['id', 'naziv_rm']);

        return array('radna_mjesta' => $radnaMjesta);
    }
}
