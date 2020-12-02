<?php

namespace App\Http\Controllers;

use App\Models\Odsustva;
use App\Models\Organ;
use DB;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use function GuzzleHttp\Promise\queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
/** za kreiranje sesija **/

use Carbon\Carbon;

use App;
use App\Models\Code;
use App\Models\Check;
use App\Models\Generic;

use App\Models\Sifrarnik;
use App\Models\Sluzbenik;
use App\Models\RadnoMjesto;
use App\Models\OrganizacionaJedinica;
use App\Models\Uprava;


class SluzbenikController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:sluzbenici');
    }


    public function broj_dana_izmedju($prvi_datum, $drugi_datum)
    {
        $prvi_datum = Carbon::parse($prvi_datum);
        return $prvi_datum->diffInDays(Carbon::parse($drugi_datum));
    }


    public function dodajSluzbenika()
    {
        $kategorija     = Sifrarnik::dajSifrarnik('kategorija');
        $nacionalnost   = Sifrarnik::dajSifrarnik('nacionalnost');
        $bracni_status  = Sifrarnik::dajSifrarnik('bracni_status');
        $trenutno_radi  = Sifrarnik::dajSifrarnik('vrsta_radnog_odnosa');
        $spol           = Sifrarnik::dajSifrarnik('spolovi')->prepend('Odaberite pol');
        $pio            = Sifrarnik::dajSifrarnik('pio')->prepend('Odaberite PIO');
        $domena         = Sifrarnik::dajSifrarnik('ekstenzija_domene')->prepend('Izaberite domenu', '0');
        $drzava                 = Sifrarnik::dajSifrarnik('drzava')->prepend('Odaberite državljanstvo');

        $unos = true;

        return view('/hr/sluzbenici/dodaj_sluzbenika', compact('kategorija', 'nacionalnost', 'bracni_status', 'spol', 'trenutno_radi', 'domena', 'unos', 'pio', 'drzava'));
    }

    public function urediSluzbenika($id_sluzbenika){
        $sluzbenik = Sluzbenik::where('id', '=', $id_sluzbenika)->get()->first();


        $podaci_o_prebivalistu = DB::table('sluzbenik_podaci_o_prebivalistu')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $strucna_sprema = DB::table('sluzbenik_strucna_sprema')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $ispiti = DB::table('sluzbenik_ispiti')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $kontakt_detalji = DB::table('sluzbenik_kontakt_detalji_osobe')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $obrazovanje_sluzbenika = DB::table('sluzbenik_obrazovanje_sluzbenika')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $vjestine = DB::table('sluzbenik_vjestine_sluzbenika')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $zasnivanje_r_odnosa = DB::table('sluzbenik_zasnivanje_radnog_odnosa')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        //$prethodno_r_iskustvo = DB::table('sluzbenik_prethodno_radno_iskustvo')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $prethodno_r_iskustvo = App\Models\DummyModels\PrethodnoRI::where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $prestanak_r_o = DB::table('sluzbenik_prestanak_radnog_odnosa')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $clanovi_porodice = DB::table('sluzbenik_clanovi_porodice')->where('id_sluzbenika', '=', $id_sluzbenika)->get();

        if (isset($sluzbenik->radno_mjesto)) $radno_mjesto = RadnoMjesto::find($sluzbenik->radno_mjesto)->first()->naziv_rm;
        else $radno_mjesto = 'Nema radnog mjesta';

        $spol                   = Sifrarnik::dajSifrarnik('spolovi');
        $kategorija             = Sifrarnik::dajSifrarnik('kategorija');
        $nacionalnost           = Sifrarnik::dajSifrarnik('nacionalnost');
        $bracni_status          = Sifrarnik::dajSifrarnik('bracni_status');
        $vrsta_vjestine         = Sifrarnik::dajSifrarnik('vrsta_vještine');
        $nivo_vjestine          = Sifrarnik::dajSifrarnik('nivo_vjestine');
        $osnov_za_prestanak_rd  = Sifrarnik::dajSifrarnik('osnov_za_prestanak_ro');
        $radno_vrijeme          = Sifrarnik::dajSifrarnik('radno_vrijeme');
        $nacin_zasnivanja       = Sifrarnik::dajSifrarnik('nacin_zasnivanja_ro');
        $vrsta_ro               = Sifrarnik::dajSifrarnik('vrsta_radnog_odnosa');
        $obracunati_staz        = Sifrarnik::dajSifrarnik('obracunati_staz');
        $srodstvo               = Sifrarnik::dajSifrarnik('srodstvo');
        $trenutno_radi          = Sifrarnik::dajSifrarnik('vrsta_radnog_odnosa');
        $kategorija_ispita      = Sifrarnik::dajSifrarnik('kategorija_ispita');
        $domena                 = Sifrarnik::dajSifrarnik('ekstenzija_domene')->prepend('Izaberite domenu', '0');
        $pio                    = Sifrarnik::dajSifrarnik('pio')->prepend('Odaberite PIO');
        $drzava                 = Sifrarnik::dajSifrarnik('drzava')->prepend('Odaberite državljanstvo');
        // $obrazovnaInstitucija   = Sifrarnik::dajSifrarnik('obrazovna_institucija')->prepend('Odaberite obrazovnu instituciju');
        $poslodavac             = Sifrarnik::dajSifrarnik('poslodavac')->prepend('Odaberite poslodavca');
        $stepen                 = Sifrarnik::dajSifrarnik('stepen')->prepend('Odaberite');


        $obrazovnaInstitucija =  Sifrarnik::where('type', 'obrazovna_institucija')->orderBy('name')->get()->pluck('name', 'value');
        /*
         * eKonkurs popunjavanje dodatnih informacija
         */

        if(isset($sluzbenik->ekonkurs) and $sluzbenik->ekonkurs == 1){

            /*
             * Školovanje
            */

            $obrazovanje = eKonkursController::dajProceduru('[S07].[GetRegistrationSchoolInfo]', 'T035C001', $sluzbenik->ekonkurs_prijava);

            foreach($obrazovanje as $ob){
                DB::table('sluzbenik_strucna_sprema')->insert(
                    [
                        'obrazovna_institucija' => $ob->nazivSjedisteDrzava,
                        'vrsta_s_s' => $ob->zvanjePotvrdaDiploma,
                        'datum_zavrsetka' => $ob->pohadjaoDo,
                        'id_sluzbenika' => $sluzbenik->id
                        ,
                        'komenta_o_diplomi' => 'Od: ' . $ob->pohadjaoOd . ", ECTS: ". $ob->etcsBodovi
                    ]
                );
            }


            /*
             * Profesionalna nadogradnja
             */

            $profesionalna = eKonkursController::dajProceduru('[S07].[GetRegistrationProfessionalUpgradeInfo]', 'T035C001', $sluzbenik->ekonkurs_prijava);

            foreach($profesionalna as $ob){
                DB::table('sluzbenik_ispiti')->insert(
                    [
                        'podkategorija' => $ob->idVrstaProfesionalneNadogradnje,
                        'naziv_ovog_ispita' => $ob->vrstaProfesionalneNadogradnje,
                        'id_sluzbenika' => $sluzbenik->id
                    ]
                );
            }

            /*
             * Strani jezici
             */

            $jezici = eKonkursController::dajProceduru('[S07].[GetRegistrationLanguagesInfo]', 'T035C001', $sluzbenik->ekonkurs_prijava);

            foreach($jezici as $ob){
                DB::table('sluzbenik_vjestine_sluzbenika')->insert(
                    [
                        'institucija' => $ob->jezik,
                        'vrsta_vjestine' => 1,
                        'id_sluzbenika' => $sluzbenik->id,
                        'komentar' => 'Govor: ' . $ob->govorStranogJezika . " - Citanje: " . $ob->citanjeStranogJezika . " - Pisanje: " . $ob->pisanjeStranogJezika
                    ]
                );
            }

            /*
             * Radno iskustvo
             */

            $iskustvo = eKonkursController::dajProceduru('[S07].[GetRegistrationWorkExperienceInfo]', 'T035C001', $sluzbenik->ekonkurs_prijava);

            foreach($iskustvo as $ob){
                DB::table('sluzbenik_prethodno_radno_iskustvo')->insert(
                    [
                        'poslodavac' => $ob->nazivPoslodavca,
                        'sjediste_poslodavca' => $ob->adresaPoslodavca,
                        'period_zaposlenja_od' => $ob->datumOd,
                        'period_zaposlenja_do' => $ob->datumDo,
                        'opis_poslova' => $ob->vrstaPosla,
                        'napomena' => $ob->napomena,
                        'id_sluzbenika' => $sluzbenik->id,
                    ]
                );
            }

            $sluzbenik->ekonkurs = 2;
            $sluzbenik->save();

            $historija = new App\Models\eKonkurs();
            $historija->id_sluzbenika = $sluzbenik->id;
            $historija->id_roota = Sluzbenik::me()->id;
            $historija->save();

        }

        return view('/hr/sluzbenici/dodaj_sluzbenika', compact('id_sluzbenika', 'nivo_vjestine', 'vrsta_ro', 'obracunati_staz', 'nacin_zasnivanja', 'sluzbenik', 'prethodno_r_iskustvo', 'podaci_o_prebivalistu', 'strucna_sprema', 'obrazovanje_sluzbenika', 'ispiti', 'kontakt_detalji', 'vjestine', 'zasnivanje_r_odnosa', 'prestanak_r_o', 'clanovi_porodice', 'radno_mjesto', 'spol', 'kategorija', 'nacionalnost', 'bracni_status', 'vrsta_vjestine', 'osnov_za_prestanak_rd', 'radno_vrijeme', 'srodstvo', 'trenutno_radi', 'kategorija_ispita', 'domena', 'pio', 'drzava', 'obrazovnaInstitucija', 'poslodavac', 'stepen'));
    }

    public function redirektajNaDodatno($id)
    {
        return redirect('/hr/sluzbenici/dodatno_o_sluzbeniku/' . $id);
    }

    public function redirektajNaUredjivanje($id)
    {
        return redirect('/hr/sluzbenici/uredi_sluzbenika/' . $id);
    }

    public function unesiSliku(Request $request){
        /** Unosimo sliku i spašavamo je u slike/slike_sluzbenika **/
        if ($request->has('sluzbenik_slika')) {
            $file = $request->file('sluzbenik_slika');

            $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            echo $name = md5($file->getClientOriginalName() . time()) . '.' . $ext;

            /************************************************************************************************************* /
             *
             *      Pošto postoji mogućnost da se uploaduje pogrešna slika, te da ne bi dolazilo do nepotrebnog
             *      nakupljanja fajlova na serveru, postavit ćemo sessiju koju ćemo uništavati nakon što zavvršimo
             *      sa unosom službenika.
             *
             *      Ako je sesija postavljena, to znači da smo već unijeli sliku službenika, ali nismo ga spremili, pa
             *      sliku možemo izbrisati iz storage-a.
             *
             * /**************************************************************************************************************/


//            if(Session::has('slika_sluzbenika')){
//                unlink('slike/slike_sluzbenika/'.Session::get('slika_sluzbenika'));
//            }

            Session::put('slika_sluzbenika', $name);

            // print_r(Session::get('slika_sluzbenika'));


            $file->move("slike/slike_sluzbenika/", $name);
        }
    }

    public function provjeriSluzbenika(Request $request)
    { // ** Ovdje možemo testirati da li ima duplikata nekog polja
        if (count(App::make('App\Models\Check')->provjeriKolonu('sluzbenici', $request->osnova, $request->polje))) {
            return Code::generateCode(App::make('App\Models\Check')->getErrorCode(true, $request->osnova));
        } else {
            return Code::generateCode(App::make('App\Models\Check')->getErrorCode('0000'));
        }
    }

    /***************************************************************************************************************** /
     *
     *      Metoda služi za spremanje službenika kao baznog objekta. Mnogi od ključeva su strani ključevi, te treba
     *      pripaziti na to.
     *
     *      Koristili smo statičku metodu create radi jednostavnijeg navigiranja prilikom kreiranja jer se validacija
     *      radi striktno putem .js fajlova.
     *
     * /******************************************************************************************************************/

    function imaLiIstihUsernameova($username){
        if (Sluzbenik::where('korisnicko_ime', '=', $username)->first()) return true;
        return false;
    }


    protected function getUsername($firstName, $lastName) {
        $firstName = Str::slug($firstName);
        $lastName  = Str::slug($lastName);
        $username = $firstName.'.'.$lastName;

        try{
            $user = Sluzbenik::where('korisnicko_ime', 'like', '%'.$username.'%')->count();
            if($user){
                return $username.$user;
            }
        }catch (\Exception $e){}

        return $username;
    }

    public function spremiUtabelu(Request $request){
        $request = HelpController::formatirajRequest($request);

        $jmbg = Sluzbenik::where('jmbg', '=', $request->jmbg)->first();
        // $username = Sluzbenik::where('korisnicko_ime', '=', $request->korisnicko_ime)->first();

        $request['korisnicko_ime'] = $this->getUsername($request->ime, $request->prezime);
        if ($jmbg) return false;

        /* $counter = 1;
        while (true) {
            if (Sluzbenik::where('korisnicko_ime', '=', $request->korisnicko_ime)->first()) {
                $request['korisnicko_ime'] = $request['korisnicko_ime'] . $counter++;
            } else break;
        } */

        try{
            $request['email'] = $request->korisnicko_ime.'@'.Sifrarnik::dajSifrarnik('ekstenzija_domene')[$request->email];
            $request['ime_prezime'] = $request->prezime.' '.$request->ime;
        }catch (\Exception $e){
            return $e->getMessage();
        }


        try {
            $sluzbenik = Sluzbenik::create($request->except(['_method']));
            $id_sluzbenika = $sluzbenik->id;
            return $id_sluzbenika;
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }


    public function azurirajTabelu(Request $request){
        $request = HelpController::formatirajRequest($request);

        try {
            if (Sluzbenik::where('id', '=', $request->id)->update($request->except(['_method', 'id']))) {
                return $request->id;
            } else return false;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function spremiSluzbenika(Request $request){

        /************************************************************************************************************* /
         *
         * Prvo provjerimo da li imamo nekog službenika sa istim matičnim brojem
         * ili sa istim brojem lične karte
         *
         *
         * To dvoje moraju biti unique -> inače ili dupliciramo korisnika ili nešto nije u redu !
         *
         * /**************************************************************************************************************/

        if (($response = $this->spremiUtabelu($request)) >= 1) {
            return Code::generateCode(App::make('App\Models\Check')->getErrorCode('0000', 'special_message', $response));
        } else {
            return Code::generateCode(App::make('App\Models\Check')->getErrorCode('2000'));;
        }
    }

    public function azurirajSluzbenika(Request $request){
        if ($response = $this->azurirajTabelu($request)) {
            return Code::generateCode(App::make('App\Models\Check')->getErrorCode('0000', 'special_message', $response));
        } else {
            return Code::generateCode(App::make('App\Models\Check')->getErrorCode('2000'));
        }

    }


    public function dodatno_o_sluzbeniku($id_sluzbenika, $what = null){
        $sluzbenik = Sluzbenik::where('id', '=', $id_sluzbenika)->get()->first();

        $podaci_o_prebivalistu = DB::table('sluzbenik_podaci_o_prebivalistu')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $strucna_sprema = DB::table('sluzbenik_strucna_sprema')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $ispiti = DB::table('sluzbenik_ispiti')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $kontakt_detalji = DB::table('sluzbenik_kontakt_detalji_osobe')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $obrazovanje_sluzbenika = DB::table('sluzbenik_obrazovanje_sluzbenika')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $vjestine = DB::table('sluzbenik_vjestine_sluzbenika')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $zasnivanje_r_odnosa = DB::table('sluzbenik_zasnivanje_radnog_odnosa')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $prethodno_r_iskustvo = App\Models\DummyModels\PrethodnoRI::where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $prestanak_r_o = DB::table('sluzbenik_prestanak_radnog_odnosa')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $clanovi_porodice = DB::table('sluzbenik_clanovi_porodice')->where('id_sluzbenika', '=', $id_sluzbenika)->get();

        $ukupno_dana = 0;


        foreach ($prethodno_r_iskustvo as $prethodno) {
            $ukupno_dana += ($this->broj_dana_izmedju($prethodno->period_zaposlenja_od, $prethodno->period_zaposlenja_do) * $prethodno->koeficijent / 100);
        }

        foreach ($zasnivanje_r_odnosa as $zasnivanje) {
            $ukupno_dana += $this->broj_dana_izmedju($zasnivanje->datum_zasnivanja_o, Carbon::now());
        }

        /*** Ako je službenik na neplaćenom odsustvu, to treba oduzeti .. ***/
        $neplacenoDana = Odsustva::where('sluzbenik_id', '=', $id_sluzbenika)->where('vrsta_odsustva', '=', 1)->count();
        $ukupno_dana -= $neplacenoDana;


        /*** Ovdje ćemo dobijati ukupni službenika ***/

        $godina = (int)(($ukupno_dana / 30 / 12));
        $mjeseci = (int)(($ukupno_dana / 30) - ($godina * 12));
        $dana = ($ukupno_dana % 30);


        if ($sluzbenik->radno_mjesto != null) {
            $rm_model = RadnoMjesto::where('id', $sluzbenik->radno_mjesto)->first();
            $radno_mjesto = $rm_model->naziv_rm;

            // Ako je službenik vezan za određeno radno mjesto , pri tom mora biti vezan i za određennu
            // organizacionu jedinicu i organ javne uprave

            $organizaciona_jed = OrganizacionaJedinica::where('id', $rm_model->id_oj)->first();
            $organ_ju = Uprava::find(Sluzbenik::organJavneUprave($sluzbenik->id)->first()->id)->naziv;

        } else {
            $radno_mjesto = 'Nema radnog mjesta';
            $organizaciona_jed = "-";
            $organ_ju = "-";
        }


        $spol                   = Sifrarnik::dajSifrarnik('spolovi');
        $kategorija             = Sifrarnik::dajSifrarnik('kategorija');
        $nacionalnost           = Sifrarnik::dajSifrarnik('nacionalnost');
        $bracni_status          = Sifrarnik::dajSifrarnik('bracni_status');
        $vrsta_vjestine         = Sifrarnik::dajSifrarnik('vrsta_vještine');
        $nivo_vjestine          = Sifrarnik::dajSifrarnik('nivo_vjestine');
        $osnov_za_prestanak_rd  = Sifrarnik::dajSifrarnik('osnov_za_prestanak_ro');
        $radno_vrijeme          = Sifrarnik::dajSifrarnik('radno_vrijeme');
        $nacin_zasnivanja       = Sifrarnik::dajSifrarnik('nacin_zasnivanja_ro');
        $vrsta_ro               = Sifrarnik::dajSifrarnik('vrsta_radnog_odnosa');
        $obracunati_staz        = Sifrarnik::dajSifrarnik('obracunati_staz');
        $srodstvo               = Sifrarnik::dajSifrarnik('srodstvo');
        $trenutno_radi          = Sifrarnik::dajSifrarnik('vrsta_radnog_odnosa');
        $kategorija_ispita      = Sifrarnik::dajSifrarnik('kategorija_ispita');
        $drzava                 = Sifrarnik::dajSifrarnik('drzava')->prepend('Odaberite državljanstvo');
        $pio                    = Sifrarnik::dajSifrarnik('pio')->prepend('Odaberite PIO');
        $obrazovnaInstitucija   = Sifrarnik::dajSifrarnik('obrazovna_institucija')->prepend('Odaberite obrazovnu instituciju');
        $poslodavac             = Sifrarnik::dajSifrarnik('poslodavac')->prepend('Odaberite poslodavca');
        $stepen                 = Sifrarnik::dajSifrarnik('stepen')->prepend('Odaberite');

        Session::put('aditional_counter', 0); $pregled = true;

        return view('/hr/sluzbenici/dodatno_o_sluzbeniku', compact('id_sluzbenika', 'nivo_vjestine', 'vrsta_ro', 'obracunati_staz', 'nacin_zasnivanja', 'sluzbenik', 'prethodno_r_iskustvo', 'podaci_o_prebivalistu', 'strucna_sprema', 'obrazovanje_sluzbenika', 'ispiti', 'kontakt_detalji', 'vjestine', 'zasnivanje_r_odnosa', 'prestanak_r_o', 'clanovi_porodice', 'radno_mjesto', 'spol', 'kategorija', 'nacionalnost', 'bracni_status', 'vrsta_vjestine', 'osnov_za_prestanak_rd', 'radno_vrijeme', 'what', 'pregled', 'organizaciona_jed', 'organ_ju', 'godina', 'mjeseci', 'dana', 'srodstvo', 'trenutno_radi', 'kategorija_ispita', 'drzava', 'pio', 'obrazovnaInstitucija', 'poslodavac', 'stepen'));
    }


    /***************************************************************************************************************** /
     *
     *      U ovom dijelu ćemo prikazivati sve sluzbenike. U budućnosti, možda je pametno uraditi
     *      numeraciju stranica, pa bi kao parametar metode bio broj stranice na kojoj smo trenutno
     *
     * /******************************************************************************************************************/

    public function pregledSluzbenika(Request $request){
        $dd = Odsustva::where('sluzbenik_id', 529)->where('vrsta_odsustva', 2)->count();

        if(Route::currentRouteName() == 'odsustva.izaberi') $odsustva = true;
        else $odsustva = null;

        $sluzbenici = Sluzbenik::with('clanoviPorodiceRel')
            ->with('spol_sl')
            ->with('bracni_status_sl')
            ->with('nacionalnost_sl')
            ->with('kategorija_sl')
            ->with('ispitiRel')
            ->with('kontaktDetalji')
            ->with('obrazovanjeRel')
            ->with('prebivaliste')
            ->with('prestanakRORel')
            ->with('prethodnoRIRel')
            ->with('strucnaSprema.stepenStrucne')
            ->with('strucnaSprema.obrazovnaInstitucija')
            ->with('vjestineRel')
            ->with('zasnivanjeRORel')
//            ->with('poreskaUprava') // TODO
            ->with('sluzbenikRel.rm.orgjed.organizacija.organ')
            ->with('sluzbenikRel.rm.stepenSS')
            ->with('sluzbenikRel.rm.rukovodioc_s')
            ->with('zasnivanjeRORel.nacin_zasnivanja_ro_s')
            ->with('zasnivanjeRORel.vrsta_r_o_s')
            ->with('pioRel')
            ->with('zasnivanjeRORel.obracunati_r_staz_s')
            ->with('privremeniRel.privremeno_mjesto')
            ->orderBy('prezime');

//        $sluz = Sluzbenik::get();
//        foreach ($sluz as $s){
//            $s->ime_prezime = $s->prezime.' '.$s->ime;
//            $s->save();
//        }

        $sluzbenici = FilterController::filter($sluzbenici);
//      dd($sluzbenici[2]->strucnaSprema);

        $filteri = [
            'id' => '#',
            'ime_prezime' => 'Ime i prezime',
            'email' => 'E-Mail',
            'jmbg' => 'JMB',
            'ime_roditelja' => 'Ime roditelja',
            'status' => 'Status',

            'spol_sl.name' => 'Spol',
            'kategorija_sl.name' => 'Kategorija',
            'drzavljanstvoRel.name' => 'Državljanstvo',
            'nacionalnost_sl.name' => 'Nacionalnost',
            'bracni_status_sl.name' => 'Bračni status',

            'staz_godina' => 'Obračunati radni staž - g',
            'staz_mjeseci' => 'Obračunati radni staž - m',
            'staz_dana' => 'Obračunati radni staž - d',

            'mrs_g' => 'Minuli radni staž - g',
            'mrs_m' => 'Minuli radni staž - m',
            'mrs_d' => 'Minuli radni staž - d',

            'mjesto_rodjenja' => 'Mjesto rođenja',
            'datum_rodjenja' => 'Datum rođenja',
            'licna_karta' => 'Broj lične karte',
            'mjesto_izdavanja_lk' => 'Mjesto izdavanja lične karte',
            'pioRel.name' => 'Poreska uprava',
            'sluzbenikRel.rm.naziv_rm' => 'Radno mjesto',
            'sluzbenikRel.rm.katgorijaa.name' => 'Kategorija radnog mjesta',
            'sluzbenikRel.rm.stepenSS.name' => 'Stepen stručne spreme - radno mjesto',
            'privremeniRel.privremeno_mjesto.naziv_rm' => 'Privremeni premještaj',
            'radnoMjesto.orgjed.naziv' => 'Organizaciona jedinica',
            'radnoMjesto.orgjed.organizacija.organ.naziv' => 'Organ javne uprave',
            'prebivaliste.adresa_prebivalista' => 'Adresa boravišta',
            'prebivaliste.mjesto_prebivalista' => 'Mjesto prebivališta',
            'prebivaliste.adresa_boravista' => 'Adresa prebivališta',

            'zasnivanjeRORel.datum_zasnivanja_o' => 'Datum zasnivanja radnog odnosa',
            'zasnivanjeRORel.nacin_zasnivanja_ro_s.name' => 'Način zasnivanja radnog odnosa',
            'zasnivanjeRORel.vrsta_r_o_s.name' => 'Vrsta radnog odnosa',
            'zasnivanjeRORel.obracunati_r_staz_s.name' => 'Obračunati staž',
            'zasnivanjeRORel.obracunati_r_s_god' => ' Staž godina',
            'zasnivanjeRORel.obracunati_r_s_mje' => ' Staž mjeseci',
            'zasnivanjeRORel.obracunati_r_s_dan' => ' Staž dani',
            'zasnivanjeRORel.datum_donosenja_dokumentacije' => 'Datum donošenja dokumentacije',
            'zasnivanjeRORel.minuli_radni_staz' => 'Minuli radni staž',

            'strucnaSprema.stepenStrucne.name' => 'Stručna sprema tražena konkursom',
            'obrazovanjeRel.ciklus.name' => 'Ciklus obrazovanja',
            'obrazovanjeRel.strucno_zvanje' => 'Stručno zvanje',
            'strucnaSprema.vrsta_s_s' => 'Zanimanje traženo konkursom',
            'strucnaSprema.obrazovnaInstitucija.name' => 'Obrazovna institucija',
//            'id3' => 'Položeni ispiti',
//            'id4' => 'Kontakt informacije',
//            'id5' => 'Dodatne vještine',
//            'id7' => 'Prethodno radno iskustvo',
//            'id8' => 'Prestanak radnog odnosa',
//            'id9' => 'Članovi porodice',
        ];


        return view('hr.sluzbenici.pregled', compact('sluzbenici', 'filteri', 'odsustva'));
    }

    public function ispisSluzbenika($id_sluzbenika){
        $what = null;
        $sluzbenik = Sluzbenik::where('id', '=', $id_sluzbenika)
            ->with('prebivaliste')
            ->with('ispitiRel')
            ->with('vjestineRel')
            ->with('zasnivanjeRORel')
            ->with('obrazovanjeRel')
            ->with('prethodnoRIRel')
            ->with('prestanakRORel')
            ->with('clanoviPorodiceRel')
            ->first();



        $podaci_o_prebivalistu = DB::table('sluzbenik_podaci_o_prebivalistu')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $strucna_sprema = DB::table('sluzbenik_strucna_sprema')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $ispiti = DB::table('sluzbenik_ispiti')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $kontakt_detalji = DB::table('sluzbenik_kontakt_detalji_osobe')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $obrazovanje_sluzbenika = DB::table('sluzbenik_obrazovanje_sluzbenika')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $vjestine = DB::table('sluzbenik_vjestine_sluzbenika')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $zasnivanje_r_odnosa = DB::table('sluzbenik_zasnivanje_radnog_odnosa')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $prethodno_r_iskustvo = App\Models\DummyModels\PrethodnoRI::where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $prestanak_r_o = DB::table('sluzbenik_prestanak_radnog_odnosa')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $clanovi_porodice = DB::table('sluzbenik_clanovi_porodice')->where('id_sluzbenika', '=', $id_sluzbenika)->get();
        $ukupno_dana = 0;


        foreach ($prethodno_r_iskustvo as $prethodno) {
            $ukupno_dana += ($this->broj_dana_izmedju($prethodno->period_zaposlenja_od, $prethodno->period_zaposlenja_do) * $prethodno->koeficijent / 100);
        }

        foreach ($zasnivanje_r_odnosa as $zasnivanje) {
            $ukupno_dana += $this->broj_dana_izmedju($zasnivanje->datum_zasnivanja_o, Carbon::now());
        }

        /*** Ako je službenik na neplaćenom odsustvu, to treba oduzeti .. ***/
        $neplacenoDana = Odsustva::where('sluzbenik_id', '=', $id_sluzbenika)->where('vrsta_odsustva', '=', 1)->count();
        $ukupno_dana -= $neplacenoDana;


        /*** Ovdje ćemo dobijati ukupni službenika ***/

        $godina = (int)(($ukupno_dana / 30 / 12));
        $mjeseci = (int)(($ukupno_dana / 30) - ($godina * 12));
        $dana = ($ukupno_dana % 30);

        if ($sluzbenik->radno_mjesto != null) {
            $rm_model = RadnoMjesto::where('id', $sluzbenik->radno_mjesto)->first();
            $radno_mjesto = $rm_model->naziv_rm;

            // Ako je službenik vezan za određeno radno mjesto , pri tom mora biti vezan i za određennu
            // organizacionu jedinicu i organ javne uprave

            $organizaciona_jed = OrganizacionaJedinica::where('id', $rm_model->id_oj)->first();
            $organ_ju = Uprava::find(Sluzbenik::organJavneUprave($sluzbenik->id)->first()->id)->naziv;

        } else {
            $radno_mjesto = 'Nema radnog mjesta';
            $organizaciona_jed = "-";
            $organ_ju = "-";
        }


        $spol                   = Sifrarnik::dajSifrarnik('spolovi');
        $kategorija             = Sifrarnik::dajSifrarnik('kategorija');
        $nacionalnost           = Sifrarnik::dajSifrarnik('nacionalnost');
        $bracni_status          = Sifrarnik::dajSifrarnik('bracni_status');
        $vrsta_vjestine         = Sifrarnik::dajSifrarnik('vrsta_vještine');
        $nivo_vjestine          = Sifrarnik::dajSifrarnik('nivo_vjestine');
        $osnov_za_prestanak_rd  = Sifrarnik::dajSifrarnik('osnov_za_prestanak_ro');
        $radno_vrijeme          = Sifrarnik::dajSifrarnik('radno_vrijeme');
        $nacin_zasnivanja       = Sifrarnik::dajSifrarnik('nacin_zasnivanja_ro');
        $vrsta_ro               = Sifrarnik::dajSifrarnik('vrsta_radnog_odnosa');
        $obracunati_staz        = Sifrarnik::dajSifrarnik('obracunati_staz');
        $srodstvo               = Sifrarnik::dajSifrarnik('srodstvo');
        $trenutno_radi          = Sifrarnik::dajSifrarnik('vrsta_radnog_odnosa');
        $kategorija_ispita      = Sifrarnik::dajSifrarnik('kategorija_ispita');

        Session::put('aditional_counter', 0); $pregled = true;

        return view('/hr/sluzbenici/ispis-sluzbenika', compact('id_sluzbenika', 'radno_mjesto', 'organ_ju', 'organizaciona_jed', 'nivo_vjestine', 'vrsta_ro', 'obracunati_staz', 'nacin_zasnivanja', 'sluzbenik', 'prethodno_r_iskustvo', 'podaci_o_prebivalistu', 'strucna_sprema', 'obrazovanje_sluzbenika', 'ispiti', 'kontakt_detalji', 'vjestine', 'zasnivanje_r_odnosa', 'prestanak_r_o', 'clanovi_porodice', 'spol', 'kategorija', 'nacionalnost', 'bracni_status', 'vrsta_vjestine', 'osnov_za_prestanak_rd', 'radno_vrijeme', 'what', 'pregled', 'godina', 'mjeseci', 'dana', 'srodstvo', 'trenutno_radi', 'kategorija_ispita'));
    }


    /***************************************************************************************************************** /
     *
     *      UNESITE SLUŽBENIKA TE OSTALE INFORMACIJE VEZANE ZA NJEGA
     *      - generička metoda
     *      - prima tri parametra, naziv tabele, id sluzbenika i parametre
     *
     *      Parametri requesta moraju biti identični, odnosno ključevi requesta moraju biti identični nazivima
     *      kolona od tabele. U protivnom, bacit će exception, odnosno error.
     *
     * /******************************************************************************************************************/

    public function spremiSadrzaj(Request $request){
        $request = HelpController::formatirajRequest($request);

        if ($request->tabela == 'sluzbenik_podaci_o_prebivalistu') {
            $validatedData = $request->validate([
                'mjesto_prebivalista' => 'required|max:100'
            ]);
        } else if ($request->tabela == 'sluzbenik_strucna_sprema') {
            $validatedData = $request->validate([
                'stepen_s_s' => 'required|max:50',
                'vrsta_s_s' => 'required|max:50',
                'diploma_poslana_na_provjeru' => 'required',
                'komenta_o_diplomi' => 'max:100',
                'obrazovna_institucija' => 'required|max:50',
                'nostrifikacija' => 'required|max:150',
                'datum_zavrsetka' => 'required',
            ]);
        } else if ($request->tabela == 'sluzbenik_ispiti') {
            $validatedData = $request->validate([
                'podkategorija' => 'required|max:50',
                'naziv_ovog_ispita' => 'required|max:256',
                'datum_zavrsetka' => 'required|',
            ]);
        } else if ($request->tabela == 'sluzbenik_kontakt_detalji_osobe') {
            $validatedData = $request->validate([
                'sluzbeni_tel' => 'required|max:50',
                'sluzbeni_mail' => 'required|max:50|email',
                'mobilni_tel' => 'required|max:50',
                'email' => 'required|max:50|email',
            ]);
        } else if ($request->tabela == 'sluzbenik_obrazovanje_sluzbenika') {
            $validatedData = $request->validate([
                'naziv_ustanove' => 'required|max:50',
                'sjediste_ustanove' => 'required|max:50',
                'broj_diplome' => 'required|max:50',
                'vrsta_obrazovanja' => 'required|max:50',
                'datum_izdavanja_dipl' => 'required|max:50',
                'datum_diplomiranja' => 'required|max:50',
                'ciklus_obrazovanja' => 'required|max:50',
                'strucno_zvanje' => 'required|max:50',
                'odsjek' => 'required|max:50',
            ]);
        } else if ($request->tabela == 'sluzbenik_vjestine_sluzbenika') {
            $validatedData = $request->validate([
                'institucija' => 'required|max:50',
                'broj_uvjerenja' => 'required|max:50',
                'datum_uvjerenja' => 'required',
                'komentar' => 'required|max:50',
            ]);
        } else if ($request->tabela == 'sluzbenik_zasnivanje_radnog_odnosa') {
            $validatedData = $request->validate([
                'datum_zasnivanja_o' => 'required',
                'obracunati_r_s_god' => 'required',
                'obracunati_r_s_mje' => 'required',
                'obracunati_r_s_dan' => 'required',
            ]);
        } else if ($request->tabela == 'sluzbenik_prethodno_radno_iskustvo') {
            $validatedData = $request->validate([
                'poslodavac' => 'required|max:50',
                'sjediste_poslodavca' => 'max:50',
                'period_zaposlenja_od' => 'required|max:50',
                'period_zaposlenja_do' => 'required|max:50',
                'radno_vrijeme' => 'max:50',
                'opis_poslova' => 'max:9000',
                'steceno_radno_iskustvo' => 'max:50',
                'ostvareni_radni_staz' => 'max:50',
                'staz_osiguranja' => 'max:50',
                'dobrovoljno_osiguranje' => 'max:50',
                'penzioni_staz' => 'max:50',
                'staz_sa_uvecanim_trajanjem' => 'max:50',
                'drzava_sa_stazom' => 'max:50',
                'trajanje_staza_u_drzavi' => 'max:50',
                'napomena' => 'max:500',
            ]);
        } else if ($request->tabela == 'sluzbenik_prestanak_radnog_odnosa') {
            $validatedData = $request->validate([
                'datum_prestanka' => 'required|max:50',
                'napomena' => 'required|max:10000',
            ]);
        } else if ($request->tabela == 'sluzbenik_clanovi_porodice') {
            $validatedData = $request->validate([
                'datum_rodjenja' => 'required|max:50',
                'srodstvo' => 'required|max:1000',
                'napomena' => 'required|max:10000',
            ]);
        }


        // isset($request->datum_zavrsetka) ? $request['datum_zavrsetka'] = Carbon::createFromFormat('d/m/Y', $request->datum_zavrsetka)->format("Y-m-d") : $request['datum_zavrsetka'] = null;
        try {
            DB::table($request->tabela)->insert(
                $request->except(['tabela', '_token'])
            );
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return back()->withInput(['unos_dijela' => 'Unijeli smo nešto :D ']);


        // return $this->redirektajNaUredjivanje($request->id_sluzbenika)->with('success', __('Uspješno ste dodali novu upravu')); // pozovi metodu koja vraća
    }


    /***************************************************************************************************************** /
     *
     *      IZMIJENITE INFORMACIJE VEZANE ZA SLUŽBENIKA
     *      - generička metoda
     *      - prima tri parametra, naziv tabele, id sluzbenika i parametre
     *
     *      Parametri requesta moraju biti identični, odnosno ključevi requesta moraju biti identični nazivima
     *      kolona od tabele. U protivnom, bacit će exception, odnosno error.
     *
     * /******************************************************************************************************************/

    public function izmijeniSadrzaj(Request $request){
        $request = HelpController::formatirajRequest($request);

        if($request->tabela == 'sluzbenik_prethodno_radno_iskustvo'){
            $ukupno_dana = ($this->broj_dana_izmedju($request->period_zaposlenja_od, $request->period_zaposlenja_do) * $request->koeficijent / 100);

            $godina = (int)(($ukupno_dana / 30 / 12));
            $mjeseci = (int)(($ukupno_dana / 30) - ($godina * 12));
            $dana = ($ukupno_dana % 30);

            $request['radni_staz_godina'] = $godina;
            $request['radni_staz_mjeseci'] = $mjeseci;
            $request['radni_staz_dana'] = $dana;

        }

        if ($request->tabela == 'sluzbenik_podaci_o_prebivalistu') {
            $validatedData = $request->validate([
                'mjesto_prebivalista' => 'required|max:100'
            ]);
        }

        // isset($request->datum_zavrsetka) ? $request['datum_zavrsetka'] = Carbon::createFromFormat('d/m/Y', $request->datum_zavrsetka)->format("Y-m-d") : $request['datum_zavrsetka'] = null;
        try {
            DB::table($request->tabela)->where('id', $request->id)->update(
                $request->except(['tabela', '_token', 'id'])
            );
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return back()->withInput(['izmjena_dijela' => 'Izmijenili smo nešto :D ']);
    }


    /***************************************************************************************************************** /
     *
     *      - brisanje iz bilo koje tabele
     *      - u requestu poslati tri stavke, ID sluzbenika, naziv tabele i ID elementra kojeg briješemo
     *
     * /******************************************************************************************************************/


    public function obrisiSadrzaj(Request $request){
        try{
            $val = DB::table($request->tabela)->delete($request->id);
        }catch (\Exception $e){dd($e);}

//        dd($request->all());
        return back()->withInput(['brisanje_dijela' => 'Izbrisali smo nešto :D ']);
    }


    public function zbirniIZvjestaj(){
        $organi = Organ::with('organizacija.organizacioneJedinice.radnaMjesta.sluzbeniciRel.sluzbenik');

        $organi = FilterController::filter($organi);
        // dd($sluzbenici);

        $filteri = [
            'id' => '#',
            'naziv' => 'Organ javne uprave',
            'pregleeed' => ':: PREGLED ::',
            'ukupno_njih' => 'Ukupno',

            'muskarci'  => 'Muškaraca',
            'zene'      => 'Žena',

            'bosnjo'    => 'Bošnjak',
            'rvat'      => 'Hrvat',
            'srbin'     => 'Srbin',
            'ostalii'   => 'Ostali',

            'vss' => 'VSS',
            'sss.kv.vkv' => 'SSS / KV / VKV',
            'nk' => 'NK',

            'b_ss' => 'SS - Bo',
            'h_ss' => 'SS - Hr',
            's_ss' => 'SS - Sr',
            'o_ss' => 'SS - Os',

            'manje_od_20' => 'manje od 20',
            'od21do25' => '21 - 25',
            'od25do30' => '26 - 30',
            'od30do35' => '31 - 35',
            'od36do40' => '36 - 40',
            'od41do45' => '41 - 45',
            'od46do50' => '46 - 50',
            'od51do56' => '51 - 55',
            'od56do60' => '56 - 60',
            'od61do65' => '61 - 65',
            'viseod60' => 'više od 60',
        ];

        return view('hr.sluzbenici.izvjestaji.zbirni', compact('organi', 'filteri'));
    }

}
