<?php

namespace App\Http\Controllers;

use App\Models\DummyModels\ClanoviPorodice;
use App\Models\DummyModels\Ispiti;
use App\Models\DummyModels\Obrazovanje;
use App\Models\DummyModels\Prebivaliste;
use App\Models\DummyModels\PrestanakRO;
use App\Models\DummyModels\PrethodnoRI;
use App\Models\DummyModels\StrucnaSprema;
use App\Models\DummyModels\Vjestine;
use App\Models\DummyModels\ZasnivanjeRO;
use App\Models\Sifrarnik;
use App\Models\Sluzbenik;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsersController extends Controller{
    protected $vrsta_staza = [
        ''  => 'Odaberite vrstu radnog staža',
        '1' => 'Radni staž',
        '2' => 'Staž osiguranja',
        '3' => 'Penzioni staž',
        '4' => 'Dobrovoljno osiguranje',
        '5' => 'Staž sa uvećanim trajanjem'
    ];
    protected $staz_ = [
        ''  => 'Nema staža sa uvećanim trajanjem',
        '1' => '12/14',
        '2' => '12/15',
        '3' => '12/16'
    ];

    public function dodajSluzbenika(){
        $kategorija     = Sifrarnik::dajSifrarnik('kategorija');
        $nacionalnost   = Sifrarnik::dajSifrarnik('nacionalnost');
        $bracni_status  = Sifrarnik::dajSifrarnik('bracni_status');
        $trenutno_radi  = Sifrarnik::dajSifrarnik('vrsta_radnog_odnosa');
        $spol           = Sifrarnik::dajSifrarnik('spolovi')->prepend('Odaberite pol');
        $pio            = Sifrarnik::dajSifrarnik('pio')->prepend('Odaberite PIO');
        $domena         = Sifrarnik::dajSifrarnik('ekstenzija_domene')->prepend('Izaberite domenu', '0');
        $drzava                 = Sifrarnik::dajSifrarnik('drzava')->prepend('Odaberite državljanstvo');

        return view('hr.sluzbenici.new.forme.dodaj-sluzbenika', [
            'kategorija' => $kategorija,
            'nacionalnost' => $nacionalnost,
            'bracni_status' => $bracni_status,
            'trenutno_radi' => $trenutno_radi,
            'spol' => $spol,
            'pio' => $pio,
            'domena' => $domena,
            'drzava' => $drzava
        ]);
    }

    protected function korisnickoIme($ime, $prezime) {
        $ime = Str::slug($ime);
        $prezime  = Str::slug($prezime);
        $korisnicko_ime = $ime.'.'.$prezime;

        try{
            $sluz = Sluzbenik::where('korisnicko_ime', 'like', '%'.$korisnicko_ime.'%')->count();
            if($sluz){
                return $korisnicko_ime.$sluz;
            }
        }catch (\Exception $e){}

        return $korisnicko_ime;
    }
    protected function datumRodjenja($JMBG){
        $dan    = (int)$JMBG[0].$JMBG[1];
        $mjesec = (int)$JMBG[2].$JMBG[3];
        $godina = (int)$JMBG[4].$JMBG[5].$JMBG[6];
        if($godina > 100) $godina = '1'.$JMBG[4].$JMBG[5].$JMBG[6];
        else $godina = '2'.$JMBG[4].$JMBG[5].$JMBG[6];

        return $godina.'-'.$mjesec.'-'.$dan;
    }

    // ** Unos, pregled, ažuriranje službenika !! ** //

    public function spremiSluzbenika(Request $request){
        $domena = Sifrarnik::dajSifrarnik('ekstenzija_domene');

        $request->request->add(['korisnicko_ime' => $this->korisnickoIme($request->ime, $request->prezime)]);
        $request->request->add(['email' => $request->korisnicko_ime.$domena[$request->ekstenzija]]);
        $request->request->add(['ime_prezime' => $request->prezime.' '.$request->ime]);
        $request->request->add(['datum_rodjenja' => $this->datumRodjenja($request->jmbg)]);

        try{
            $sluzbenik = Sluzbenik::create(
                $request->except(['_token', 'ekstenzija'])
            );
        }catch (\Exception $e){dd($e);}

        return redirect()->route('sluzbenik.pregled');
    }
    public function pregledSluzbenika($id){
        $kategorija     = Sifrarnik::dajSifrarnik('kategorija');
        $nacionalnost   = Sifrarnik::dajSifrarnik('nacionalnost');
        $bracni_status  = Sifrarnik::dajSifrarnik('bracni_status');
        $trenutno_radi  = Sifrarnik::dajSifrarnik('vrsta_radnog_odnosa');
        $spol           = Sifrarnik::dajSifrarnik('spolovi')->prepend('Odaberite pol');
        $pio            = Sifrarnik::dajSifrarnik('pio')->prepend('Odaberite PIO');
        $domena         = Sifrarnik::dajSifrarnik('ekstenzija_domene')->prepend('Izaberite domenu', '0');
        $drzava                 = Sifrarnik::dajSifrarnik('drzava')->prepend('Odaberite državljanstvo');

        $sluzbenik = Sluzbenik::where('id', $id)->first();

        // ** Prebivališta ** //
        $prebivalista   = Prebivaliste::where('id_sluzbenika', $id)->get();

        // ** Stručna sprema ** //
        $strucne_spreme = StrucnaSprema::where('id_sluzbenika', $id)->get();
        $stepen_ss      = Sifrarnik::dajSifrarnik('stepen')->prepend('Odaberite stručnu spremu', '');
        $ob_inst        = Sifrarnik::dajSifrarnik('obrazovna_institucija')->prepend('Odaberite obrazovnu instituciju', '');
        $da_ne          = Sifrarnik::dajSifrarnik('da_ne');

        // Ispiti
        $ispiti         = Ispiti::where('id_sluzbenika', $id)->get();
        $ispit_k        = Sifrarnik::dajSifrarnik('kategorija_ispita')->prepend('Odaberite kategoriju ispita', '');

        // Obrazovanje službenika
        $obrazovanja    =  Obrazovanje::where('id_sluzbenika', $id)->get();
        $ustanova       = Sifrarnik::dajSifrarnik('obrazovna_institucija')->prepend('Odaberite ustanovu', '');
        $ciklus         = Sifrarnik::dajSifrarnik('stepen')->prepend('Odaberite ciklus', '');

        // Dodatne vještine
        $vjestine       = Vjestine::where('id_sluzbenika', $id)->get();
        $vrsta_vje      = Sifrarnik::dajSifrarnik('vrsta_vještine')->prepend('Odaberite vrstu vještine', '');
        $nivo_vje       = Sifrarnik::dajSifrarnik('nivo_vjestine')->prepend('Odaberite nivo vještine', '');

        // Članovi porodice
        $clanovi_por    = ClanoviPorodice::where('id_sluzbenika', $id)->get();
        $srodstvo       = Sifrarnik::dajSifrarnik('srodstvo')->prepend('Odaberite srodstvo', '');

        // Radni staž kod prethodnih poslodavaca
        $prethodniRS = PrethodnoRI::where('id_sluzbenika', $id)->get();
        $poslodavac  = Sifrarnik::dajSifrarnik('poslodavac')->prepend('Odaberite poslodavca', '');
        $radno_vr    = Sifrarnik::dajSifrarnik('radno_vrijeme')->prepend('Odaberite radno vrijeme');
        $vrsta_staza = $this->vrsta_staza;
        $staz        = $this->staz_;

        // Zasnivanje radnog odnosa
        $zasnivanjeRO = ZasnivanjeRO::where('id_sluzbenika', $id)->get();
        $vrsta_ro     = Sifrarnik::dajSifrarnik('vrsta_radnog_odnosa')->prepend('Odaberite vrstu radnog odnosa', '');
        $nacin_zas    = Sifrarnik::dajSifrarnik('nacin_zasnivanja_ro')->prepend('Odaberite način zasnivanja radnog odnosa');
        $radno_vr     = Sifrarnik::dajSifrarnik('radno_vrijeme')->prepend('Odaberite radno vrijeme');

        // Prestanak radnog odnosa
        $prestanci = PrestanakRO::where('id_sluzbenika', $id)->get();
        $osnov     = Sifrarnik::dajSifrarnik('osnov_za_prestanak_ro')->prepend('Odaberite osnov za prestanak', '');

        return view('hr.sluzbenici.new.pregled-sluzbenika', [
            'kategorija' => $kategorija,
            'nacionalnost' => $nacionalnost,
            'bracni_status' => $bracni_status,
            'trenutno_radi' => $trenutno_radi,
            'spol' => $spol,
            'pio' => $pio,
            'domena' => $domena,
            'drzava' => $drzava,
            'sluzbenik' => $sluzbenik,
            'preview' => true,
            'prebivalista' => $prebivalista,
            'strucne_spreme' => $strucne_spreme,
            'stepen_ss' => $stepen_ss,
            'ob_inst'   => $ob_inst,
            'da_ne'     => $da_ne,
            'ispiti'    => $ispiti,
            'ispit_k'   => $ispit_k,
            'obrazovanja' => $obrazovanja,
            'ustanova'    => $ustanova,
            'ciklus'      => $ciklus,
            'vjestine'    => $vjestine,
            'vrsta_vje'   => $vrsta_vje,
            'nivo_vje'    => $nivo_vje,
            'clanovi_por' => $clanovi_por,
            'srodstvo'    => $srodstvo,
            'prethodniRS' => $prethodniRS,
            'poslodavac'  => $poslodavac,
            'radno_vr'    => $radno_vr,
            'vrsta_staza' => $vrsta_staza,
            'staz'        => $staz,
            'zasnivanjeRO' => $zasnivanjeRO,
            'vrsta_ro' => $vrsta_ro,
            'nacin_zas' => $nacin_zas,
            'prestanci' => $prestanci,
            'osnov' => $osnov,
            'pregled' => true
        ]);
    }
    public function urediteSluzbenika($id){
        $kategorija     = Sifrarnik::dajSifrarnik('kategorija');
        $nacionalnost   = Sifrarnik::dajSifrarnik('nacionalnost');
        $bracni_status  = Sifrarnik::dajSifrarnik('bracni_status');
        $trenutno_radi  = Sifrarnik::dajSifrarnik('vrsta_radnog_odnosa');
        $spol           = Sifrarnik::dajSifrarnik('spolovi')->prepend('Odaberite pol');
        $pio            = Sifrarnik::dajSifrarnik('pio')->prepend('Odaberite PIO');
        $domena         = Sifrarnik::dajSifrarnik('ekstenzija_domene')->prepend('Izaberite domenu', '0');
        $drzava                 = Sifrarnik::dajSifrarnik('drzava')->prepend('Odaberite državljanstvo');

        $sluzbenik = Sluzbenik::where('id', $id)->first();

        return view('hr.sluzbenici.new.forme.dodaj-sluzbenika', [
            'kategorija' => $kategorija,
            'nacionalnost' => $nacionalnost,
            'bracni_status' => $bracni_status,
            'trenutno_radi' => $trenutno_radi,
            'spol' => $spol,
            'pio' => $pio,
            'domena' => $domena,
            'drzava' => $drzava,
            'sluzbenik' => $sluzbenik,
            'edit' => true
        ]);
    }
    public function azurirajteSluzbenika(Request $request){
        $request->request->add(['korisnicko_ime' => $this->korisnickoIme($request->ime, $request->prezime)]);
        $request->request->add(['ime_prezime' => $request->prezime.' '.$request->ime]);
        $request->request->add(['datum_rodjenja' => date("Y-m-d", strtotime($this->datumRodjenja($request->jmbg)))]);

        try{
            $sluzbenik = Sluzbenik::where('id', $request->id)->update(
                $request->except(['_token', 'id'])
            );
        }catch (\Exception $e){dd($e);}

        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id]);
    }


    // -------------------------------------------------------------------------------------------------------------- //
    // ** Podaci o prebivalištu ** //

    public function dodajPrebivaliste($sl_id){
        $sluzbenik = Sluzbenik::where('id', $sl_id)->first();

        return view('hr.sluzbenici.new.forme.prebivaliste', [
            'sluzbenik' => $sluzbenik
        ]);
    }
    public function spremiPrebivaliste(Request $request){
        $request = HelpController::formatirajRequest($request);
        try{
            $prebivaliste = Prebivaliste::create(
                $request->except(['_token'])
            );
        }catch (\Exception $e){dd($e);}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function urediPrebivaliste($id){
        $prebivaliste = Prebivaliste::where('id', $id)->first();
        $sluzbenik = Sluzbenik::where('id', $prebivaliste->id_sluzbenika)->first();

        return view('hr.sluzbenici.new.forme.prebivaliste', [
            'sluzbenik' => $sluzbenik,
            'prebivaliste' => $prebivaliste,
            'edit' => true
        ]);
    }
    public function azurirajPrebivaliste(Request $request){
        $request = HelpController::formatirajRequest($request);
        try{
            $prebivaliste = Prebivaliste::where('id', $request->id)->update(
                $request->except(['_token', 'id'])
            );
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function obrisiPrebivaliste($id){
        try{
            $prebivaliste = Prebivaliste::where('id', $id)->first();

            $sluzbenik_id = $prebivaliste->id_sluzbenika;
            $prebivaliste->delete();
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $sluzbenik_id]);
    }

    // -------------------------------------------------------------------------------------------------------------- //
    // ** Podaci o stručnoj spremi ** //
    public function dodajStrucnuSpremu($sl_id){
        $sluzbenik = Sluzbenik::where('id', $sl_id)->first();
        $stepen_ss = Sifrarnik::dajSifrarnik('stepen')->prepend('Odaberite stručnu spremu', '');
        $ob_inst   = Sifrarnik::dajSifrarnik('obrazovna_institucija')->prepend('Odaberite obrazovnu instituciju', '');
        $da_ne     = Sifrarnik::dajSifrarnik('da_ne');


        return view('hr.sluzbenici.new.forme.strucna-sprema', [
            'sluzbenik' => $sluzbenik,
            'stepen_ss' => $stepen_ss,
            'ob_inst'   => $ob_inst,
            'da_ne'     => $da_ne
        ]);
    }
    public function spremiStrucnuSpremu (Request $request){
        $request = HelpController::formatirajRequest($request);
        try{
            $strucna_sprema = StrucnaSprema::create(
                $request->except(['_token'])
            );
        }catch (\Exception $e){}

        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function urediStrucnuSpremu($id){
        $strucna_sprema = StrucnaSprema::where('id', $id)->first();
        $sluzbenik      = Sluzbenik::where('id', $strucna_sprema->id_sluzbenika)->first();
        $stepen_ss = Sifrarnik::dajSifrarnik('stepen')->prepend('Odaberite stručnu spremu', '');
        $ob_inst   = Sifrarnik::dajSifrarnik('obrazovna_institucija')->prepend('Odaberite obrazovnu instituciju', '');
        $da_ne     = Sifrarnik::dajSifrarnik('da_ne');

        return view('hr.sluzbenici.new.forme.strucna-sprema', [
            'strucna_sprema' => $strucna_sprema,
            'sluzbenik' => $sluzbenik,
            'stepen_ss' => $stepen_ss,
            'ob_inst'   => $ob_inst,
            'da_ne'     => $da_ne,
            'edit'      => true
        ]);
    }
    public function azurirajStrucnuSpremu(Request $request){
        $request = HelpController::formatirajRequest($request);
        try{
            $strucna_sprema = StrucnaSprema::where('id', $request->id)->update(
                $request->except(['_token', 'id'])
            );
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function obrisiStrucnuSpremu($id){
        try{
            $strucna_sprema = StrucnaSprema::where('id', $id)->first();

            $sluzbenik_id   = $strucna_sprema->id_sluzbenika;
            $strucna_sprema->delete();
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $sluzbenik_id]);
    }

    // -------------------------------------------------------------------------------------------------------------- //
    // ** Položeni ispiti ** //
    public function dodajIspit($sl_id){
        $sluzbenik = Sluzbenik::where('id', $sl_id)->first();
        $ispit_k   = Sifrarnik::dajSifrarnik('kategorija_ispita')->prepend('Odaberite kategoriju ispita', '');

        return view('hr.sluzbenici.new.forme.ispiti', [
            'sluzbenik' => $sluzbenik,
            'ispit_k' => $ispit_k
        ]);
    }
    public function spremiIspit(Request $request){
        $request = HelpController::formatirajRequest($request);
        try{
            $ispit = Ispiti::create(
                $request->except(['_token'])
            );
        }catch (\Exception $e){}

        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function urediIspit($id){
        $ispit     = Ispiti::where('id', $id)->first();
        $sluzbenik      = Sluzbenik::where('id', $ispit->id_sluzbenika)->first();
        $ispit_k   = Sifrarnik::dajSifrarnik('kategorija_ispita')->prepend('Odaberite kategoriju ispita', '');

        return view('hr.sluzbenici.new.forme.ispiti', [
            'ispit'     => $ispit,
            'sluzbenik' => $sluzbenik,
            'ispit_k'   => $ispit_k,
            'edit'      => true
        ]);
    }
    public function azurirajIspit(Request $request){
        $request = HelpController::formatirajRequest($request);
        try{
            $ispit = Ispiti::where('id', $request->id)->update(
                $request->except(['_token', 'id'])
            );
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function obrisiIspit($id){
        try{
            $ispit = Ispiti::where('id', $id)->first();

            $sluzbenik_id   = $ispit->id_sluzbenika;
            $ispit->delete();
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $sluzbenik_id]);
    }

    // -------------------------------------------------------------------------------------------------------------- //
    // ** Obrazovanje službenika ** //
    public function dodajObrazovanje($sl_id){
        $sluzbenik = Sluzbenik::where('id', $sl_id)->first();
        $ustanova  = Sifrarnik::dajSifrarnik('obrazovna_institucija')->prepend('Odaberite ustanovu', '');
        $ciklus    = Sifrarnik::dajSifrarnik('stepen')->prepend('Odaberite ciklus', '');


        return view('hr.sluzbenici.new.forme.obrazovanje', [
            'sluzbenik' => $sluzbenik,
            'ustanova'  => $ustanova,
            'ciklus'    => $ciklus
        ]);
    }
    public function spremiObrazovanje(Request $request){
        $request = HelpController::formatirajRequest($request);
        try{
            $ispit = Obrazovanje::create(
                $request->except(['_token'])
            );
        }catch (\Exception $e){}

        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function urediObrazovanje($id){
        $obrazovanje  = Obrazovanje::where('id', $id)->first();
        $sluzbenik    = Sluzbenik::where('id', $obrazovanje->id_sluzbenika)->first();
        $ustanova     = Sifrarnik::dajSifrarnik('obrazovna_institucija')->prepend('Odaberite ustanovu', '');
        $ciklus       = Sifrarnik::dajSifrarnik('stepen')->prepend('Odaberite ciklus', '');

        return view('hr.sluzbenici.new.forme.obrazovanje', [
            'obrazovanje' => $obrazovanje,
            'sluzbenik'   => $sluzbenik,
            'ustanova'    => $ustanova,
            'ciklus'      => $ciklus,
            'edit'        => true
        ]);
    }
    public function azurirajObrazovanje(Request $request){
        $request = HelpController::formatirajRequest($request);
        try{
            $obrazovanje = Obrazovanje::where('id', $request->id)->update(
                $request->except(['_token', 'id'])
            );
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function obrisiObrazovanje($id){
        try{
            $obrazovanje = Obrazovanje::where('id', $id)->first();

            $sluzbenik_id   = $obrazovanje->id_sluzbenika;
            $obrazovanje->delete();
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $sluzbenik_id]);
    }

    // -------------------------------------------------------------------------------------------------------------- //
    // ** Dodatne vještine ** //
    public function dodajVjestine($sl_id){
        $sluzbenik = Sluzbenik::where('id', $sl_id)->first();
        $vrsta_vje = Sifrarnik::dajSifrarnik('vrsta_vještine')->prepend('Odaberite vrstu vještine', '');
        $nivo_vje  = Sifrarnik::dajSifrarnik('nivo_vjestine')->prepend('Odaberite nivo vještine', '');


        return view('hr.sluzbenici.new.forme.vjestine', [
            'sluzbenik' => $sluzbenik,
            'vrsta_vje' => $vrsta_vje,
            'nivo_vje'  => $nivo_vje
        ]);
    }
    public function spremiVjestine(Request $request){
        $request = HelpController::formatirajRequest($request);
        try{
            $ispit = Vjestine::create(
                $request->except(['_token'])
            );
        }catch (\Exception $e){}

        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function urediVjestine($id){
        $vjestina  = Vjestine::where('id', $id)->first();
        $sluzbenik = Sluzbenik::where('id', $vjestina->id_sluzbenika)->first();
        $vrsta_vje = Sifrarnik::dajSifrarnik('vrsta_vještine')->prepend('Odaberite vrstu vještine', '');
        $nivo_vje  = Sifrarnik::dajSifrarnik('nivo_vjestine')->prepend('Odaberite nivo vještine', '');

        return view('hr.sluzbenici.new.forme.vjestine', [
            'vjestina'  => $vjestina,
            'sluzbenik' => $sluzbenik,
            'vrsta_vje' => $vrsta_vje,
            'nivo_vje'  => $nivo_vje,
            'edit'      => true
        ]);
    }
    public function azurirajVjestine(Request $request){
        $request = HelpController::formatirajRequest($request);
        try{
            $vjestine = Vjestine::where('id', $request->id)->update(
                $request->except(['_token', 'id'])
            );
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function obrisiVjestine($id){
        try{
            $vjestine = Vjestine::where('id', $id)->first();

            $sluzbenik_id   = $vjestine->id_sluzbenika;
            $vjestine->delete();
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $sluzbenik_id]);
    }

    // -------------------------------------------------------------------------------------------------------------- //
    // ** Članovi porodice ** //
    public function dodajClanoviPorodice($sl_id){
        $sluzbenik = Sluzbenik::where('id', $sl_id)->first();
        $srodstvo = Sifrarnik::dajSifrarnik('srodstvo')->prepend('Odaberite srodstvo', '');

        return view('hr.sluzbenici.new.forme.clanovi-porodice', [
            'sluzbenik' => $sluzbenik,
            'srodstvo'  => $srodstvo
        ]);
    }
    public function spremiClanoviPorodice(Request $request){
        $request = HelpController::formatirajRequest($request);
        try{
            $clan = ClanoviPorodice::create(
                $request->except(['_token'])
            );
        }catch (\Exception $e){dd($e);}

        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function urediClanoviPorodice($id){
        $clan_porodice = ClanoviPorodice::where('id', $id)->first();
        $sluzbenik     = Sluzbenik::where('id', $clan_porodice->id_sluzbenika)->first();
        $srodstvo      = Sifrarnik::dajSifrarnik('srodstvo')->prepend('Odaberite srodstvo', '');

        return view('hr.sluzbenici.new.forme.clanovi-porodice', [
            'clan_porodice' => $clan_porodice,
            'sluzbenik' => $sluzbenik,
            'srodstvo'  => $srodstvo,
            'edit' => true
        ]);
    }
    public function azurirajClanoviPorodice(Request $request){
        $request = HelpController::formatirajRequest($request);
        try{
            $clanovi = ClanoviPorodice::where('id', $request->id)->update(
                $request->except(['_token', 'id'])
            );
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function obrisiClanoviPorodice($id){
        try{
            $clan = ClanoviPorodice::where('id', $id)->first();

            $sluzbenik_id   = $clan->id_sluzbenika;
            $clan->delete();
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $sluzbenik_id]);
    }

    // -------------------------------------------------------------------------------------------------------------- //
    // ** Radni staž kod prethodnih poslodavaca ** //
    public function dodajPrethodniRS($sl_id){
        $sluzbenik   = Sluzbenik::where('id', $sl_id)->first();
        $poslodavac  = Sifrarnik::dajSifrarnik('poslodavac')->prepend('Odaberite poslodavca', '');
        $radno_vr    = Sifrarnik::dajSifrarnik('radno_vrijeme')->prepend('Odaberite radno vrijeme');
        $vrsta_staza = $this->vrsta_staza;
        $staz        = $this->staz_;


        return view('hr.sluzbenici.new.forme.prethodni-rs', [
            'sluzbenik' => $sluzbenik,
            'poslodavac' => $poslodavac,
            'radno_vr' => $radno_vr,
            'vrsta_staza' => $vrsta_staza,
            'staz' => $staz
        ]);
    }
    public function spremiPrethodniRS(Request $request){
        $request = HelpController::formatirajRequest($request);

        try{
            $prethodniRS = PrethodnoRI::create(
                $request->except(['_token'])
            );
        }catch (\Exception $e){dd($e);}

        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function urediPrethodniRS($id){
        $prethodni     = PrethodnoRI::where('id', $id)->first();
        $sluzbenik     = Sluzbenik::where('id', $prethodni->id_sluzbenika)->first();
        $poslodavac  = Sifrarnik::dajSifrarnik('poslodavac')->prepend('Odaberite poslodavca', '');
        $radno_vr    = Sifrarnik::dajSifrarnik('radno_vrijeme')->prepend('Odaberite radno vrijeme');
        $vrsta_staza = $this->vrsta_staza;
        $staz        = $this->staz_;

        return view('hr.sluzbenici.new.forme.prethodni-rs', [
            'prethodni'   => $prethodni,
            'poslodavac'  => $poslodavac,
            'radno_vr'    => $radno_vr,
            'vrsta_staza' => $vrsta_staza,
            'staz' => $staz,
            'sluzbenik' => $sluzbenik,
            'edit' => true
        ]);
    }
    public function azurirajPrethodniRS(Request $request){
        $request = HelpController::formatirajRequest($request);
        try{
            $prethodno_ri = PrethodnoRI::where('id', $request->id)->update(
                $request->except(['_token', 'id'])
            );
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function obrisiPrethodniRS($id){
        try{
            $prethodni = PrethodnoRI::where('id', $id)->first();

            $sluzbenik_id   = $prethodni->id_sluzbenika;
            $prethodni->delete();
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $sluzbenik_id]);
    }

    // -------------------------------------------------------------------------------------------------------------- //
    // ** Zasnivanje radnog odnosa ** //
    public function dodajZasnivanjeRO($sl_id){
        $sluzbenik   = Sluzbenik::where('id', $sl_id)->first();
        $vrsta_ro    = Sifrarnik::dajSifrarnik('vrsta_radnog_odnosa')->prepend('Odaberite vrstu radnog odnosa', '');
        $nacin_zas   = Sifrarnik::dajSifrarnik('nacin_zasnivanja_ro')->prepend('Odaberite način zasnivanja radnog odnosa');
        $radno_vr    = Sifrarnik::dajSifrarnik('radno_vrijeme')->prepend('Odaberite radno vrijeme');

        return view('hr.sluzbenici.new.forme.zasnivanje-ro', [
            'sluzbenik' => $sluzbenik,
            'vrsta_ro' => $vrsta_ro,
            'nacin_zas' => $nacin_zas,
            'radno_vr'  => $radno_vr
        ]);
    }
    public function spremiZasnivanjeRO(Request $request){
        $request = HelpController::formatirajRequest($request);

        try{
            $zasnivanje = ZasnivanjeRO::create(
                $request->except(['_token'])
            );
        }catch (\Exception $e){dd($e);}

        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function urediZasnivanjeRO($id){
        $radni_odnos = ZasnivanjeRO::where('id', $id)->first();
        $sluzbenik   = Sluzbenik::where('id', $radni_odnos->id_sluzbenika)->first();
        $vrsta_ro    = Sifrarnik::dajSifrarnik('vrsta_radnog_odnosa')->prepend('Odaberite vrstu radnog odnosa', '');
        $nacin_zas   = Sifrarnik::dajSifrarnik('nacin_zasnivanja_ro')->prepend('Odaberite način zasnivanja radnog odnosa');
        $radno_vr    = Sifrarnik::dajSifrarnik('radno_vrijeme')->prepend('Odaberite radno vrijeme');

        return view('hr.sluzbenici.new.forme.zasnivanje-ro', [
            'sluzbenik' => $sluzbenik,
            'vrsta_ro' => $vrsta_ro,
            'nacin_zas' => $nacin_zas,
            'radno_vr'  => $radno_vr,
            'radni_odnos' => $radni_odnos,
            'edit' => true
        ]);
    }
    public function azurirajZasnivanjeRO(Request $request){
        $request = HelpController::formatirajRequest($request);
        try{
            $zasnivanje = ZasnivanjeRO::where('id', $request->id)->update(
                $request->except(['_token', 'id'])
            );
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function obrisiZasnivanjeRO($id){
        try{
            $zasnivanje = ZasnivanjeRO::where('id', $id)->first();

            $sluzbenik_id   = $zasnivanje->id_sluzbenika;
            $zasnivanje->delete();
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $sluzbenik_id]);
    }

    // -------------------------------------------------------------------------------------------------------------- //
    // ** Prestanak radnog odnosa ** //
    public function dodajPrestanakRO($sl_id){
        $sluzbenik = Sluzbenik::where('id', $sl_id)->first();
        $osnov     = Sifrarnik::dajSifrarnik('osnov_za_prestanak_ro')->prepend('Odaberite osnov za prestanak', '');

        return view('hr.sluzbenici.new.forme.prestanak-ro', [
            'sluzbenik' => $sluzbenik,
            'osnov' => $osnov
        ]);
    }
    public function spremiPrestanakRO(Request $request){
        $request = HelpController::formatirajRequest($request);

        try{
            $prestanak = PrestanakRO::create(
                $request->except(['_token'])
            );
        }catch (\Exception $e){dd($e);}

        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function urediPrestanakRO($id){
        $prestanak = PrestanakRO::where('id', $id)->first();
        $sluzbenik = Sluzbenik::where('id', $prestanak->id_sluzbenika)->first();
        $osnov     = Sifrarnik::dajSifrarnik('osnov_za_prestanak_ro')->prepend('Odaberite osnov za prestanak', '');

        return view('hr.sluzbenici.new.forme.prestanak-ro', [
            'prestanak' => $prestanak,
            'sluzbenik' => $sluzbenik,
            'osnov' => $osnov,
            'edit' => true
        ]);
    }
    public function azurirajPrestanakRO(Request $request){
        $request = HelpController::formatirajRequest($request);
        try{
            $prestanak = PrestanakRO::where('id', $request->id)->update(
                $request->except(['_token', 'id'])
            );
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $request->id_sluzbenika]);
    }
    public function obrisiPrestanakRO($id){
        try{
            $prestanak = PrestanakRO::where('id', $id)->first();

            $sluzbenik_id   = $prestanak->id_sluzbenika;
            $prestanak->delete();
        }catch (\Exception $e){}
        return redirect()->route('drzavni-sluzbenici.pregled-sluzbenika', ['id' => $sluzbenik_id]);
    }
}
