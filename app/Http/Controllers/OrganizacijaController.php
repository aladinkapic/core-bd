<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HelpController;

use App\Models\Kretanje;
use App\Models\Organ;
use App\Models\Organizacija;
use App\Models\OrganizacionaJedinica;
use App\Models\Sluzbenik;
use App\Models\Sifrarnik;
use App\Models\RadnoMjesto;
use App\Models\Uloge;
use App\Models\Updates\Notifikacija;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PHPUnit\Util\Filter;
use Validator;



class OrganizacijaController extends Controller
{

    public function __construct(){
        $this->middleware('role:unutrasnja_org');
    }

    public function sort($data){
        $edges = [];
        $sorted = [];

        $i = 0;

        foreach ($data as $key => $object) {

            if ($object->marked == 1) continue;

            $object_id = $object->id;


            $edges[$i][] = $data[$key];

            unset($data[$key]);

            $edges[$i][] = $data->filter(function ($item) use ($object_id) {
                $parent = $item->parent_id;
                return $parent == $object_id;
            });

            foreach ($data as $k => $v) {
                if ($v->parent_id == $object_id) $data[$k]->marked = 1;
            }


            $i++;
        }

        foreach ($edges as $key => $value) {
            $sorted[] = $value[0];

            foreach ($value[1] as $k => $v) {
                $sorted[] = $v;
            }
        }

        return $sorted;
    }

    public function index(Request $request){

        $organizacija = Organizacija::with('organ')->with('aktivan')->orderBy('id', 'DESC');
        $organizacija = FilterController::filter($organizacija);

        $filteri = [
            'naziv' => 'Naziv',
            'organ.naziv' => 'Organ javne uprave',
            'datum_od' => 'Datum važenja od',
            'datum_do' => 'Datum važenja do',
            'aktivan.name' => 'Aktivan'
        ];

        return view('hr.organizacija.index')->with(compact('organizacija', 'filteri'));

    }

    public function edit(Request $request, $id){

        $organizacija = Organizacija::with('organ')->findOrFail($id);

        $org_jedinice = OrganizacionaJedinica::with('parent')
            ->where('org_id', '=', $organizacija->id)
            ->orderBy('broj', 'ASC')
            ->get();

        $novi_broj = OrganizacionaJedinica::select('broj')
            ->whereNull('parent_id')
            ->where('org_id', '=', $organizacija->id)
            ->orderBy('id', 'DESC')->first();

        $tipovi = Sifrarnik::dajSifrarnik('tip_organizacione_jedinice');


        return view('hr.organizacija.edit')->with(compact('organizacija', 'org_jedinice', 'novi_broj', 'tipovi'));

    }

    public function create(Request $request){
        return view('hr.organizacija.create');
    }
    public function izmijeniteOrganizaciju($id){
        $organizacija = Organizacija::where('id', $id)->first();

        return view('hr.organizacija.create', compact('organizacija'));
    }


    public function nova(){
        return view('hr.organizacija.nova');
    }

    public function destroy(Request $request, $id)
    {

        $org = Organizacija::find($id);

        if ($org->active == 1) return redirect(route('organizacija.index'))->with(['success' => 'Ne možete obrisati aktivnu unutrašnju organizaciju!']);

        Organizacija::brisanje($id);

        return redirect(route('organizacija.index'))->with('status', 'Uspješno obrisano!');

    }

    public function store(Request $request){
        $file = $request->file('dokument');

        $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $name = md5($file->getClientOriginalName() . time()) . '.' . $ext;

        $file->move("pravilnici/", $name);

        $poruke = HelpController::getValidationMessages();
        $validacija = Validator::make($request->all(), [
            'naziv' => 'required|max:255',
            'opis' => 'required|max:500',
            'datum_od' => 'required',
            'datum_do' => 'required',
            'dokument' => 'required|file|mimes:pdf,docx,xlsx,doc',
            'agree' => 'required'
        ], $poruke);

        $select = Organizacija::where('oju_id', '=', $request->get('oju_id'))->orderBy('id', 'DESC')->first();

        try{
            $organizacija = Organizacija::create([
                'naziv' => $request->get('naziv'),
                'opis' => $request->get('opis'),
                'datum_od' => HelpController::format($request->get('datum_od')),
                'datum_do' => HelpController::format($request->get('datum_do')),
                'oju_id' => $request->get('oju_id'),
                'active' => 0,
                'pravilnik' => $name
            ]);
        }catch (\Exception $e){
            dd($e);
        }


        if ($request->get('org_plan')) {
            Organizacija::copy($request->get('org_plan'), $organizacija->id);
        }

        return redirect(route('organizacija.edit', ['id' => $organizacija->id]))->with('success', 'Organizacioni plan je dodan!');
    }

    public function editJedinica(Request $request){
        $org_jedinica = OrganizacionaJedinica::with('parent')
            ->where('id', '=', $request->route('id'))
            ->orderBy('parent_id', 'ASC')
            ->first();

        $organizacija = Organizacija::where('id', '=', $org_jedinica->org_id)->first();

        $org_jedinice = OrganizacionaJedinica::with('parent')
            ->where('org_id', '=', $org_jedinica->org_id)
            ->orderBy('id', 'ASC')
            ->get();

        $tipovi = Sifrarnik::dajSifrarnik('tip_organizacione_jedinice');


        return view('hr.organizacija.jedinica-edit')->with(compact('org_jedinica', 'organizacija', 'org_jedinice', 'tipovi'));
    }

    public function radnaMjesta(Request $request, $id){
        $sluzbenici = Sluzbenik::select('ime', 'id', 'prezime')->orderBy('ime')->get()->pluck('full_name', 'id');
//        $radna_mjesta = RadnoMjesto::organizacijska($id);

        $radnaMjesta = RadnoMjesto::whereHas('orgjed.organizacija', function ($query) use ($id) {
            $query->where('id', '=', $id);
        })
            ->with('sluzbeniciRel.sluzbenik')
            ->with('strucnaSprema')
            ->with('tipRadnogMjesta')
            ->with('tipPrivremenogPremjestaja')
            ->with('orgjed');

        $radna_mjesta = FilterController::filter($radnaMjesta);

        $filteri = [
            'id' => '#',
            'orgjed.naziv' => 'Organizaciona jedinica',
            'naziv_rm' => 'Naziv radnog mjesta',
            'sifra' => 'Šifra',
            'katgorijaa.name' => 'Kategorija',
            'tipRadnogMjesta.name' => 'Tip radnog mjesta',
            'opis_rm' => 'Opis radnog mjesta',
            'broj_izvrsilaca' => 'Broj izvršilaca',
            'platni_razred' => 'Platni razred',
            'strucnaSprema.name' => 'Stručna sprema',
            'tipPrivremenogPremjestaja.name' => 'Tip privremenog premještaja',
            'sluzbeniciRel.sluzbenik.ime_prezime' => 'Službenici'
        ];



        $organizacija         = Organizacija::with('organ')->findOrFail($id);

        $kateogrija_radnog    = Sifrarnik::dajSifrarnik('kategorija_radnog_mjesta');
        $tip_premjestaja      = Sifrarnik::dajSifrarnik('tip_privremenog_premjestaja');
        $tip_uslova           = Sifrarnik::dajSifrarnik('tip_uslova');
        $strucna_sprema       = Sifrarnik::dajSifrarnik('strucna_sprema');
        $tip_radnog_mjesta    = Sifrarnik::dajSifrarnik('tip_radnog_mjesta');
        $benificirani         = Sifrarnik::dajSifrarnik('benificirani')->prepend('Odaberite', '0');

        $org_jedinice = OrganizacionaJedinica::select(['id', DB::raw('concat(broj, \' \', naziv) as full_name')])
            ->with('parent')
            ->where('org_id', '=', $organizacija->id)
            ->orderBy('broj', 'ASC')
            ->get()->pluck('full_name', 'id');

        return view('hr.organizacija.radna-mjesta')->with(compact('sluzbenici', 'tip_premjestaja', 'tip_uslova', 'organizacija', 'org_jedinice', 'radna_mjesta', 'id', 'kateogrija_radnog', 'strucna_sprema', 'tip_radnog_mjesta', 'filteri', 'benificirani'));
    }

    public function api(Request $request){

        if ($request->get('action') == 'getOrganizacija') {

            if (empty($request->get('org_id'))) {
                return "[]";
            }

            return Organizacija::where('oju_id', '=', $request->get('org_id'))->get()->toJson();
        }

    }

    public function active(Request $request, $id){
        $object = Organizacija::findOrFail($id);
        $check = Organizacija::select('active')->where('oju_id', '=', $object->oju_id)->where('id', '>', $id)->get();
        $aktivna = Organizacija::where('oju_id', '=', $object->oju_id)->where('active', '=', 1)->first();

        if ($aktivna) {
            $aktivna->active = 0;
            $aktivna->save();
        }

        foreach ($check as $org) {
            // Ne može prethodne sistematizacije aktivirat
            if ($org->active == 1) return redirect(route('organizacija.edit', ['id' => $id]))->with('danger', 'Organizacioni plan ne može biti postavljen kao aktivan!');
        }

        // Dohvatamo sve službenike unutar organa javne uprave za koji se aktivira sistematizacija
        $sluzbenici = Sluzbenik::whereOrgan($object->oju_id);

        // Ukoliko je radno_mjesto_temp NULL -> prebacivamo id radno_mjesto na novi iz organizacionog plana
        foreach ($sluzbenici as $sluzbenik) {

            $temp_radno = RadnoMjesto::where('before_id', '=', $sluzbenik->radno_mjesto)->orderBy('id', 'DESC')->first();

            if ($sluzbenik->radno_mjesto_temp) {
                $sluzbenik->radno_mjesto = $sluzbenik->radno_mjesto_temp;
                $sluzbenik->radno_mjesto_temp = null;
            } else {
                $sluzbenik->radno_mjesto = $temp_radno->id;
            }

            /*
                Sluzbenik mijenja radno mjesto?
            */

            if ($sluzbenik->radno_mjesto_temp) {
                $kretanje = new Kretanje();
                $kretanje->id_rm = $sluzbenik->radno_mjesto;
                $kretanje->id_rm_before = $sluzbenik->radno_mjesto_temp;
                $kretanje->sluzbenik = $sluzbenik->id;
                $kretanje->org_id = $object->id;
                $kretanje->save();
            }


            $sluzbenik->save();


        }

        $object->active = 1;
        $object->save();

        return redirect(route('organizacija.edit', ['id' => $id]));

    }

    public function shema(Request $request, $id){
        $organizacija = Organizacija::where('id', '=', $id)->first();
        $radna_mjesta = RadnoMjesto::organizacijska($organizacija->id);

        $org_jedinice = OrganizacionaJedinica::with('parent')
            ->where('org_id', '=', $id)
            ->orderBy('broj', 'ASC')
            ->with('radnaMjesta')
            ->get();

        return view('hr.organizacija.shema')->with(compact('org_jedinice', 'organizacija', 'radna_mjesta'));
    }


    public function izmjena($id){
        $organizacija = Organizacija::where('id', $id)->first();

        

        if(!$organizacija->brojIzmjena){
            $broj = 1;
        }else if($organizacija->brojIzmjena < 5){
            $broj = ($organizacija->brojIzmjena + 1);
        }else $broj = 'overflow';

        if($broj != 'overflow'){
            $organizacija->update([
                'brojIzmjena' => $broj
            ]);


            $korisnik = Sluzbenik::where('id', Crypt::decryptString(Session::get('ID')))->first();

            $organ = Organ::where('id', $organizacija->oju_id)->first();

            if($broj == 5){
                $sluzbeniciZaNotifikacije = Uloge::where('keyword', 'unutrasnja_org')->get(['sluzbenik_id'])->toArray();
                $users = Sluzbenik::whereIn('id', $sluzbeniciZaNotifikacije)->get();

                foreach($users as $user){
                    $notifikacija = Notifikacija::create([
                        'sluzbenik_id' => $user->id,
                        'what' => 'unutrasnja_organizacija',
                        'to_who' => $korisnik->id,
                        'message' => ':: Službenik '.$korisnik->ime.' '.$korisnik->prezime.' je izvršio 5-i put izmjenu sistematizacije "'.$organizacija->naziv.'" ( '.$organ->naziv.' )'
                    ]);
                }
            }
        }
        return back();
    }
}
