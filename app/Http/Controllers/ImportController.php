<?php

namespace App\Http\Controllers;

use App\Models\DummyModels\ClanoviPorodice;
use App\Models\DummyModels\Ispiti;
use App\Models\DummyModels\Obrazovanje;
use App\Models\DummyModels\Prebivaliste;
use App\Models\DummyModels\StrucnaSprema;
use App\Models\DummyModels\ZasnivanjeRO;
use App\Models\Organ;
use App\Models\Organizacija;
use App\Models\OrganizacionaJedinica;
use App\Models\RadnoMjesto;
use App\Models\Sifrarnik;
use App\Models\Sluzbenik;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{
    //

    private function clean($string){

        $string = trim($string);
        $string = str_replace(" ", "", $string);
        $string = str_replace("\\", "", $string);
        $string = str_replace("-", "", $string);
        $string = str_replace(".", "", $string);
        $string = str_replace("/", "", $string);
        $string = str_replace("š", "", $string);
        $string = str_replace("�", "", $string);
        $string = str_replace("č", "", $string);
        $string = str_replace("ć", "", $string);
        $string = str_replace("ž", "", $string);
        $string = str_replace("đ", "", $string);
        $string = str_replace("Š", "", $string);
        $string = str_replace("�", "", $string);
        $string = str_replace("Č", "", $string);
        $string = str_replace("Ć", "", $string);
        $string = str_replace("Ž", "", $string);
        $string = str_replace("Đ", "", $string);
        $string = strtolower($string);

        return $string;
    }

    public function handle(){

        $contents = Storage::disk('local')->get('public/podaci.csv');

        $i = 0;
        foreach(explode("\r\n", $contents) as $line){



            if($i == 0){ $i++; continue; }


            $podaci = explode("\\", $line);

            $osoba = new Sluzbenik();

            $osoba->prezime = $podaci[0];
            $osoba->ime_roditelja = $podaci[1];
            $osoba->ime = $podaci[2];
            $osoba->korisnicko_ime = self::clean($podaci[2]). "." . self::clean($podaci[0]) . rand(0,9);
            $osoba->sifra = md5(rand(0,9999));
            $osoba->pin = rand(1000,9999);
            $osoba->jmbg = $podaci[3];

            $nacionalnost = 1;

            if($podaci[4] == "H") {
                $nacionalnost = 2;
            } else if($podaci[4] == "S") {
                $nacionalnost = 3;
            } else if($podaci[4] != "B") {
                $nacionalnost = 4;
            }

            $osoba->nacionalnost = $nacionalnost;
            $osoba->pol = ($podaci[5] == "M") ? 1 : 2;

            if(strtotime($podaci[6])){
                $osoba->datum_rodjenja = Carbon::parse($podaci[6]);
            } else {
                $osoba->datum_rodjenja = Carbon::parse('1900-01-01');
            }

            $osoba->mjesto_rodjenja = $podaci[7];
            $osoba->PIO = $podaci[32];

            if($podaci[38] == 'Mandat'){
                $osoba->trenutno_radi = 3;
            } else if($podaci[38] == 'Neodređeno' or $podaci[38] == 'Neodređeno vrijeme'){
                $osoba->trenutno_radi = 2;
            } else {
                $osoba->trenutno_radi = 1;
            }



            $osoba->save();

            /*
             * TODO: Privremeni premještaj
             */

            // $osoba->privremeni_premjestaj = $podaci[33];

            /*
             * Adresa boravišta
             */

            $boraviste = new Prebivaliste();

            $boraviste->id_sluzbenika = $osoba->id;
            $boraviste->mjesto_prebivalista = "/";
            $boraviste->adresa_boravista = $podaci[9] . "," . $podaci[8];
            // $osoba->adresa = $podaci[9];

            $boraviste->save();

            /*
             * Obrazovanje
             */

            $obrazovanje = new StrucnaSprema();

            $obrazovanje->stepen_s_s = preg_replace('/\s+/', ' ', $podaci[10]);
            $obrazovanje->vrsta_s_s = preg_replace('/\s+/', ' ', $podaci[11]) ;
            $obrazovanje->komenta_o_diplomi = preg_replace('/\s+/', ' ', $podaci[13]);
            $obrazovanje->obrazovna_institucija = preg_replace('/\s+/', ' ', $podaci[12]);
            $obrazovanje->datum_zavrsetka = Carbon::parse("1.1.1800");
            $obrazovanje->nostrifikacija = $podaci[14];
            $obrazovanje->id_sluzbenika = $osoba->id;
            $obrazovanje->save();



            /*
             * Ispit za rad u organima
             */

            $ispit = new Ispiti();
            $ispit->ispit_za_rad = $podaci[15];
            $ispit->pravosudni_isp = $podaci[16];
            $ispit->strucni_isp = $podaci[17];
            $ispit->id_sluzbenika = $osoba->id;
            $ispit->save();

            /*
             * Organ javne uprave, org. jedinica
             */

            $radno_mjesto_org_jedinica = 0;

            if(Organ::where('naziv', '=', $podaci[22])->get()->count() == 0){
                $organ = new Organ();
                $organ->naziv = $podaci[22];
                $organ->tip = 1;
                $organ->save();

                $organizacija = new Organizacija();
                $organizacija->naziv = "Organizacioni plan Import";
                $organizacija->pravilnik = "import";
                $organizacija->oju_id = $organ->id;
                $organizacija->active = 1;
                $organizacija->datum_od = Carbon::parse("06.08.2019.");
                $organizacija->datum_do = Carbon::parse("06.08.2029.");
                $organizacija->save();
            } else {
                $organ = Organ::where('naziv', 'LIKE', '%'. $podaci[22] . '%')->first();
                $organizacija = Organizacija::where('oju_id', '=', $organ->id)->where('active', '=', 1)->first();
            }

            if(OrganizacionaJedinica::where('naziv', '=', $podaci[23])->get()->count() == 0 && trim($podaci[23]) != "-"){
                $pododjeljenje = new OrganizacionaJedinica();
                $pododjeljenje->naziv = $podaci[23];
                $pododjeljenje->org_id = $organizacija->id;

                if(OrganizacionaJedinica::where('org_id', '=', $organizacija->id)->get()->sortBy('broj')->last()){
                    $pododjeljenje->broj = (int) OrganizacionaJedinica::where('org_id', '=', $organizacija->id)->get()->sortBy('broj')->last()->broj + 1;
                } else {
                    $pododjeljenje->broj = 1;
                }

                $pododjeljenje->tip = 1;
                $pododjeljenje->opis = "/";

                $pododjeljenje->save();

                $radno_mjesto_org_jedinica = $pododjeljenje->id;
            } else if(OrganizacionaJedinica::where('naziv', '=', $podaci[23])->get()->count() != 0  && trim($podaci[23]) != "-"){
                $pododjeljenje = OrganizacionaJedinica::where('naziv', '=', $podaci[23])->first();
                $radno_mjesto_org_jedinica = $pododjeljenje->id;
            }


            if(OrganizacionaJedinica::where('naziv', '=', $podaci[24])->get()->count() == 0 && trim($podaci[24]) != "-"){
                $sektor = new OrganizacionaJedinica();
                $sektor->naziv = $podaci[24];
                $sektor->org_id = $organizacija->id;
                $sektor->parent_id = $pododjeljenje->id;
                $sektor->opis = "/";

                $novi_broj = self::increment(OrganizacionaJedinica::where('id', '=', $pododjeljenje->id)->first());
                $sektor->broj = $novi_broj;
                $sektor->tip = 2;

                $sektor->save();

                $radno_mjesto_org_jedinica = $sektor->id;
            } else if(OrganizacionaJedinica::where('naziv', '=', $podaci[24])->get()->count() != 0  && trim($podaci[24]) != "-"){
                $sektor = OrganizacionaJedinica::where('naziv', '=', $podaci[24])->first();
                $radno_mjesto_org_jedinica = $sektor->id;
            }


            if(OrganizacionaJedinica::where('naziv', '=', $podaci[25])->get()->count() == 0  && trim($podaci[25]) != "-"){

                if(empty($sektor)) $sektor = $pododjeljenje;

                $odsjek = new OrganizacionaJedinica();
                $odsjek->naziv = $podaci[25];
                $odsjek->org_id = $organizacija->id;
                $odsjek->parent_id = $sektor->id;

                $novi_broj = self::increment(OrganizacionaJedinica::where('id', '=', $sektor->id)->first());
                $odsjek->broj = $novi_broj;
                $odsjek->tip = 3;

                $odsjek->opis = "/";

                $odsjek->save();

                $radno_mjesto_org_jedinica = $odsjek->id;
            } else if(OrganizacionaJedinica::where('naziv', '=', $podaci[25])->get()->count() != 0  && trim($podaci[25]) != "-"){
                $odsjek = OrganizacionaJedinica::where('naziv', '=', $podaci[25])->first();
                $radno_mjesto_org_jedinica = $odsjek->id;
            }

            if(OrganizacionaJedinica::where('naziv', '=', $podaci[26])->get()->count() == 0 && trim($podaci[26]) != "-"){

                if(empty($odsjek) && !empty($sektor)) $odsjek = $sektor;
                if(empty($odsjek) && empty($sektor)) $odsjek = $pododjeljenje;

                $sluzba = new OrganizacionaJedinica();
                $sluzba->naziv = $podaci[26];
                $sluzba->org_id = $organizacija->id;
                $sluzba->parent_id = $odsjek->id;

                $novi_broj = self::increment(OrganizacionaJedinica::where('id', '=', $odsjek->id)->first());
                $sluzba->broj = $novi_broj;
                $sluzba->tip = 4;

                $sluzba->opis = "/";

                $sluzba->save();

                $radno_mjesto_org_jedinica = $sluzba->id;
            } else if(OrganizacionaJedinica::where('naziv', '=', $podaci[26])->get()->count() != 0  && trim($podaci[26]) != "-"){
                $sluzba = OrganizacionaJedinica::where('naziv', '=', $podaci[26])->first();
                $radno_mjesto_org_jedinica = $sluzba->id;
            }


            /*
             * Radno Mjesto
             */
            $radno_mjesto = new RadnoMjesto();

            $radno_mjesto->naziv_rm = $podaci[18];

            if(self::stringHas($podaci[18], ["sef", "šef", "Šef", "rukovodioc", "Rukovodioc", "rukovodilac", "Rukovodilac", "direktor"])){
                $radno_mjesto->rukovodioc = 1;
            }

            $kategorija = Sifrarnik::dajInstancuByName('kategorija_radnog_mjesta', $podaci[27]);

            if($kategorija == null){

                $daj_zadnji = Sifrarnik::dajSifrarnikCollection('kategorija_radnog_mjesta')->last();
                $novi_zadnji = $daj_zadnji->value++;

                DB::table('sifrarnici')->insert([
                   'type' => 'kategorija_radnog_mjesta',
                   'value' => $novi_zadnji,
                   'name' => $podaci[27],
                ]);
                $radno_mjesto->kategorija_rm = $novi_zadnji;
            } else {

                $radno_mjesto->kategorija_rm = $kategorija->value;
            }

            $radno_mjesto->platni_razred = $podaci[28];
            $radno_mjesto->id_oj = $radno_mjesto_org_jedinica;



            $radno_mjesto->save();

            $osoba->radno_mjesto = $radno_mjesto->id;
            $osoba->save();

            DB::table('radno_mjesto_uslovi')->insert([
                'id_rm' => $radno_mjesto->id,
                'tip' => 1,
                'tekst_uslova' => $podaci[20],
                'vrijednost' => $podaci[19]
            ]);


            /*
             * Zasnivanje radnog odnosa
             */
            $zasnivanje = new ZasnivanjeRO();
            if(strtotime($podaci[29])){
                $zasnivanje->datum_zasnivanja_o = Carbon::parse($podaci[29]);
            } else {
                $zasnivanje->datum_zasnivanja_o = Carbon::now();
            }
            $zasnivanje->id_sluzbenika = $osoba->id;
            $zasnivanje->nacin_zasnivanja_r_o = 1;
            $zasnivanje->vrsta_r_o = 1;
            $zasnivanje->obracunati_r_staz = 0;
            $zasnivanje->obracunati_r_s_god = $podaci[37];
            $zasnivanje->obracunati_r_s_mje = $podaci[36];
            $zasnivanje->obracunati_r_s_dan = $podaci[35];
            $zasnivanje->napomena = $podaci[21]; // kvalifikacija_za_radno_mjesto
            $zasnivanje->save();

            /*
            $osoba->datum_prestanka_radnog_odnosa = $podaci[30];
            $osoba->osnov_prestanka_radnog_odnosa = $podaci[31];
            */

            /*
             * Djeca
             */

            if($podaci[34] != '-'){
                    $clanovi = new ClanoviPorodice();
                    $clanovi->srodstvo = 'Djeca mlađa od 7 godina';
                    $clanovi->datum_rodjenja = Carbon::parse("01.01.1900");
                    $clanovi->napomena = $podaci[34];
                    $clanovi->id_sluzbenika = $osoba->id;
                    $clanovi->save();
            }


            /*
             * Staz
             */

            /*
            $osoba->staz_dan = $podaci[35];
            $osoba->staz_mjesec = $podaci[36];
            $osoba->staz_godina = $podaci[37];
            */

            echo "Importovan " . $osoba->ime . " " . $osoba->prezime;


        }

        return "ok";

    }

    private static function glue($broj){
        $broj = explode(".", $broj);

        if(count($broj) == 1){
            return $broj[0] . ".1";
        }

        $broj[count($broj) - 1] = (int) end($broj) + 1;

        $glue = implode(".", $broj);

        return $glue;
    }

    private static function stringHas($string, $stack){

        foreach($stack as $keyword){
            if(strpos($string, $keyword) !== false){
                return true;
            }
        }

        return false;

    }

    private static function increment($broj){

        $findlast = OrganizacionaJedinica::where('parent_id', '=', $broj->id)->orderBy('id', 'DESC')->first();

        if(!empty($findlast)){
            return self::glue($findlast->broj);
        }

        return self::glue($broj->broj . ".0");

    }
}
