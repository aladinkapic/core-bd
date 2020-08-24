<?php

namespace App\Http\Controllers;

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

        $radnaMjesta = RadnoMjesto::whereHas('orgjed.organizacija.organ', function ($query) use ($id){
            $query->where('id', $id);
        })->whereHas('orgjed.organizacija', function ($query){
            $query->where('active', 1);
        })->get(['id', 'naziv_rm']);
        return array('radna_mjesta' => $radnaMjesta);
    }
}
