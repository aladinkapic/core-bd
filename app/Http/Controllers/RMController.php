<?php

namespace App\Http\Controllers;

use App\Models\Organizacija;
use App\Models\OrganizacionaJedinica;
use App\Models\RadnoMjesto;
use App\Models\Sifrarnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RMController extends Controller{
    // $uslovi = DB::table('radno_mjesto_uslovi')->where('id_rm', '=', $radno_mjesto->id)->get();
    public function dodaj ($id){
        $org_jedinice = OrganizacionaJedinica::select(['id', DB::raw('concat(broj, \' \', naziv) as full_name')])
            ->with('parent')
            ->where('org_id', '=', $id)
            ->orderBy('broj', 'ASC')
            ->get()->pluck('full_name', 'id');


        $stepenSS    = Sifrarnik::dajSifrarnik('stepen');
        $kategorija  = Sifrarnik::dajSifrarnik('kategorija_radnog_mjesta');
        $kompetencije         = Sifrarnik::dajSifrarnik('strucna_sprema');

        return view('hr.radna_mjesta.novo.dodaj', [
            'stepenSS' => $stepenSS,
            'kategorija' => $kategorija,
            'orgJed' => $org_jedinice,
            'kompetencije' => $kompetencije,
            'organ_id' => $id
        ]);
    }
    public function spremi (Request $request){
        try{
            $rm = RadnoMjesto::create(
                $request->except(['_token', 'organ_id'])
            );
        }catch (\Exception $e){dd($e);}
        return redirect()->route('organizacija.radna-mjesta', ['id' => $request->organ_id]);
    }

    public function getData($action, $id, $file){
        $radnoMjesto   = RadnoMjesto::where('id', $id)->first();
        $organizacija        = Organizacija::find(OrganizacionaJedinica::findOrFail($radnoMjesto->id_oj)->org_id);
        $org_jedinice = OrganizacionaJedinica::select(['id', DB::raw('concat(broj, \' \', naziv) as full_name')])
            ->with('parent')
            ->where('org_id', '=', $organizacija->id)
            ->orderBy('broj', 'ASC')
            ->get()->pluck('full_name', 'id');
        $stepenSS    = Sifrarnik::dajSifrarnik('stepen');
        $kategorija  = Sifrarnik::dajSifrarnik('kategorija_radnog_mjesta');
        $kompetencije         = Sifrarnik::dajSifrarnik('strucna_sprema');

        return view('hr.radna_mjesta.novo.'.$file, [
            'stepenSS' => $stepenSS,
            'kategorija' => $kategorija,
            'orgJed' => $org_jedinice,
            'kompetencije' => $kompetencije,
            'organ_id' => $id,
            'organizacija' => $organizacija,
            'rm' => $radnoMjesto,
            $action => true
        ]);
    }

    public function pregledOrganizaciona($id){
        return $this->getData('preview', $id, 'pregled');
    }
    public function pregled($id){
        return $this->getData('preview', $id, 'dodaj');
    }
    public function urediOrganizaciona ($id){
        return $this->getData('edit', $id, 'dodaj');
    }
    public function azuriraj (Request $request){
        try{
            $rm = RadnoMjesto::where('id', $request->id)->update(
                $request->except(['id', '_token', 'organ_id'])
            );
        }catch (\Exception $e){}
        return back();
    }
}
