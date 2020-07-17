<?php

namespace App\Http\Controllers;

use App\Models\DummyModels\Ispiti;
use App\Models\DummyModels\Obrazovanje;
use App\Models\DummyModels\Prebivaliste;
use App\Models\DummyModels\StrucnaSprema;
use App\Models\Sifrarnik;
use App\Models\Sluzbenik;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsersController extends Controller{

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
        $ciklus         = Sifrarnik::dajSifrarnik('ciklus_obrazovanja')->prepend('Odaberite ciklus', '');

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
            'ciklus'      => $ciklus
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
        $request->request->add(['datum_rodjenja' => $this->datumRodjenja($request->jmbg)]);

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
        $ciklus    = Sifrarnik::dajSifrarnik('ciklus_obrazovanja')->prepend('Odaberite ciklus', '');


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
        $ciklus       = Sifrarnik::dajSifrarnik('ciklus_obrazovanja')->prepend('Odaberite ciklus', '');

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
}
