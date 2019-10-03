<?php

namespace App\Http\Controllers;
use App\Models\Uloge;
use Illuminate\Support\Facades\Crypt;         /** za enkripciju sesija **/
use Illuminate\Support\Facades\Session;       /** za kreiranje sesija **/

use Illuminate\Http\Request;
use App\Models\Sluzbenik;

class Auth extends Controller{


    public function __construct(){

    }


    /**************************  Ovdje ćemo izvrišiti authentikaciju sa username i šifrom  ****************************/

    public function prijavime(Request $request){
        $username = $request->username;
        $sifra    = $request->sifra;
        $jezik    = $request->jezik;

        $username_greska = ''; $sifra_greska = ''; // koristit ćemo placeholder umjesto greške pa ćemo njega ispisivati
        $username_placeholder = 'Vaš username'; $sifra_placeholder = 'Vaša šifra';
        $username_value = '';                      // Ako se desi da je username tačan, onda ćemo napisati username ali ćemo ostaviti opciju da šifru unese ponovo !

        $good_to_go = false;

        if(empty($username)){
            $username_greska = 'greska'; // postavi crveno polje i indiciraj da je prazno
            $username_placeholder = 'Vaš username ne može biti prazan.';
        }else{
            $sluzbenik = Sluzbenik::where('korisnicko_ime', '=', $username);

            if($sluzbenik -> exists()){
                $username_value = 'found';
            }else{
                // ** ako je pogresan username vrati gresku pogresan ** //
                $username_greska = 'greska';
                $username_placeholder = 'Unijeli ste pogrešan username';
            }
        }

        if(empty($sifra)){
            $sifra_greska = 'greska';     // postavi crveno polje i indiciraj da je prazno
            $sifra_placeholder = 'Vaša šifra ne može biti prazna.';

            if($username_value == 'found') $username_value = $username; // ako je korisnik pronađen, onda treba reći da je okay :D
            else ($username_value = '');
        }else{
            if($username_value == 'found'){
                if($sluzbenik->first()->toArray()['sifra'] == $sifra){
                    $good_to_go = true; // Korisnik je pronađen, šifra i username su validni
                    Session::put('razina', Crypt::encryptString('SIFRA'));  /** Korisnik je unio ispravan username i sifru **/
                    Session::put('temp_id', Crypt::encryptString($sluzbenik->first()->toArray()['id'])); // temp ID samo za auth PINOM // Trebat će je opet postaviti prilikom zaključavanja !!

                    // Ovdje postavljamo odabrani jezik u sesiju //
                    Session::put('jezik', Crypt::encryptString($jezik));
                }else{
                    // ** ako je pogresna sifra, vrati gresku pogresna a pored toga postavi value username-a da se ne mora opet kuckati ** //
                    $sifra_greska = 'greska';

                    if($username_value == 'found') $username_value = $username; // ako je korisnik pronađen, onda treba reći da je okay :D
                    else ($username_value = '');

                    $sifra_placeholder = 'Unijeli ste pogrešnu šifru';
                }
            }
        }

        if($good_to_go){
            return view('/prijava/prvi_stepen', compact('good_to_go')); /** Kada unesemo tačan username i šifru , korisniku je omogućeno da unese PIN kod za nastavak authentikacije **/
        }else return view('/prijava/prvi_stepen', compact('username_greska', 'sifra_greska', 'username_placeholder', 'sifra_placeholder', 'username_value'));
    }





    /************************** Ovdje ćemo izvrišiti authentikaciju za PIN CODE službenika ****************************/
    public function provjeri_pin(Request $request){
        $pin = $request->pin;
        $greska = ''; $good_to_go = true;

        // Provjeri da li je korisnik unio tačno šifru i username -> ako nije, ako pokušava pristupiti ovom linku vrati ga nazad
        if(Session::has('razina')){
            if(Crypt::decryptString(Session::get('razina')) == "SIFRA"){
                $sluzbenik = Sluzbenik::where('id', '=', (int)Crypt::decryptString(Session::get('temp_id')))->first()->toArray();

                $pin_number = $sluzbenik['pin'];
                $id = $sluzbenik['id'];
            }else return redirect('/');
        }else{
            return redirect('/');
        }

        if(empty($pin)){
            $greska = 'Vaš PIN je prazan!';              // pin je prazan i treba tražiti da se unese novi !!
        }else{
            if($pin == $pin_number){ // Unijeli ste tačan pin tako da možemo dalje nastaviti

                Session::put('ID', Crypt::encryptString($id));
                Session::put('razina', Crypt::encryptString('PIN')); /** Korisnik je unio ispravan PIN CODE **/

                Session::forget('temp_id');                    /** Obriši privremeni ID **/

                return redirect('/home');
            }else{
                $greska = "Unijeli ste pogrešan PIN kod !";
            }
        }

        return view('/prijava/prvi_stepen', compact('good_to_go', 'greska'));
    }


    /******************************* Ovdje odjavljujemo službenike, prekidanje sesija *********************************/

    public function odjavi_me(){
        Session::forget('ID');      // Izloguj korisnika
        Session::forget('razina');  // Korisnik je izlogovan u potpunosti

        return redirect('/');
    }

    public function redirektajPrijavu(){
        return redirect('/prijava');
    }


    /********************************************** Rad sa ulogama ****************************************************/
    public function pregledUloga(){
		
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
            'ime_prezime' => 'Ime i prezime',
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
            'PIO' => 'PIO',
            'radnoMjesto.naziv_rm' => 'Radno mjesto',
            'radnoMjesto.orgjed.naziv' => 'Organizaciona jedinica',
            'radnoMjesto.orgjed.organizacija.organ.naziv' => 'Organ javne uprave',
            'radnoMjesto.rukovodioc_s.name' => 'Rukovodioc',
            'prebivaliste.adresa_prebivalista' => 'Adresa boravita',
            'prebivaliste.mjesto_prebivalista' => 'Mjesto prebivališta',
            'prebivaliste.adresa_boravista' => 'Adresa prebivališta',

            'strucna_sprema.stepen_s_s' => 'Stepen stručne spreme',
            'strucna_sprema.obrazovna_institucija' => 'Obrazovna institucija',
        ];
		
		
		
			
        $uloge = true;

        return view('hr.sluzbenici.pregled', compact('sluzbenici', 'uloge', 'filteri'));
    }

    public function dodijeliUlogu($id){
        $sluzbenik = Sluzbenik::where('id', $id)->first();

        $sifra = substr(md5(time()), '0', '10');

        $pin = mt_rand(4000, 9999);

        return view('prijava.dodijelite_uloge', ['id' => $id], compact('sluzbenik', 'sifra', 'pin'));
    }

    public function validirajSifru(Request $request){
        try {
            $sluzbenik = Sluzbenik::where('id', '=', $request->sluzbenik_id)->update([
                'sifra'                        => $request->sifra,
                'pin'                          => $request->pin,
            ]);
            return json_encode(array('code' => '0000', 'message' => 'Uspješno promijenjena šifra'));

        } catch (\Exception $e) {
            return json_encode(array('code' => '8658', 'message' => 'Neuspješno mijenjanje šifre !'));
        }
    }

    public function azurirajUloge(Request $request){
        $request      = $request->all();
        $keyword      = $request['keyword'];
        $sluzbenik_id = $request['sluzbenik_id'];
        $vrijednost   = $request['vrijednost'];


        if(!$sample = Uloge::where('sluzbenik_id',  $sluzbenik_id)->where('keyword', $keyword)->first()){
            $uloga = new Uloge();
            $uloga->keyword      = $keyword;
            $uloga->sluzbenik_id = $sluzbenik_id;
            $uloga->vrijednost   = $vrijednost;
            $uloga->save();
        }else{
            $sample->keyword      = $keyword;
            $sample->sluzbenik_id = $sluzbenik_id;
            $sample->vrijednost   = $vrijednost;
            $sample->save();
        }

        dd($sample);

    }

}
