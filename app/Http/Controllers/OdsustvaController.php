<?php

namespace App\Http\Controllers;
use DB;

use Illuminate\Http\Request;
use App\Models\Sluzbenik;
use Mockery\Exception;
use Carbon\Carbon;

use App\Models\Code;
use App\Models\Check;
use App\Models\Sifrarnik;

use App;

class OdsustvaController extends Controller{
    public function __construct(){
        $this->middleware('role:odsustva');
    }


    /***************************************************************************************************************** /
     *
     *      Klasa kalendar.
     *
    /******************************************************************************************************************/
    protected $_day, $_month, $_year, $_month_duration, $_first_day;

    public function broj_dana_izmedju($prvi_datum, $drugi_datum){
        $prvi_datum = Carbon::parse($prvi_datum);
        return $prvi_datum->diffInDays(Carbon::parse($drugi_datum));
    }


    /***************************************************************************************************************** /
     *
     *      Potpuni pregled svih odsustava
     *
    /******************************************************************************************************************/

    public function izaberi_korisnika(){

        $sluzbenici = Sluzbenik::with('clanoviPorodice')
            ->with('spol_sl')
            ->with('bracni_status_sl')
            ->with('nacionalnost_sl')
            ->with('kategorija_sl')
            ->with('ispiti')
            ->with('kontaktDetalji')
            ->with('obrazovanje')
            ->with('prebivaliste')
            ->with('prestanakRO')
            ->with('prethodnoRI')
            ->with('strucnaSprema')
            ->with('vjestine')
            ->with('zasnivanjeRO')
            ->with('radnoMjesto.orgjed.organizacija.organ');


        $sluzbenici = FilterController::filter($sluzbenici);

        $filteri = ['id' => 'ID',
            'ime+prezime' => 'Ime i prezime',
            'email' => 'E-Mail',
            'jmbg' => 'JMB',
            'ime_roditelja' => 'Ime roditelja',
            'spol_sl.name' => 'Spol',
            'kategorija_sl.name' => 'Kategorija',
            'drzavljanstvo_1' => 'Državljanstvo',
            'nacionalnost_sl.name' => 'Nacionalnost',
            'bracni_status_sl.name' => 'Bračni status',
            'mjesto_rodjenja' => 'Mjesto rođenja',
            'datum_rodjenja' => 'Datum rođenja',
            'licna_karta' => 'Broj lične karte',
            'mjesto_izdavanja_lk' => 'Mjesto izdavanja lične karte',
            'id1' => 'PIO',
            'radnoMjesto.naziv_rm' => 'Radno mjesto',
            'radnoMjesto.orgjed.naziv' => 'Organizaciona jedinica',
            'radnoMjesto.orgjed.organizacija.organ.naziv' => 'Organ javne uprave',
            'radnoMjesto.rukovodioc' => 'Rukovodioc',
            'prebivaliste.adresa_prebivalista+prebivaliste.mjesto_prebivalista+prebivaliste.adresa_boravista' => 'Prebivalište',
            'id2' => 'Stručna sprema',
            'id3' => 'Položeni ispiti',
            'id4' => 'Kontakt informacije',
            'id5' => 'Dodatne vještine',
            'id6' => 'Zasnivanje radnog odnosa',
            'id7' => 'Prethodno radno iskustvo',
            'id8' => 'Prestanak radnog odnosa',
            'id9' => 'Članovi porodice',
        ];


//        $sluzbenici = Sluzbenik::get();
        $strucno_zvanje = DB::table('sluzbenik_obrazovanje_sluzbenika')->pluck('strucno_zvanje', 'id_sluzbenika');
        $odsustva   = true;



        return view('hr.sluzbenici.pregled', compact('sluzbenici', 'odsustva', 'filteri'));
    }

    public function kalendar($sluzbenik_id){
        $odsustva = Sifrarnik::dajSifrarnik('vrsta_odsustva');

        return view('/hr/odsustva/kalendar', compact('sluzbenik_id', 'odsustva'));
    }

    public function obrisiOdsustvo(Request $request){
        DB::table('odsustva')->delete($request->id);

        return Code::generateCode(App::make('App\Models\Check')->getErrorCode('0000'));
    }

    public function jsonOdsustvo(Request $request){
        $odsustva = DB::table('odsustva')->where('id', '=', $request->id)->get();
        $odsustva[0]->datum = HelpController::obrniDatum($odsustva[0]->datum);

        return $odsustva->toJson();
    }

    public function azurirajOdsustvo(Request $request){
        try{

            $request = HelpController::formatirajRequest($request);
            $request->request->add(['datum' => $request->datum_od, 'updated_at' => Carbon::now()]);

            DB::table('odsustva')->where('id', '=', $request->id)->update(
                $request->except(['id', '_token', 'datum_od', 'datum_do'])
            );

            return Code::generateCode(App::make('App\Models\Check')->getErrorCode('0000'));
        }catch (\Exception $e){
            return Code::generateCode(App::make('App\Models\Check')->getErrorCode('2000'));
        }
    }


    /***************************************************************************************************************** /
     *
     *      PRAZNICI : Kreiran je jedan view koji u sebi sadrži dva polja, jedan za unos praznika i jedan za pregled
     *      praznika. U zavisnosti da li je nešto poslano kao parametar view-u, prikazivat će nam pregled odnosno
     *
    /******************************************************************************************************************/

    public function pregledPraznika(){
        return view ('/hr/odsustva/dodaj_pregledaj_praznik');
    }

    public function dodajPraznik(){
        return view ('/hr/odsustva/dodaj_pregledaj_praznik');
    }

    public function urediPraznike(){
        $praznici = DB::table('praznici')->orderBy('datum_praznika', 'desc')->get();

        return view ('/hr/odsustva/dodaj_pregledaj_praznik', compact('praznici'));
    }

    public function azurirajPraznik(Request $request){
        $request = HelpController::formatirajRequest($request);
        $request->request->add(['updated_at' => Carbon::now()]);

        try{
            DB::table('praznici')->where('id', '=', $request->id_praznika)->update(
                $request->except(['_token', 'agree', 'id_praznika'])
            );

            return redirect('/hr/odsustva/uredi_praznik');
        }catch(\Exception $e){
            dd($e);
        }
    }

    public function obrisiPraznik($id){
        DB::table('praznici')->delete($id);

        return redirect('/hr/odsustva/uredi_praznik');
    }

    public function urediPraznik($id){
        $praznik = DB::table('praznici')->where('id', '=', $id)->first();

        return view ('/hr/odsustva/dodaj_pregledaj_praznik', compact('praznik'));
    }

    public function spremiPraznik(Request $request){
        $request = HelpController::formatirajRequest($request);
        $request->request->add(['created_at' => Carbon::now()]);

        try{
            DB::table('praznici')->insertGetId(
                $request->except(['_token', 'agree'])
            );

            return redirect('hr/odsustva/praznici/dodaj');
        }catch (\Exception $e){
            return $e;
        }
    }

    public function dajPraznike(Request $request){
        if($request->mjesec < 10) $request['mjesec'] = '0'.$request->mjesec;

        $from = Carbon::createFromFormat('Y-m-d', $request->godina.'-'.$request->mjesec.'-01')->format('Y-m-d');
        $to   = Carbon::createFromFormat('Y-m-d', $request->godina.'-'.$request->mjesec.'-30')->format('Y-m-d');

        return $praznici = DB::table('praznici')->whereBetween("datum_praznika", [$from, $to])->get();
    }


    /***************************************************************************************************************** /
     *
     *
     *
    /******************************************************************************************************************/

    public function limitiZaKorisnika($sluzbenik_id, $godina = null, $odsustvo = null){

        if($odsustvo == null) $svi_limiti = DB::table('limit_odsustva')->where('godina', '=', $godina)->where('sluzbenik_id', '=', 0)->orWhere('sluzbenik_id', '=', $sluzbenik_id)->get();
        else {
            $svi_limiti = DB::table('limit_odsustva')->where('godina', '=', $godina)->where('odsustvo', '=', $odsustvo)
                ->where(function ($ids) use($sluzbenik_id){
                    $ids->where('sluzbenik_id', '=', 0)->orWhere('sluzbenik_id', '=', $sluzbenik_id);
            })->get();
        }


        foreach($svi_limiti as $limit => $elementi){
            $vrsta = $elementi->odsustvo; $id_sluz = $elementi->sluzbenik_id;
            if($id_sluz == 0){ // Ako se odnosi na globalnom nivou
                foreach($svi_limiti as $drugi_limit){ // Iteriramo opet i tražimo isto odsustvo
                    $druga_vrsta = $drugi_limit->odsustvo; $id_dr_sluz = $drugi_limit->sluzbenik_id;

                    if($vrsta == $druga_vrsta){
                        if($id_sluz == 0 and $id_dr_sluz == $sluzbenik_id){
                            // echo $drugi_limit->id.' '.$odsustva[$drugi_limit->odsustvo];
                            unset($svi_limiti[$limit]);
                        }
                    }
                }
            }
        }

        return $svi_limiti;
    }


    public function dajOdsustvo(Request $request){
        if($request->mjesec < 10) $request['mjesec'] = '0'.$request->mjesec;

        $from = Carbon::createFromFormat('Y-m-d', $request->godina.'-'.$request->mjesec.'-01')->format('Y-m-d');
        $to   = Carbon::createFromFormat('Y-m-d', $request->godina.'-'.$request->mjesec.'-30')->format('Y-m-d');

        $result =  DB::table('odsustva')->whereBetween("datum", [$from, $to])->where('sluzbenik_id', '=', $request->sluzbenik_id)->get();
        $odsustva = Sifrarnik::dajSifrarnik('vrsta_odsustva');


        foreach($result as $res){
            $res->odsustvo = $odsustva[$res->vrsta_odsustva];
        }

        return $result;

    }


    public function spasiOdsustvo(Request $request){
        $request = HelpController::formatirajRequest($request);

        $datum_od = $request->datum_od;
        $datum_do = $request->datum_do;

        $godina_od = explode('-', $datum_od)[0];
        $godina_do = explode('-', $datum_do)[0];

        if(date('Y') != $godina_od or date('Y') != $godina_do){                   // Zabranimo unos odsustva za prethodnu
            return Code::generateCode(App::make('App\Models\Check')->getErrorCode('3000'));    // ili sljedeću kalendarsku godinu
        }

        $sva_odsustva = DB::table('odsustva')->whereYear('datum', '=', $godina_od)->get();                   // Sva odsustva u obliku liste koji su već rezervisani
        $limit = $this->limitiZaKorisnika($request->sluzbenik_id, 2019, $request->vrsta_odsustva);    // Maksimalan broj dana koji se mogu registrovati kao odsustvo za određenog korisnika i određeno odsustvo
        $broj_dana_odsustva = $this->broj_dana_izmedju($datum_od, $datum_do);                                // Ukupan broj dana za koje želimo registrovati odsustvo


        // ->addDays()->format('Y-m-d')
        $pocetni_datum = Carbon::parse($request->datum_od);


        /** !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! POSTAVITI RESTRIKCIJE !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! **/

        for($i=0; $i<=$broj_dana_odsustva; $i++){
            $request->request->add(['datum' => $pocetni_datum->format('Y-m-d'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

            DB::table('odsustva')->insertGetId(
                $request->except('_token', 'datum_od', 'datum_do')
            );

            $pocetni_datum->addDays();
        }


        return Code::generateCode(App::make('App\Models\Check')->getErrorCode('0000'));
    }

    public function listaOdsustava($od, $do, $sluzbenik_id){
        $od = HelpController::dajDatum($od);
        $do = HelpController::dajDatum($do);


        $sluzbenik      = Sluzbenik::where('id', '=', $sluzbenik_id) -> first();
        $vrsta_odsustva = Sifrarnik::dajSifrarnik('vrsta_odsustva');



        $odsustva  = DB::table('odsustva')->orderBy('datum')->whereBetween('datum', [$od, $do])->where('sluzbenik_id', '=', $sluzbenik_id)->get()->toArray();
        $lista = array();

        if(count($odsustva)){
            $broj_dana = 0; $pocetak = $odsustva[0]->datum; $kraj = $pocetak; $vrs_odsust = $odsustva[0]->vrsta_odsustva;

            for($i=0; $i<count($odsustva); $i++){
                if($odsustva[$i]->vrsta_odsustva != $vrs_odsust or ($i == count($odsustva) - 1) or ($odsustva[$i]->vrsta_odsustva == $vrs_odsust and $i > 1 and $this->broj_dana_izmedju($odsustva[$i - 1]->datum, $odsustva[$i]->datum) > 2) ){
                    $kraj = $odsustva[$i - 1]->datum;
                    if($i == count($odsustva) - 1){
                        $kraj = $odsustva[$i]->datum;
                        $broj_dana++;
                    }

                    $pocetak = HelpController::obrniDatum($pocetak); $kraj = HelpController::obrniDatum($kraj);

                    $data = array('vrsta_odsustva' => $vrsta_odsustva[$vrs_odsust], 'period' => $pocetak.' || '.$kraj, 'br_dana' => $broj_dana);
                    array_push($lista, $data);


                    $pocetak = $odsustva[$i]->datum;
                    $broj_dana = 0;
                    $vrs_odsust = $odsustva[$i]->vrsta_odsustva;
                }
                $broj_dana++;
            }
        }

        $od = HelpController::obrniDatum($od);
        $do = HelpController::obrniDatum($do);

        return view('/hr/odsustva/lista_odsustava', compact('sluzbenik_id', 'sluzbenik', 'od', 'do', 'lista'));
    }


    /***************************************************************************************************************** /
     *
     *      LIMITIRANJE ODSUSTVA
     *
     *      Limitiranje odsustva je bazirano na principu :
     *
     *          - Administrator unese limit odsustva za sve službenike koji se veže za jednu kalendarsku godinu.
     *            Te limite on isti može uređivati, brisati i pregledati po vrsti odsustva i kalendarskoj godini.
     *          - Ovaj način limitiranja se odnosi na sve službenike i automatski kreira restrikcije prilikom
     *            kreiranja odsustva svakog od službenika. NAPOMENA : Unos odsustva je limitiran na tekuću kalendarsku
     *            godinu !!!
     *
     *          - U slučaju potrebe, limit za svakog pojedinačnog službeniak se može izmijeniti te kao takav
     *            čitav rekord spremiti u bazu podataka.
     *
    /******************************************************************************************************************/


    public function limitOdsustavaZaSve(){
        $odsustva = Sifrarnik::dajSifrarnik('vrsta_odsustva');

        $svi_limiti = DB::table('limit_odsustva')->get();

        return view('hr/odsustva/limiti', compact('odsustva', 'svi_limiti'));
    }

    public function limitirajOdsustvaZaSve(){
        $odsustva = Sifrarnik::dajSifrarnik('vrsta_odsustva');

        return view('hr/odsustva/limit', compact('odsustva'));
    }

    public function spremiLimite(Request $request){
        $request->request->add(['created_at' => Carbon::now()]);

        if($request->name != null){ // Ako se složila sa svim : D
            DB::table('limit_odsustva')->insertGetId(
                $request->except(['_token', 'name'])
            );
        }

        return redirect('/hr/odsustva/limiti');
    }

    public function obrisiGlobalniLimit($id){
        DB::table('limit_odsustva')->delete($id);

        return redirect('/hr/odsustva/limiti');
    }

    public function urediGlobalniLimit($id){
        $odsustva = Sifrarnik::dajSifrarnik('vrsta_odsustva');
        $limit    = DB::table('limit_odsustva')->where('id', '=', $id)->first();

        return view('hr/odsustva/limit', compact('odsustva', 'limit'));
    }

    public function azurirajGlobalniLimit(Request $request){
        DB::table('limit_odsustva')->where('id', $request->id)->update(
            $request->except(['_token', 'id', 'sluzbenik_id', 'name'])
        );

        return redirect('/hr/odsustva/limiti');
    }


    /******************************************** LIMITI ZA POJEDINCA *************************************************/


    public function limitOdsustava($sluzbenik_id, $godina){ // pregled svih limita za određenog pojedinca
        $ime_sluzbenika = Sluzbenik::find($sluzbenik_id)->first()->toArray()['ime'];
        $odsustva   = Sifrarnik::dajSifrarnik('vrsta_odsustava');
        $svi_limiti = $this->limitiZaKorisnika($sluzbenik_id, $godina);

        return view('hr/odsustva/limiti_pojedinca', compact('ime_sluzbenika', 'sluzbenik_id', 'odsustva', 'svi_limiti', 'godina'));
    }


    public function urediLimitSluzbenika($id, $sluzbenik_id){
        $ime_sluzbenika = Sluzbenik::find($sluzbenik_id)->first()->toArray()['ime'];
        $odsustva   = Sifrarnik::dajSifrarnik('vrsta_odsustava');
        $limiti = DB::table('limit_odsustva')->where('id', '=', $id)->first();

        return view('/hr/odsustva/limit_pojedinca', compact('odsustva', 'limiti', 'ime_sluzbenika', 'sluzbenik_id'));
    }

    public function azurirajOdredjeniLimit(Request $request){
        // Prvo provjerimo da li ima rekorda sa identičnim podacima, tj da li je prilikom requesta došlo do izmjena -> GLOBALNI NIVO
        $globalni_nivo = DB::table('limit_odsustva')->where('odsustvo', '=', $request->odsustvo)->where('godina', '=', $request->godina)->where('ukupno', '=', $request->ukupno)->where('sluzbenik_id', '=', 0)->get();
        $rekord_korisnika = DB::table('limit_odsustva')->where('odsustvo', '=', $request->odsustvo)->where('godina', '=', $request->godina)->where('sluzbenik_id', '=', $request->sluzbenik_id)->get();

        if(!count($globalni_nivo) and !count($rekord_korisnika)){
            // ako nema rekorda sa određenom godinom, datumom i vrstom odsustva, znači da je došlo do nekih izmjena.
            // ako nema rekorda sa određenom godinom, datumom i sluzbenikom , znači da nemamo rekorda za određenog službenika

            $request->request->add(['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);

            DB::table('limit_odsustva')->insertGetId(
                $request->except(['_token', 'name', 'imeiprezime', 'odsustvo_wee'])
            );

        }else if(!count($globalni_nivo) and count($rekord_korisnika)){
            // ovdje updejtujemo rekord za određenog službenika
            $request->request->add(['updated_at' => Carbon::now()]);
            $id_rekorda = $rekord_korisnika->toArray()[0]->id;

            DB::table('limit_odsustva')->where('id', '=', $id_rekorda)->update(
                $request->except(['_token', 'name', 'imeiprezime', 'odsustvo_wee'])
            );
        }

        return redirect('/hr/odsustva/limiti_pojedinca/'.$request->sluzbenik_id.'/'.date('Y'));

    }
}
