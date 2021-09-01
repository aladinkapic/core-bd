<?php

namespace App\Http\Controllers;

use App\Models\Organizacija;
use App\Models\OrganizacionaJedinica;
use App\Models\RadnoMjesto;
use App\Models\Sluzbenik;
use App\Models\Updates\OrgJedinicaIzvjestaj;
use App\Models\UpravljanjeUcinkom;
use App\Models\UpravljanjeUcinkomProbni;
use Illuminate\Http\Request;
use App\Models\Sifrarnik;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use function foo\func;

class UpravljanjeUcinkomController extends Controller{
    public function index(){
        $ucinci = UpravljanjeUcinkom::with('usluzbenik')->with('mjesto.rm');
        $ucinci = FilterController::filter($ucinci);

        $filteri = [
            'usluzbenik.ime_prezime'=>'Službenik',
            'mjesto.rm.naziv_rm'=>'Radno mjesto',
            'godina'=>'Godina ocjenjivanja',
            'ocjena'=>'Ocjena',
            'opisna_ocjena'=>'Opisna ocjena',
            'ocjenjivacRel.ime_prezime' => 'Ocjenjivač',
            'nijeOcjenjenRel.name' => 'Ocijenjen'
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
        $kategorija = Sifrarnik::dajSifrarnik('kategorija_ocjene')->prepend('Odaberite kategoriju', '0');


        return view('hr/upravljanje_ucinkom/add', compact('niz_sluzbenika', 'radna_mjesta', 'kategorija'));
    }

    public function updateIzvjestaj($sl_id, $godina){
        try{
            $sluzbenik = Sluzbenik::where('id', $sl_id)->with('radnoMjesto.orgjed')->first();

            $orgJed_id = $sluzbenik->radnoMjesto->orgjed->id ?? 0;
            if($orgJed_id){

                $nijeZadovoljio = UpravljanjeUcinkom::whereHas('usluzbenik.radnoMjesto.orgjed', function($query) use($orgJed_id){
                    $query->where('id', $orgJed_id);
                })->where('godina', $godina)->where('ocjena', '<', '1.5')->count();
                $zadovoljava = UpravljanjeUcinkom::whereHas('usluzbenik.radnoMjesto.orgjed', function($query) use($orgJed_id){
                    $query->where('id', $orgJed_id);
                })->where('godina', $godina)->where('ocjena', '>=', '1.5')->where('ocjena', '<', '2.5')->count();
                $nadmasuje = UpravljanjeUcinkom::whereHas('usluzbenik.radnoMjesto.orgjed', function($query) use($orgJed_id){
                    $query->where('id', $orgJed_id);
                })->where('godina', $godina)->where('ocjena', '>=', '2.5')->count();


                try{
                    // Ako pronađemo rel sa željenim rezultatima, updejtujemo, ako ne, unosimo novu
                    $rel = OrgJedinicaIzvjestaj::where('org_jed', $orgJed_id)->where('godina', $godina)->firstOrFail();
                    $rel->update([
                        'ne_zadovoljava' => $nijeZadovoljio,
                        'zadovoljava'    => $zadovoljava,
                        'nadmasuje'      => $nadmasuje,
                        'ukupno'         => $nijeZadovoljio + $zadovoljava + $nadmasuje
                    ]);
                }catch (\Exception $e){
                    try{
                        OrgJedinicaIzvjestaj::create([
                            'org_jed'        => $orgJed_id,
                            'godina'         => $godina,
                            'ne_zadovoljava' => $nijeZadovoljio,
                            'zadovoljava'    => $zadovoljava,
                            'nadmasuje'      => $nadmasuje,
                            'ukupno'         => $nijeZadovoljio + $zadovoljava + $nadmasuje
                        ]);
                    }catch (\Exception $e){}
                }
            }
        }catch (\Exception $e){}
    }

    public function updateAll (){
        $ucinci = UpravljanjeUcinkom::get();
        foreach ($ucinci as $ucinak){
            $this->updateIzvjestaj($ucinak->sluzbenik, $ucinak->godina);
        }
    }

    public function storeUcinci(Request $request){
        $pravila = [
            'sluzbenik' => 'required',
            'godina' => 'required|min:4|max:4'
        ];

        if($request->ocjena < 1.5){
            $request->request->add(['opisna_ocjena' => 'Nije zadovoljio']);
        }else if($request->ocjena >= 1.5 and $request->ocjena <= 2.5){
            $request->request->add(['opisna_ocjena' => 'Zadovoljava očekivanja']);
        }else $request->request->add(['opisna_ocjena' => 'Nadmašuje očekivanja']);

        $poruke = HelpController::getValidationMessages();
        $this->validate($request, $pravila, $poruke);

        $exists = UpravljanjeUcinkom::where('sluzbenik', '=', $request->sluzbenik)->where('godina', '=', $request->godina)->where('kategorija', '=', $request->kategorija)->first();
        if ($exists) {
            return redirect('/hr/upravljanje_ucinkom/add')->with('error', __('Službenik je prethodno ocjenjen sa ovim podacima!'));
        }
        else {
            try {
                $ucinak = UpravljanjeUcinkom::create($request->except(['_method']));

                $this->updateIzvjestaj($request->sluzbenik, $request->godina);
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

        $kategorija = Sifrarnik::dajSifrarnik('kategorija_ocjene');
        $sluzbenik = Sluzbenik::where('id', '=', $ucinak->sluzbenik)->first();
        $sluzbenik = $sluzbenik['ime'] . ' ' . $sluzbenik['prezime'];
        $ocjenjivac = Sluzbenik::where('id', '=', $ucinak->ocjenjivac)->first();
        $ocjenjivac = $ocjenjivac['ime'] . ' ' . $ocjenjivac['prezime'];
        $preview = true;

        return view('/hr/upravljanje_ucinkom/view', compact('ucinak', 'radnoMjesto', 'sluzbenik', 'ocjenjivac', 'kategorija', 'preview'));
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
            'ocjena' => 'required',
            'kategorija' => 'required'
        ];

        $poruke = HelpController::getValidationMessages();

        if($request->ocjena < 1.5){
            $request->request->add(['opisna_ocjena' => 'Nije zadovoljio']);
        }else if($request->ocjena >= 1.5 and $request->ocjena <= 2.5){
            $request->request->add(['opisna_ocjena' => 'Zadovoljava očekivanja']);
        }else $request->request->add(['opisna_ocjena' => 'Nadmašuje očekivanja']);

        if(isset($request->ocjena) and $request->ocjena) $nije = 1;
        else $nije = 1;


        try{
            $ucinak = UpravljanjeUcinkom::where('id', $id)->first()->update([
                'sluzbenik' => $request->sluzbenik,
                'godina'    => $request->godina,
                'ocjena'    => $request->ocjena,
                'kategorija' => $request->kategorija,
                'opisna_ocjena' => $request->opisna_ocjena,
                'ocjenjivac' => $request->ocjenjivac,
                'nije_ocjenjen' => $nije
            ]);
            $this->updateIzvjestaj($request->sluzbenik, $request->godina);
        }catch (\Exception $e){dd($e);}

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
    public function updejtujIzvjestaj(){
        $jedinice = OrganizacionaJedinica::whereHas('organizacija', function ($query){
            $query->where('active', '=', 1);
        })->with('radnaMjesta.sluzbeniciRel.sluzbenik.upravljanjeUcinkom')->get();

        $sluzbenici = [];

        // TODO - Pošto će biti problem vjerovatno sa starim sistematizacijama, čekat ćemo da prijave problem :D

        foreach($jedinice as $jedinica){
            $nadmasuje = 0; $zadovoljava = 0; $ne_zadovoljava = 0;

            if(isset($jedinica->radnaMjesta)){
                foreach($jedinica->radnaMjesta as $radnoMjesto){
                    if(isset($radnoMjesto->sluzbeniciRel)){
                        foreach($radnoMjesto->sluzbeniciRel as $sluzbenik){
                            if(isset($sluzbenik->sluzbenik->upravljanjeUcinkom)){
                                if($sluzbenik->sluzbenik->upravljanjeUcinkom->opisna_ocjena == 'Nadmašuje očekivanja') $nadmasuje ++;
                                else if($sluzbenik->sluzbenik->upravljanjeUcinkom->opisna_ocjena == 'Zadovoljava očekivanja') $zadovoljava ++;
                                else $ne_zadovoljava ++;
                                array_push($sluzbenici, $sluzbenik->sluzbenik);
                            }
                        }
                    }
                }
            }


            try{
                // Ako pronađemo rel sa željenim rezultatima, updejtujemo, ako ne, unosimo novu
                $rel = OrgJedinicaIzvjestaj::where('org_jed', $jedinica->id)->where('godina', date('Y'))->firstOrFail();
                $rel->update([
                    'ne_zadovoljava' => $ne_zadovoljava,
                    'zadovoljava'    => $zadovoljava,
                    'nadmasuje'      => $nadmasuje,
                    'ukupno'         => $ne_zadovoljava + $zadovoljava + $nadmasuje
                ]);
            }catch (\Exception $e){
                try{
                    OrgJedinicaIzvjestaj::create([
                        'org_jed'        => $jedinica->id,
                        'godina'         => date('Y'),
                        'ne_zadovoljava' => $ne_zadovoljava,
                        'zadovoljava'    => $zadovoljava,
                        'nadmasuje'      => $nadmasuje,
                        'ukupno'         => $ne_zadovoljava + $zadovoljava + $nadmasuje
                    ]);
                }catch (\Exception $e){}
            }

        }
    }


    public function pregledIzvjestaja(){
        $jedinice = OrgJedinicaIzvjestaj::whereHas('orgJedinica.organizacija.organ', function($query){
            $query->whereNotNull('naziv');
        })->with('orgJedinica.organizacija.organ');
        $jedinice = FilterController::filter($jedinice);

        $filteri = [
            'orgJedinica.organizacija.organ.naziv'  => 'Organ javne uprave',
            'orgJedinica.naziv'  => 'Organizaciona jedinica',
            'godina'         => 'Godina',
            'ne_zadovoljava' => 'Ne zadovoljava očekivanja',
            'zadovoljava'    => 'Zadovoljava očekivanja',
            'nadmasuje'      => 'Nadmašuje očekivanja',
            'ukupno'         => 'Ukupno ocjenjenih'
        ];

        return view('hr.upravljanje_ucinkom.zbirni-izvjestaji', compact('jedinice', 'filteri'));
    }



    public function pregledProbnih(){
        $sviProbni = UpravljanjeUcinkomProbni::with('usluzbenik');
        $sviProbni = FilterController::filter($sviProbni);

        $filteri = [
            'usluzbenik.ime_prezime'  => 'Ime i prezime',
            'godina'  => 'Godina',
            'prviClan.ime_prezime'    => 'Prvi član',
            'drugiClan.ime_prezime'   => 'Drugi član',
            'treciClan.ime_prezime'   => 'Treći član',
            'ocjena'                  => 'Ocjena',
            'opisna_ocjena'           => 'Opisna ocjena',
        ];

        return view('/hr/upravljanje_ucinkom/probni-rad/home', compact('sviProbni', 'filteri'));
    }
    public function dodajProbni(){
        $sluzbenici = Sluzbenik::get()->sortBy('ime_prezime')->pluck('ime_prezime', 'id')->prepend('Odaberite službenika', '0');

        $radna_mjesta = RadnoMjesto::select(['id', 'naziv_rm'])->get();
        $kategorija = Sifrarnik::dajSifrarnik('kategorija_ocjene')->prepend('Odaberite kategoriju', '0');

        return view('/hr/upravljanje_ucinkom/probni-rad/add-new', compact('sluzbenici', 'kategorija'));
    }

    public function spremiProbni(Request $request){
        // $opisna = (round(($request->ocjena_prvi + $request->ocjena_drugi + $request->ocjena_treci) / 3, 2));

        $opisna = $request->ocjena;
        if($opisna > 1.5) $request->request->add(['opisna_ocjena' => 'Zadovoljio']);
        else $request->request->add(['opisna_ocjena' => 'Nije zadovoljio']);

        try{
            $probni = UpravljanjeUcinkomProbni::create(
                $request->except(['id'])
            );
        }catch (\Exception $e){dd($e);}
        return redirect()->route('probni-rad.pregled');
    }

    public function pregledajProbni($id){
        $probni = UpravljanjeUcinkomProbni::where('id', $id)->firstOrFail();
        $preview = true;
        $sluzbenici = Sluzbenik::get()->sortBy('ime_prezime')->pluck('ime_prezime', 'id')->prepend('Odaberite službenika', '0');

        $radna_mjesta = RadnoMjesto::select(['id', 'naziv_rm'])->get();
        $kategorija = Sifrarnik::dajSifrarnik('kategorija_ocjene')->prepend('Odaberite kategoriju', '0');

        return view('/hr/upravljanje_ucinkom/probni-rad/add-new', compact('sluzbenici', 'kategorija', 'probni', 'preview'));
    }
    public function urediProbni($id){
        $probni = UpravljanjeUcinkomProbni::where('id', $id)->firstOrFail();
        $edit = true;
        $sluzbenici = Sluzbenik::get()->sortBy('ime_prezime')->pluck('ime_prezime', 'id')->prepend('Odaberite službenika', '0');

        $radna_mjesta = RadnoMjesto::select(['id', 'naziv_rm'])->get();
        $kategorija = Sifrarnik::dajSifrarnik('kategorija_ocjene')->prepend('Odaberite kategoriju', '0');

        return view('/hr/upravljanje_ucinkom/probni-rad/add-new', compact('sluzbenici', 'kategorija', 'probni', 'edit'));
    }
    public function azurirajProbni(Request $request){
        $opisna = $request->ocjena;

        if($opisna > 1.5) $request->request->add(['opisna_ocjena' => 'Zadovoljio']);
        else $request->request->add(['opisna_ocjena' => 'Nije zadovoljio']);

        try{
            $probni = UpravljanjeUcinkomProbni::where('id', $request->id)->first()->update(
                $request->except(['_token', 'id'])
            );
        }catch (\Exception $e){}

        return redirect()->route('probni-rad.pregled');
    }
}
