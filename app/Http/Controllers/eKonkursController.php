<?php

namespace App\Http\Controllers;

use App\Models\Sluzbenik;
use DB;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Models\RadnoMjesto;
use App\Models\Sifrarnik;
use PDO;

class eKonkursController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:ekonkurs');
    }

    public function request(Request $request)
    {
        $kategorija = Sifrarnik::dajSifrarnik('kategorija');
        $nacionalnost = Sifrarnik::dajSifrarnik('nacionalnost');
        $bracni_status = Sifrarnik::dajSifrarnik('bracni_status');
        $trenutno_radi = Sifrarnik::dajSifrarnik('trenutno_radi');
        $spol = Sifrarnik::dajSifrarnik('spolovi');


        if ($request->has('request')):

            try {
                $osnovni_podaci_kandidat = self::dajProceduru('[S07].[GetRegistrationPersonBasicInfo]', 'T035C001', $request->get('request'))[0];
            } catch (\Exception $e){
                return redirect(route('ekonkurs.request'))->withErrors(['Ne postoji prijava u eKonkurs sistemu!']);
            }


            $sluzbenik = new Sluzbenik();

            /*
             * Ime i prezime, e-mail
             */

            $sluzbenik->ime = $osnovni_podaci_kandidat->ime;
            $sluzbenik->prezime = $osnovni_podaci_kandidat->prezime;
            $sluzbenik->korisnicko_ime = HelpController::generateUsername($osnovni_podaci_kandidat->ime, $osnovni_podaci_kandidat->prezime);
            $sluzbenik->email = $osnovni_podaci_kandidat->email;
            $sluzbenik->jmbg = $osnovni_podaci_kandidat->jmbg;
            $sluzbenik->ime_roditelja = $osnovni_podaci_kandidat->imeJednogRoditelja;
            $sluzbenik->nacionalnost = $osnovni_podaci_kandidat->idNacionalnost;
            $sluzbenik->mjesto_rodjenja = $osnovni_podaci_kandidat->mjestoRodjenja;
            $sluzbenik->datum_rodjenja = $osnovni_podaci_kandidat->datumRodjenja;
            $sluzbenik->licna_karta = $osnovni_podaci_kandidat->brojLK;
            $sluzbenik->mjesto_izdavanja_lk = $osnovni_podaci_kandidat->organIzdavanjaLK;


            /*
             * Spol
             */

            if ($osnovni_podaci_kandidat->pol == "M") {
                $sluzbenik->pol = 1;
            } else {
                $sluzbenik->pol = 2;
            }

        else:
            $sluzbenik = null;
        endif;


        return view('ekonkurs.request')->with(compact('sluzbenik', 'kategorija', 'nacionalnost', 'bracni_status', 'spol', 'trenutno_radi'));
    }

    public function historija()
    {
        return view('ekonkurs.request');
    }


    public static function dajProceduru($procedura = '', $kolona = '', $value = '')
    {

        $response = DB::connection('ekonkurs')->select(DB::connection('ekonkurs')->raw("exec $procedura :$kolona, :langId"), [
            ':' . $kolona => $value,
            ':langId' => 1,
        ]);

        return $response;
    }

}
