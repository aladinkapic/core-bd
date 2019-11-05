<?php

namespace App\Http\Controllers;

use App\Models\InstancePredavaci;
use App\Models\InstanceSluzbenici;
use App\Models\Obuka;
use App\Models\OcjenaObuke;
use App\Models\Tema;
use Illuminate\Http\Request;
use App\Models\Sifrarnik;
use App\Models\Predavac;
use App\Models\Sluzbenik;
use App\Models\ObukaInstanca;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\Object_;

class ObukaController extends Controller
{


    /**
     *
     *      $request = $request->all();
     *      foreach($request->predavacidiv as $predavac){
     * // Ovdje će ti dati vrijednost svake od određenih kolona
     *      }
     *
     *
     *
     *
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obuke = Obuka::with('instance.sviSluzbenici');
        $obuke = FilterController::filter($obuke);
        //dd($obuke);
        $filteri = ["naziv" => "Naziv obuke", "vrsta" => "Vrsta obuke", "organizator" => "Organizator obuke", "broj_polaznika" => 'Maksimalan broj polaznika', "" => 'Srednja ocjena', "instance.odrzavanje_od + instance.odrzavanje_od" => 'Instance obuke',];


        foreach ($obuke as $obuka) {
            $n = OcjenaObuke::where('obuka_id', $obuka->id)->count('ocjena');
            $sveocjene = OcjenaObuke::where('obuka_id', $obuka->id)->get();

            $obuka->brInstanci = DB::table('obuka_instance')->where('obuka_id', $obuka->id)->count();
            if ($n > 0) {
                $ocjena['ocjena'] = round(OcjenaObuke::where('obuka_id', $obuka->id)->sum('ocjena') / $n, 2);
                $ocjena['br_ocjena'] = $n;
                foreach ($sveocjene as $one) {
                    $sluzbenik = Sluzbenik::where('id', '=', $one->sluzbenici_id)->first();
                    $ocjena['detalji'][$one->id]['operater'] = $sluzbenik['ime'] . ' ' . $sluzbenik['prezime'];
                    $ocjena['detalji'][$one->id]['datum'] = date_format($one->created_at, "d.m.Y H:i:s");
                    $ocjena['detalji'][$one->id]['vrijednostocjene'] = $one->ocjena;
                }

                $obuka->ocjena = $ocjena;
            }
        }
        for ($i = 0; $i <= 10; $i++) {
            $ocjene[$i] = $i;
        }

        return view('/osposobljavanje_i_usavrsavanje/obuke/home', compact('obuke', 'ocjene', 'filteri'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $readonly = null;
        $pregled = false;
        $drzava = Sifrarnik::dajSifrarnik('drzava');
        $oblasti = Sifrarnik::dajSifrarnik('oblasti');
        $teme = Tema::all();
        $niztema = array();
        foreach ($teme as $tema) {
            $niztema[$tema['id']] = $tema['naziv'];
        }

        return view('/osposobljavanje_i_usavrsavanje/obuke/add', compact('readonly', 'pregled', 'drzava', 'oblasti', 'niztema'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = HelpController::formatirajRequest($request);

        $pravila = ['naziv' => 'required|max:50', 'vrsta' => 'required|max:50', 'opis' => 'max:1000', 'oblast' => 'max:50', 'podtema' => 'max:50', 'organizator' => 'max:50', 'sjediste' => 'max:50', 'broj_certifikata' => 'max:50', 'finansiranje_obuke' => 'max:50', 'stecena_znanja' => 'max:1000', 'broj_polaznika' => 'required|min:1|max:100',];

        $poruke = HelpController::getValidationMessages();
        $this->validate($request, $pravila, $poruke);
        try {
            $uprava = Obuka::create($request->except(['_method']));
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return redirect('/osposobljavanje_i_usavrsavanje/obuke/home')->with('success', __('Uspješno ste dodali obuku!'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $readonly = 'readonly';
        $obuka = Obuka::findOrFail($id);
        $pregled = true;
        $drzava = Sifrarnik::dajSifrarnik('drzava');
        $oblasti = Sifrarnik::dajSifrarnik('oblasti');
        $teme = Tema::all();
        $niztema = array();
        foreach ($teme as $tema) {
            $niztema[$tema['id']] = $tema['naziv'];
        }


        return view('/osposobljavanje_i_usavrsavanje/obuke/add', compact('readonly', 'obuka', 'pregled', 'drzava', 'niztema', 'oblasti'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $obuka = Obuka::findOrFail($id);

        $readonly = null;
        $pregled = false;
        $drzava = Sifrarnik::dajSifrarnik('drzava');
        $oblasti = Sifrarnik::dajSifrarnik('oblasti');
        $teme = Tema::all();
        $niztema = array();
        foreach ($teme as $tema) {
            $niztema[$tema['id']] = $tema['naziv'];
        }

        return view('/osposobljavanje_i_usavrsavanje/obuke/add', compact('obuka', 'readonly', 'pregled', 'drzava', 'oblasti', 'niztema'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request = HelpController::formatirajRequest($request);

        $pravila = ['naziv' => 'required|max:50', 'vrsta' => 'required|max:50', 'opis' => 'max:1000', 'oblast' => 'max:50', 'podtema' => 'max:50', 'organizator' => 'max:50', 'sjediste' => 'max:50', 'broj_certifikata' => 'max:50', 'finansiranje_obuke' => 'max:50', 'stecena_znanja' => 'max:1000', 'broj_polaznika' => 'required|min:1|max:100',];

        $poruke = HelpController::getValidationMessages();
        $this->validate($request, $pravila, $poruke);

        $u = Obuka::findOrFail($id);

        $u->update($request->all());

        return redirect('/osposobljavanje_i_usavrsavanje/obuke/home')->with('success', 'Uspješno ste izmjenili obuku!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obuka = Obuka::findOrFail($id);
        $obuka->delete();

        return redirect('/osposobljavanje_i_usavrsavanje/obuke/home')->with('success', 'Uspješno ste izmjenili obuku!');

    }

    //instanca
    public function addInstancu($id)
    {
        $readonly = 'readonly';
        $obuka = Obuka::findOrFail($id);
        $pregled = true;
        $instanca = 'new';
        $drzava = Sifrarnik::dajSifrarnik('drzava');
        $oblasti = Sifrarnik::dajSifrarnik('oblasti');
        $teme = Tema::all();
        $niztema = array();
        foreach ($teme as $tema) {
            $niztema[$tema['id']] = $tema['naziv'];
        }

        $predavaci = Predavac::all();
        $nizpredavaca = array();
        foreach ($predavaci as $predavac) {
            if (in_array($obuka->oblast, json_decode($predavac->oblasti_id))) $nizpredavaca[$predavac['id']] = $predavac['ime'] . ' ' . $predavac['prezime'];
        }


        $nizsluzbenika = Sluzbenik::select('ime', 'id', 'prezime')->orderBy('ime')->get()->pluck('full_name', 'id');

        return view('/osposobljavanje_i_usavrsavanje/obuke/add', compact('obuka', 'readonly', 'pregled', 'instanca', 'drzava', 'nizpredavaca', 'niztema', 'oblasti', 'nizsluzbenika'));
    }

    public function pregledInstance($id)
    {
        $instanca = ObukaInstanca::where('id', $id)->with('sviPredavaci')->with('sviSluzbenici')->first();
        $readonly = 'readonly';
        $obuka = Obuka::findOrFail($instanca->obuka_id);
        $pregled = true;
        $drzava = Sifrarnik::dajSifrarnik('drzava');
        $oblasti = Sifrarnik::dajSifrarnik('oblasti');
        $teme = Tema::all();
        $niztema = array();
        foreach ($teme as $tema) {
            $niztema[$tema['id']] = $tema['naziv'];
        }

        $nizpredavaca = [];


        $nizsluzbenika = Sluzbenik::select('ime', 'id', 'prezime')->orderBy('ime')->get()->pluck('full_name', 'id');

        return view('/osposobljavanje_i_usavrsavanje/obuke/add', compact('obuka', 'readonly', 'pregled', 'instanca', 'drzava', 'nizpredavaca', 'niztema', 'oblasti', 'nizsluzbenika'));
    }

    public function storeInstancu(Request $request)
    {
        $pravila = ['pocetak' => 'required', 'kraj' => 'required', 'predavaci' => 'required', 'sluzbenici' => 'required',];
        $poruke = HelpController::getValidationMessages();
        $this->validate($request, $pravila, $poruke);

        $request->pocetak = date_format(date_create_from_format('d.m.Y', $request->pocetak), 'Y-m-d');
        $request->kraj = date_format(date_create_from_format('d.m.Y', $request->kraj), 'Y-m-d');

        $instanca = new ObukaInstanca();
        $instanca->obuka_id = $request->obukaid;

        $postavkeniz['naziv'] = $request->naziv;
        $postavkeniz['vrsta'] = $request->vrsta;
        $postavkeniz['opis'] = $request->opis;
        $postavkeniz['oblast'] = $request->oblast;
        $postavkeniz['podtema'] = $request->podtema;
        $postavkeniz['organizator'] = $request->organizator;
        $postavkeniz['sjediste'] = $request->sjediste;
        $postavkeniz['zemlja_organizatora'] = $request->zemlja_organizatora;
        $postavkeniz['potvrda'] = $request->potvrda;
        $postavkeniz['datum_certifikata'] = $request->datum_certifikata;
        $postavkeniz['finansiranje_obuke'] = $request->finansiranje_obuke;
        $postavkeniz['broj_polaznika'] = $request->broj_polaznika;
        $postavkeniz['stecena_znanja'] = $request->stecena_znanja;
        $instanca->postavke = json_encode($postavkeniz);


        $instanca->predavaci = json_encode($request->predavaci);
        $instanca->sluzbenici = json_encode($request->sluzbenici);

        $instanca->odrzavanje_od = $request->pocetak;
        $instanca->odrzavanje_do = $request->kraj;
        $instanca->save();

        foreach ($request->predavaci as $key => $value) {
            $predavac = new InstancePredavaci();
            $predavac->predavac_id = $value;
            $predavac->instanca_id = $instanca->id;
            $predavac->save();
        }
        foreach ($request->sluzbenici as $key => $value) {
            $sl = new InstanceSluzbenici();
            $sl->sluzbenik_id = $value;
            $sl->instanca_id = $instanca->id;
            $sl->save();
        }

        return redirect('/osposobljavanje_i_usavrsavanje/obuke/home')->with('success', __('Uspješno ste dodali instancu obuke!'));

    }

    public function instance($id)
    {
        // $instance = DB::table('obuka_instance')->where('obuka_id', $id)->get();

        $instance = ObukaInstanca::where('obuka_id', '=', $id)->with('sviPredavaci.imePredavaca')->with('sviSluzbenici.imeSluzbenika');

        $instance = FilterController::filter($instance);
        //dd($obuke);
        $filteri = ['odrzavanje_od + odrzavanje_do' => 'Trajanje obuke', '' => 'Status', 'sviPredavaci.imePredavaca' => 'Predavači', 'sviSluzbenici.imeSluzbenika' => 'Službenici', 'postavke' => 'Postavke',];


        foreach ($instance as $ins) {
            $predavaci = json_decode($ins->predavaci);
            $sluzbenici = json_decode($ins->sluzbenici);

            $predavaci_array = [];
            $sluzbenici_array = [];
            foreach ($sluzbenici as $key => $sluzbenik) {
                $sluz = Sluzbenik::where('id', '=', $sluzbenik)->first();
                array_push($sluzbenici_array, $sluz);
            }
            foreach ($predavaci as $key => $predavac) {
                $pred = Predavac::where('id', '=', $predavac)->first();

                array_push($predavaci_array, $pred);
            }

            $ins->predavaci_real = $predavaci_array;
            $ins->sluzbenici_real = $sluzbenici_array;

            //status instance obuke
            $ins->status = ($this->statusDatuma($ins['odrzavanje_od'], $ins['odrzavanje_do']));

        }
        $postavke2 = json_decode(($instance[0]->postavke));

        $postavke2->oblast = ($postavke2->oblast = Sifrarnik::dajInstancu('oblasti', $postavke2->oblast));
        if (gettype(Tema::where('id', $postavke2->podtema)->first('naziv')) == "NULL") {
            $postavke2->oblast = 'Nepoznato ili izbrisano';
        } else {
            $postavke2->podtema = ($postavke2->podtema = Tema::where('id', $postavke2->podtema)->first('naziv'))->naziv;
        }
        $postavke2->zemlja_organizatora = ($postavke2->zemlja_organizatora = Sifrarnik::dajInstancu('drzava', $postavke2->zemlja_organizatora));
        if ($postavke2->potvrda == 0) $postavke2->potvrda = 'NE'; else $postavke2->potvrda = 'DA';


        $postavke = HelpController::format_table_columns($postavke2);
        return view('/osposobljavanje_i_usavrsavanje/obuke/instance', compact('instance', 'postavke', 'filteri'));

    }

    public function deleteInstance($id)
    {
        $instanca = ObukaInstanca::findOrFail($id);
        $instanca->delete();

        return redirect('/osposobljavanje_i_usavrsavanje/obuke/home')->with('success', 'Uspješno ste izbrisali instancu obuke!');

    }


    //metod za provjeravanje da li je datum izmedju,nakon ili prije pocetka i kraja
    public function statusDatuma($pocetak, $kraj)
    {
        $pocetak = strtotime($pocetak);
        $kraj = strtotime($kraj);

        if ((time() >= $pocetak) and (time() <= $kraj)) return 'Između'; else if (time() < $pocetak) return 'Prije'; else return 'Nakon';
    }

    public function ajaxrequest()
    {

        $response = [];
        $sluzbenici = Sluzbenik::all('id', 'ime', 'prezime');
        foreach ($sluzbenici as $sluzbenik) {
            $response['results']['id'] = $sluzbenik['id'];
            $response['results']['text'] = $sluzbenik['ime'] . ' ' . $sluzbenik['prezime'];
        }
        $response['pagination']['more'] = true;
        return response()->json($response);
    }

    public function ocjeni(Request $request)
    {

        $request->request->add(['sluzbenici_id' => Crypt::decryptString(Session::get('ID'))]);

        $imaliocjenu = OcjenaObuke::where('sluzbenici_id', $request->sluzbenici_id)->where('obuka_id', $request->obuka_id)->get();

        if ($imaliocjenu->first()) {

            $u = OcjenaObuke::where('sluzbenici_id', $request->sluzbenici_id)->where('obuka_id', $request->obuka_id)->first();

            $u->update($request->all());
        } else if ($request)

            try {
                $ocjena = OcjenaObuke::create($request->except(['_method']));
            } catch (\Exception $e) {
                return $e->getMessage();
            }

        return redirect('/osposobljavanje_i_usavrsavanje/obuke/home')->with('success', __('Uspješno ste ocjenili obuku!'));

    }

    public function ocjenaInstance($id, Request $request, $sl = null)
    {


        if (isset($sl)) {
            $ocjena = InstanceSluzbenici::where('instanca_id', $id)->where('sluzbenik_id', $sl)->first();
            $ocjena->update([$ocjena->ocjena = NULL]);
        }

        if (isset($request->ocjena) and isset($request->sluzbenik_id)) {
            $ocjena = InstanceSluzbenici::where('instanca_id', $id)->where('sluzbenik_id', $request->sluzbenik_id)->first();
            $ocjena->update([$ocjena->ocjena = $request->ocjena]);
        }


        $instanca = InstanceSluzbenici::where('instanca_id', $id)->with('imeSluzbenika');

        $instanca = FilterController::filter($instanca);

        $filteri = ['imeSluzbenika.ime_prezime' => 'Službenik', 'ocjena' => 'Ocjena', 'updated_at' => 'Izvršeno'];


        return view('/osposobljavanje_i_usavrsavanje/obuke/ocjenjivanjeInstance', compact('instanca', 'filteri'));
    }

    function loadPodteme(Request $request)
    {
        $teme = Tema::with('oblast_s')->where('oblast' , $request->id)->get();

        $temeniz=[];
        foreach ($teme as $tema){
            $temeniz[$tema->id]=$tema->naziv;
        }
        return $temeniz;
    }
}
